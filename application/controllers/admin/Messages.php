<?php

/**
 * Created by PhpStorm.
 * User: haokaiyang
 * Date: 2016/11/30
 * Time: 下午10:04
 */
class Messages extends Admin_Controller
{
    /**
     * index 获取留言(分页)数据控制器
     *
     * @param int $page 分页页码
     *
     * @author haokaiyang
     * @date   2016-11-30 22:05:28
     */
    public function index(int $page = 0)
    {
        // 分页页码
        $page = 0 >= $page ? 1 : $page;

        // view data
        $this->_headerViewVar['h1_title'] = '留言列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = ['#', '用户名', '电话', 'QQ', 'E-mail', '留言内容', '留言时间', '操作'];

        // model
        $this->load->model('leave_message_model');
        // 获取记录总条数
        $count = $this->leave_message_model->getAllCount();
        if (! empty($count)) {
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("admin/messages/index");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();
            // get page data
            $this->_viewVar['data'] = $this->leave_message_model
                ->getAllPage($page, ADMIN_PAGE_SIZE);
            foreach ($this->_viewVar['data'] as $key => $leave_message) {
                $this->_viewVar['data'][$key]['content'] = mb_substr($leave_message['content'], 0, 20) . '...';
            }
        }

        // 加载视图
        $this->load_view();
    }

    /**
     * detail 获取留言详情
     *
     * @param int $id ID
     *
     * @author haokaiyang
     * @date   2016-11-30 22:29:48
     */
    public function detail(int $id = 0)
    {
        if (0 >= $id) {
            http_ajax_response(1, '参数错误');
            return;
        }
        // 获取详情信息
        $this->load->model('leave_message_model');
        $detection_info = $this->leave_message_model
            ->setSelectFields('user.login_name,leave_message.phone,leave_message.qq,leave_message.email,leave_message.content,leave_message.leave_time')
            ->setAndCond(['leave_message.id' => $id, 'leave_message.status' => 0])
            ->setLeftJoin(['user' => 'leave_message.user_id = user.id'])
            ->leftGet();
        if (empty($detection_info)) {
            http_ajax_response(1, '详情信息不存在');
        } else {
            http_ajax_response(0, '成功', $detection_info);
        }
    }

    /**
     * delete 删除留言
     *
     *
     * @param int $id
     *
     * @author haokaiyang
     * @date 2016-11-30 22:56:08
     */
    public function delete(int $id = 0)
    {
        if (0 >= $id) {
            http_ajax_response(1, '参数错误');
            return;
        }
        // 获取详情信息
        $this->load->model('leave_message_model');
        if (true == $this->leave_message_model->modify($id, ['status' => 1])) {
            http_ajax_response(0, '删除成功');
        } else {
            http_ajax_response(1, '删除失败');
        }
    }
}