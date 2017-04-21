<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: haokaiyang
 * Date: 16-11-12
 * Time: 19:59:46
 */

/**
 * Class User 用户控制器
 */
class User extends Admin_Controller
{
    /**
     * index
     * 全部用户列表
     *
     * @param int $page
     *
     * @author haokaiyang
     * @date   2016-11-12 20:03:06
     */
    public function index(int $page = 0)
    {
        // 分页页码
        $page = 0 >= $page ? 1 : $page;
        $user_type = empty($_GET['type']) ? 'all' : $_GET['type'];

        // view data
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = ['#', '登录名', '手机号码', '真实姓名', 'QQ', '注册时间', '状态', '操作'];
        $this->_viewVar['user_type'] = $user_type;

        // model
        $this->load->model('user_model');

        // 获取记录总条数
        $count = $this->user_model->count();
        if (! empty($count)) {
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("admin/user/index");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();

            // get page data
            if('authorized' == $user_type){
                $this->_headerViewVar['h1_title'] = '有权限的用户列表';
                $this->_viewVar['data'] = $this->user_model->read_user_list($page, ADMIN_PAGE_SIZE, '', ['user.status' => 0]);
            }elseif('normal' == $user_type){
                $this->_headerViewVar['h1_title'] = '无权限的用户列表';
                $this->_viewVar['data'] = $this->user_model->read_user_list($page, ADMIN_PAGE_SIZE, '', ['user.status' => 1]);
            }else{
                $this->_headerViewVar['h1_title'] = '全部用户列表';
                $this->_viewVar['data'] = $this->user_model->read_user_list($page);
            }
            foreach ($this->_viewVar['data'] as $key =>$user_info){
                $this->_viewVar['data'][$key]['reg_time'] = date('Y-m-d H:i:s', $user_info['reg_time']);
            }
        }

        // 加载视图
        $this->load_view();
    }

    /**
     * ajax_disable
     * 禁用账号
     *
     * @author haokaiyang
     * @date   2016-11-12 23:49:39
     */
    public function ajax_disable()
    {
        $this->load->helper('http');
        $user_id = (int)$this->input->post('user_id', 0);
        if (0 >= $user_id) {
            http_ajax_response(1, '非法请求');
            return;
        }

        $this->load->model('user_model');
        if (true == $this->user_model->modify($user_id, ['status' => 1])) {
            http_ajax_response(0, '关闭权限成功');
        } else {
            http_ajax_response(2, '关闭权限成功');
        }
    }

    /**
     * ajax_enable
     * 启用账号
     *
     * @author haokaiyang
     * @date   2016-11-12 23:49:58
     */
    public function ajax_enable()
    {
        $this->load->helper('http');
        $user_id = (int)$this->input->post('user_id', 0);
        if (0 >= $user_id) {
            http_ajax_response(1, '非法请求');
            return;
        }

        $this->load->model('user_model');
        if (true == $this->user_model->modify($user_id, ['status' => 0])) {
            http_ajax_response(0, '开通权限成功');
        } else {
            http_ajax_response(2, '开通权限失败');
        }
    }

    /**
     * detail
     * 用户详情
     *
     * @author haokaiyang
     * @date 2016-11-15 23:05:17
     */
    public function detail()
    {
        $this->load->helper('http');
        $user_id = (int)$this->input->post('user_id', 0);
        if (0 >= $user_id) {
            http_ajax_response(1, '非法请求');
            return;
        }

        // 获取用户信息
        $this->load->model('user_model');
        $user_info = $this->user_model->get_user_info(['user.id' => $user_id], 'user.id,user.login_name,user_profile.sex,user_profile.phone,user_profile.real_name,user_profile.email,user_profile.idcard,user_profile.qq,user_profile.reg_time,user_profile.reg_ip,user_profile.last_login_time,user_profile.last_login_ip,user.status');
        if (empty($user_info)) {
            http_ajax_response(2, '获取信息失败');
            return;
        }

        // 整理数据
        $user_info['sex'] = [0 => '未知', 1 => '男', 2 => '女'][$user_info['sex']];
        $user_info['status'] = [0 => '有权限', 1 => '无权限'][$user_info['status']];
        $user_info['reg_time'] = date('Y-m-d H:i:s', $user_info['reg_time']);
        $user_info['last_login_time'] = date('Y-m-d H:i:s', $user_info['last_login_time']);
        http_ajax_response(0, '', $user_info);
    }
}
