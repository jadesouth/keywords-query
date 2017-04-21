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
                    $this->load->model('dict_area_model');
                    $areas = $this->dict_area_model
                        ->setSelectFields('id,name')
                        ->setAndCond(['id []' => $area_ids, 'status' => 0])
                        ->read();
                    if (! empty($areas)) {
                        $area = array_column($areas, 'name', 'id');
                    }
                }
            }

            // 整理数据
            $addresses = [];
            foreach ($this->_viewVar['data'] as $address_k => $address_v) {
                $addresses[$address_k]['id'] = $address_v['id'];
                $province_name = empty($area[$address_v['province_id']]) ? '' : $area[$address_v['province_id']];
                $city_name = empty($area[$address_v['city_id']])? '' : $area[$address_v['city_id']];
                $county_name = empty($area[$address_v['county_id']]) ? '' : $area[$address_v['county_id']];
                $addresses[$address_k]['area'] = $province_name . $city_name . $county_name;
                $addresses[$address_k]['address'] = $address_v['address'];
                $addresses[$address_k]['created_at'] = $address_v['created_at'];
            }
            $this->_viewVar['data'] = $addresses;
        }

        // 获取省份地址信息
        $this->load->model('dict_area_model');
        $this->_viewVar['provinces'] = $this->dict_area_model
            ->setSelectFields('id,name')
            ->setAndCond(['level' => 1, 'status' => 0])
            ->read();

        // 加载视图
        $this->load_view();
    }

    /**
     * addAddress 添加地址关键字信息
     *
     * @return bool
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-16 18:14:09
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
            $address = htmlentities($this->input->post('address'));
            if (empty($address)) {
                http_ajax_response(2, '详细地址输入非法!');
                return false;
            }
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
     * @date   2016-12-16 18:40:14
     */
    public function deleteAddress()
    {
        $id = (int)$this->input->post('address');
        $this->load->helper('http');
        if (0 >= $id) {
            http_ajax_response(1, '删除操作不合法');
            return;
        }

        $this->load->model('address_keywords_model');
        $res = $this->address_keywords_model->setAndCond(['id' => $id])
            ->delete();
        if (0 >= $res) {
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
        // 查询出所有的地址关键字
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
     * wangwang 添加旺旺关键字
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-17 21:49:38
     */
    public function wangwang()
    {
        // view data
        $this->_headerViewVar['h1_title'] = '旺旺关键字列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 查询出所有的旺旺关键字
        $conditions = [
            'AND'   => [
                'type'   => 3, // 1:广告法,2:地址,3:旺旺,4:手机号码
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
     * phone 电话关键字
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-17 21:57:57
     */
    public function phone()
    {
        // view data
        $this->_headerViewVar['h1_title'] = '电话关键字列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 查询出所有的电话关键字
        $conditions = [
            'AND'   => [
                'type'   => 4, // 1:广告法,2:地址,3:旺旺,4:手机号码
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
     *
     * @return void
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-21 22:12:42
     */
    public function edit(int $id = 0)
    {
        $this->advertising();
    }
}
