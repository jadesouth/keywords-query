<?php

/**
 * Class Keywords
 *
 * @author haokaiyang
 * @date   2016-12-04 18:05:42
 */
class Messages extends Home_Controller
{

    /**
     * index 留言页面展示
     *
     * @author haokaiyang
     * @date 2016-12-04 20:16:58
     */
    public function index()
    {
        $this->load->view('home/messages/index.php');
    }

    /**
     * ajax_leave_message 提交留言信息
     *
     * @author haokaiyang
     * @date 2016-12-04 20:17:07
     */
    public function ajax_leave_message()
    {
        $insert_data['user_id'] = empty($this->_loginUser['id']) ? 0 : $this->_loginUser['id'];
        $insert_data['phone'] = (int)$this->input->post('phone', 0);
        $insert_data['qq'] = (string)$this->input->post('qq', '');
        $insert_data['email'] = (string)$this->input->post('email', '');
        $insert_data['leave_time'] = date('Y-m-d H:i:s');
        $insert_data['content'] = (string)$this->input->post('content', '');
        $this->load->model('leave_message_model');
        if (true == $this->leave_message_model->create($insert_data)) {
            http_ajax_response(0, '多谢反馈,我们将做的更好');
        } else {
            http_ajax_response(1, '留言失败,请稍后再试');
        }
    }
}
