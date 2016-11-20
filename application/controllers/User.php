<?php

/**
 * Created by PhpStorm.
 * User: haokaiyang
 * Date: 2016/11/20
 * Time: 上午10:43
 */
class User extends Home_Controller
{

    public function ajax_register()
    {
        $this->load->library('form_validation');
        if (false === $this->form_validation->run()) {
            http_ajax_response(1, $this->form_validation->error_string());
        } else {
            $user_info['login_name'] = $_POST['login_name'];
            $user_info['password'] = $_POST['password'];
            $user_info['con_password'] = $_POST['con_password'];
            if ($user_info['password'] != $user_info['con_password']) {
                http_ajax_response(1, '您两次输入的密码不一致');
                return;
            }
            $user_id = $this->_model->add($user_info);
            if (!empty($user_id)) {
                http_ajax_response(0, '注册成功');
                $this->set_user_login($user_id,1,$user_info['login_name'],'');
                return;
            }
            http_ajax_response(1, '注册失败');
        }
    }

    /**
     * set_user_login
     * 设置用户登录信息
     *
     * @param int $user_id 用户id
     * @param int $user_status 用户权限状态
     * @param string $user_login_name 用户登录名称
     * @param string $user_real_name 真实名称
     *
     * @author haokaiyang
     * @date 2016-11-20 16:20:20
     */
    private function set_user_login(int $user_id,int $user_status, string $user_login_name,string  $user_real_name)
    {
        $this->session->home_login_user = [
            'id'         => $user_id,
            'status'     => $user_status,
            'login_name' => $user_login_name,
            'real_name'  => $user_real_name,
        ];
    }
}