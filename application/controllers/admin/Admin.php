<?php

/**
 * Class Admin 管理员控制器
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-12 20:56:22
 */
class Admin extends Admin_Controller
{
    /**
     * index 获取管理员列表(分页)数据控制器
     *
     * @param int $page 分页页码
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-08-17 20:12:26
     */
    public function index(int $page = 0)
    {
        // 分页页码
        $page = 0 >= $page ? 1 : $page;

        // view data
        $this->_headerViewVar['h1_title'] = '管理员列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = ['#', '登录账号', '添加时间', '状态', '操作'];

        // model
        $this->load->model('admin_model');

        // 获取记录总条数
        $count = $this->admin_model->count();
        if(! empty($count)) {
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("admin/index");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();
            // get page data
            $this->_viewVar['data'] = $this->admin_model
                ->setSelectFields('id,login_name,created_at,status')
                ->getPage($page, ADMIN_PAGE_SIZE);
        }

        // 加载视图
        $this->load_view();
    }
}