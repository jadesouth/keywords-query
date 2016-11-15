<?php

/**
 * Class Manager  管理员登陆登出控制器
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   16-11-15 16:11
 */
class Manager extends MY_Controller
{
    /**
     * login 管理员登录
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-15 15:54:21
     */
    public function login()
    {
        // 已经登陆,直接进内部页面
        if(! empty($this->session->admin_login_user)) {
            redirect('admin');
        }
        if('post' == $this->input->method()) {
            $this->load->helper('http');
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
                return;
            }

            $login_name = $this->input->post('login_name');
            $password = $this->input->post('password');
            $this->load->model('admin_model');
            $admin = $this->admin_model
                ->setAndCond(['login_name' => $login_name, 'status' => 0])
                ->setSelectFields('id,login_name,password,salt,status')
                ->get();
            if(empty($admin)) {
                http_ajax_response(2, '登录账号不存在或已被禁用');
                return;
            }
            $this->load->helper('security');
            if($admin['password'] !== generate_admin_password($password, $admin['salt'])) {
                http_ajax_response(3, '登录密码错误');
                return;
            }

            http_ajax_response(0, '登录成功');

            // 写入文件Session
            $this->session->admin_login_user = [
                'id'         => $admin['id'],
                'login_name' => $admin['login_name'],
                'status'     => $admin['status'],
            ];
        } else {
            $this->load->view('admin/login');
        }
    }

    /**
     * logout 管理员登出
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-15 15:53:21
     */
    public function logout()
    {
        $this->session->unset_userdata('admin_login_user');
        redirect('admin/login');
    }
}
