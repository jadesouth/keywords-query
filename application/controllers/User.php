<?php

/**
 * Created by PhpStorm.
 * User: haokaiyang
 * Date: 2016/11/20
 * Time: 上午10:43
 */
class User extends Home_Controller
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if(!in_array($this->router->method,['ajax_register', 'ajax_login']) && empty($this->_loginUser)){
            redirect('/');
        }
    }
    /**
     * ajax_register
     * 用户注册
     *
     * @author haokaiyang
     * @date   2016-11-20 22:13:55
     */
    public function ajax_register()
    {
        $this->load->library('form_validation');
        if (false === $this->form_validation->run()) {
            http_ajax_response(1, $this->form_validation->error_string());
        } else {
            $user_info['login_name'] = $this->input->post('login_name',true);
            $user_info['password'] = $this->input->post('password',true);
            $user_info['con_password'] = $this->input->post('con_password',true);
            $user_id = $this->_model->add_user($user_info);
            if (! empty($user_id)) {
                http_ajax_response(0, '注册成功');
                $this->set_user_login($user_id, 1, $user_info['login_name'], '');
                return;
            }
            http_ajax_response(1, '注册失败');
        }
    }

    /**
     * ajax_login
     * 用户登录
     *
     * @author haokaiyang
     * @date   2016-11-20 22:14:14
     */
    public function ajax_login()
    {
        $this->load->library('form_validation');
        if (false === $this->form_validation->run()) {
            http_ajax_response(1, $this->form_validation->error_string());
        } else {
            $login_name = $this->input->post('login_name',true);;
            $password = $this->input->post('password',true);
            $user_info = $this->_model->get_user_info(['user.login_name' => $login_name], 'user.id,user.login_name,user.password,user.salt,user.status,user_profile.real_name');
            if (empty($user_info)) {
                http_ajax_response(1, '登录账号不存在');
                return;
            }
            $this->load->helper('security');
            if ($user_info['password'] !== generate_admin_password($password, $user_info['salt'])) {
                http_ajax_response(1, '登录密码错误');
                return;
            }
            http_ajax_response(0, '登录成功');
            $this->set_user_login($user_info['id'], $user_info['status'], $user_info['login_name'], $user_info['real_name']);
        }
    }

    /**
     * detail
     * 用户详情
     *
     * @author haokaiyang
     * @date 2016-11-21 22:30:01
     */
    public function detail()
    {
        $this->_headerViewVar['title'] = '用户详情';
        $user_id = $this->_loginUser['id'];
        if('post' == $this->input->method()) {
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
            } else {
                $user_info['real_name'] = $this->input->post('real_name',true);
                $user_info['sex'] = $this->input->post('sex',true);
                $user_info['phone'] = $this->input->post('phone',true);
                $user_info['email'] = $this->input->post('email',true);
                $user_info['qq'] = $this->input->post('qq',true);
                $user_info['idcard'] = $this->input->post('idcard',true);
                $result = $this->_model->setTable('user_profile')->setConditions(['user_id'=>$user_id])->setUpdateData($user_info)->update();
                if($result){
                    http_ajax_response(0, '修改成功');
                    return;
                }
                http_ajax_response(1,'修改失败,请稍后再试');
            }
        } else {
            $user_info = $this->_model->setSelectFields('*')->setTable('user_profile')->setConditions(['user_id'=>$user_id])->get();
            $this->load_view('',$user_info);
        }
    }

    /**
     * change_password
     * 修改密码
     *
     * @author haokaiyang
     * @date 2016-11-21 22:30:01
     */
    public function change_password()
    {
        if('post' == $this->input->method()) {
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
            } else {
                $this->load->helper(['tools','security']);
                $user_id = $this->_loginUser['id'];
                $old_password = $this->input->post('old_password', true);
                $new_password = $this->input->post('new_password', true);
                $user_info = $this->_model->setConditions(['id'=>$user_id])->setSelectFields('password, salt')->get();
                if (empty($user_info)) {
                    http_ajax_response(1, '登录账号不存在');
                    return;
                }
                $this->load->helper('security');
                if ($user_info['password'] !== generate_admin_password($old_password, $user_info['salt'])) {
                    http_ajax_response(1, '原密码错误,请重新输入');
                    return;
                }
                $update_data['salt'] = random_characters();
                $update_data['password'] = generate_admin_password($new_password, $update_data['salt']);
                $result = $this->_model->modify($user_id, $update_data);
                if($result){
                    http_ajax_response(0, '修改密码成功');
                    return;
                }
                http_ajax_response(1,'失败,请重试');
            }
        } else {
            $this->load_view();
        }
    }

    /**
     * set_user_login
     * 设置用户登录信息
     *
     * @param int $user_id            用户id
     * @param int $user_status        用户权限状态
     * @param string $user_login_name 用户登录名称
     * @param string $user_real_name  真实名称
     *
     * @author haokaiyang
     * @date   2016-11-20 16:20:20
     */
    private function set_user_login(int $user_id, int $user_status, string $user_login_name, string $user_real_name)
    {
        $this->session->home_login_user = [
            'id'         => $user_id,
            'status'     => $user_status,
            'login_name' => $user_login_name,
            'real_name'  => $user_real_name,
        ];
    }

    /**

     * logout 退出账号
     *
     * @author haokaiyang
     * @date 2016-11-21 23:30:39
     */
    public function logout()
    {
        $this->session->unset_userdata('home_login_user');
        redirect('/');
    }
}