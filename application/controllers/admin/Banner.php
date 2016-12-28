<?php

/**
 * Class Banner Banner管理控制器
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   16-12-28 13:55
 */
class Banner extends Admin_Controller
{
    /**
     * enable 启用 Banner
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-28 14:15:11
     */
    public function enable()
    {
        $this->load->helper('http');
        if ('post' == $this->input->method()) {
            $id = (int)$this->input->post('banner');
            if (0 >= $id) {
                http_ajax_response(1, '非法请求！');
            } else {
                $this->load->model('banner_model');
                if ($this->banner_model->modify($id, ['status' => 0])) {
                    http_ajax_response(0, 'ok！');
                } else {
                    http_ajax_response(-1, '操作失败,请稍后再试！');
                }
            }
        } else {
            http_ajax_response(1, '非法请求！');
        }
    }

    /**
     * disable 禁用 Banner
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-12-28 14:15:28
     */
    public function disable()
    {
        $this->load->helper('http');
        if ('post' == $this->input->method()) {
            $id = (int)$this->input->post('banner');
            if (0 >= $id) {
                http_ajax_response(1, '非法请求！');
            } else {
                $this->load->model('banner_model');
                if ($this->banner_model->modify($id, ['status' => 1])) {
                    http_ajax_response(0, 'ok！');
                } else {
                    http_ajax_response(-1, '操作失败,请稍后再试！');
                }
            }
        } else {
            http_ajax_response(1, '非法请求！');
        }
    }
}
