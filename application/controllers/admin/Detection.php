<?php

/**
 * Class Detection 检测申请控制器
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-27 20:08:22
 */
class Detection extends Admin_Controller
{
    /**
     * index 获取申请者列表(分页)数据控制器
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
        $this->_headerViewVar['h1_title'] = '申请者列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = ['#', '申请用户', '电话', 'QQ', 'E-mail', '申请时间', '操作'];

        // model
        $this->load->model('detection_apply_info_model');
        // 获取记录总条数
        $count = $this->detection_apply_info_model->getAllCount();
        if(! empty($count)) {
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("admin/detection/index");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();
            // get page data
            $this->_viewVar['data'] = $this->detection_apply_info_model
                ->getAllPage($page, ADMIN_PAGE_SIZE);
        }

        // 加载视图
        $this->load_view();
    }

    /**
     * details 获取详情信息
     *
     * @param int $id ID
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-29 13:33:17
     */
    public function details(int $id = 0)
    {
        if(0 >= $id) {
            http_ajax_response(1, '请求参数有误');
            return;
        }
        // 获取详情信息
        $this->load->model('detection_apply_info_model');
        $detection_info = $this->detection_apply_info_model
            ->setSelectFields('login_name,phone,qq,email,apply_time')
            ->setAndCond(['detection_apply_info.id' => $id, 'detection_apply_info.status' => 0])
            ->setLeftJoin(['user' => 'detection_apply_info.user_id = user.id'])
            ->leftGet();
        if(empty($detection_info)) {
            http_ajax_response(-1, '详情信息不存在');
        } else {
            http_ajax_response(0, 'ok', $detection_info);
        }
    }
}