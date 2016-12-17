<?php

/**
 * Keywords.php
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   16-11-16 15:45
 */
class Keywords extends Admin_Controller
{
    /**
     * addressPage 地址查询列表页
     *
     * @param int $page
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-16 16:53:00
     */
    public function addressPage(int $page = 1)
    {
        // view data
        $this->_headerViewVar['h1_title'] = '地址关键字列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = ['#', '省市区', '详细地址', '添加时间', '操作'];

        // 获取记录总条数
        $this->load->model('address_keywords_model');
        $count = $this->address_keywords_model
            ->setAndCond(['status' => 0])
            ->count();
        if (! empty($count)) {
            // 分页页码
            $page = 0 >= $page ? 1 : $page;
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("admin/keywords/addresspage");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();
            // get page data
            $this->_viewVar['data'] = $this->address_keywords_model
                ->setSelectFields('id,province_id,city_id,county_id,address,created_at')
                ->setAndCond(['status' => 0])
                ->getPage($page, ADMIN_PAGE_SIZE);

            // 获取省市县信息
            if (! empty($this->_viewVar['data'])) {
                $area_ids = [];
                foreach ($this->_viewVar['data'] as $address) {
                    $area_ids[] = $address['province_id'];
                    $area_ids[] = $address['city_id'];
                    $area_ids[] = $address['county_id'];
                }
                if (! empty($area_ids)) {
                    $this->load->model('Dict_area_model');
                    $areas = $this->dict_area_model
                        ->setSelectFields('id,name')
                        ->setAndCond(['id <>' => $area_ids, 'status' => 0])
                        ->read();
                    if (! empty($areas)) {
                        $this->_viewVar['areas'] = array_column($areas, 'name', 'id');
                    }
                }
            }
        }

        // 加载视图
        $this->load_view();
    }

    /**
     * addAddress 添加地址关键字信息
     *
     * @return bool
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-12-16 18:14:09
     */
    public function addAddress()
    {
        $this->load->helper('http');
        if ('post' == $this->input->method()) {
            $this->load->library('form_validation');
            if (false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
                return false;
            }

            $province = $this->input->post('province');
            $city = $this->input->post('city');
            $county = $this->input->post('county');
            $address = $this->input->post('address');
            $this->load->model('address_keywords_model');
            $res = $this->address_keywords_model
                ->setInsertData(['province_id' => $province, 'city_id' => $city, 'county_id' => $county, 'address' => $address])
                ->create();
            if (0 >= $res) {
                http_ajax_response(-1, '添加地址关键字失败,请稍后再试!');
                return false;
            }

            http_ajax_response(0, '添加地址关键字成功!');
            return true;
        } else {
            http_ajax_response(2, '非法请求');
            return false;
        }
    }

    /**
     * deleteAddress 删除地址操作
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-12-16 18:40:14
     */
    public function deleteAddress()
    {
        $id = (int)$this->input->post('id');
        $this->load->helper('http');
        if(0 >= $id) {
            http_ajax_response(1, '删除操作不合法');
            return;
        }

        $this->load->model('address_keywords_model');
        $res = $this->address_keywords_model->setAndCond(['id' => $id])
            ->delete();
        if(0 >= $res) {
            http_ajax_response(-1, '删除操作失败,请稍后再试');
            return;
        }

        http_ajax_response(0, '删除操作成功');
    }

    /**
     * advertising 广告法关键字操作页面
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-16 16:05:40
     */
    public function advertising()
    {
        // view data
        $this->_headerViewVar['h1_title'] = '广告法关键字列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 查询出所有的广告法关键字
        $conditions = [
            'AND'   => [
                'type'   => 1, // 1:广告法,2:地址
                'status' => 0,
            ],
            'ORDER' => 'id DESC',
        ];
        $this->_viewVar['keywords'] = $this->_model
            ->setSelectFields('id,word')
            ->setConditions($conditions)
            ->read();

        $this->load_view();
    }

    /**
     * address 地址关键字操作页面
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-16 16:08:25
     */
    public function address()
    {
        // view data
        $this->_headerViewVar['h1_title'] = '地址关键字列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 查询出所有的广告法关键字
        $conditions = [
            'AND'   => [
                'type'   => 2, // 1:广告法,2:地址
                'status' => 0,
            ],
            'ORDER' => 'id DESC',
        ];
        $this->_viewVar['keywords'] = $this->_model
            ->setSelectFields('id,word')
            ->setConditions($conditions)
            ->read();

        $this->load_view();
    }

    /**
     * add 添加关键字
     *
     * @return bool
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-16 17:26:38
     */
    public function add()
    {
        if ('post' == $this->input->method()) {
            $this->load->helper('http');
            $this->load->library('form_validation');
            if (false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
                return false;
            }

            $type = $this->input->post('type');
            $word = $this->input->post('word');
            $res = $this->_model
                ->setInsertData(['type' => $type, 'word' => $word])
                ->create();
            if (0 >= $res) {
                http_ajax_response(2, '添加关键字失败,请稍后再试!');
                return false;
            }

            http_ajax_response(0, '添加关键字成功!', ['id' => $res, 'word' => $word]);
            return true;
        } else {
            $this->advertising();
            return true;
        }
    }

    /**
     * index 列表方法定向到 advertising
     *
     * @param int $page 数据表主键
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-21 22:13:27
     */
    public function index(int $page = 0)
    {
        $this->advertising();
    }

    /**
     * edit 编辑方法定向到 advertising
     *
     * @param int $id 数据表主键
     * @return void
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-21 22:12:42
     */
    public function edit(int $id = 0)
    {
        $this->advertising();
    }
}
