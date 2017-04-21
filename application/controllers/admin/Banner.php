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
     * index 获取 Banner 列表(分页)数据控制器
     *
     * @param int $page 分页页码
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-28 22:00:14
     */
    public function index(int $page = 0)
    {
        // 分页页码
        $page = 0 >= $page ? 1 : $page;

        // view data
        $this->_headerViewVar['h1_title'] = 'Banner 管理';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = ['#', 'Banner', '添加时间', '状态', '操作'];

        // model
        $this->load->model('banner_model');
        // 获取记录总条数
        $count = $this->banner_model->count();
        if (! empty($count)) {
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("admin/banner");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();
            // get page data
            $this->_viewVar['data'] = $this->banner_model
                ->setSelectFields('id,img_path,created_at,status')
                ->getPage($page, ADMIN_PAGE_SIZE);
        }

        // 加载视图
        $this->load_view();
    }

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
     * @date   2016-12-28 14:15:28
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
