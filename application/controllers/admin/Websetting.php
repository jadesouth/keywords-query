<?php

/**
 * Class WebSetting 网站设置
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2017-01-17 11:14:17
 */
class WebSetting extends Admin_Controller
{
    /**
     * area 区域数据管理添加
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2017-01-17 11:30:32
     */
    public function area()
    {
        // view data
        $this->_headerViewVar['h1_title'] = '区域数据添加';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 获取一级省份信息
        $this->load->model('dict_area_model');
        $this->_viewVar['provinces'] = $this->dict_area_model
            ->setSelectFields('id,name')
            ->setAndCond(['level' => 1, 'status' => 0])
            ->read();
        // 获取对一个省份对应的市区信息
        $this->_viewVar['cities'] = $this->dict_area_model
            ->setSelectFields('id,name')
            ->setAndCond(['pid' => $this->_viewVar['provinces'][0]['id'], 'level' => 2, 'status' => 0])
            ->read();
        $this->load_view();
    }

    /**
     * addProvince 添加一级省份区域
     *
     * @return bool
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2017-01-17 15:17:51
     */
    public function addProvince()
    {
        $this->load->helper('http');
        if ('post' == $this->input->method()) {
            $this->load->library('form_validation');
            if (false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
                return false;
            }

            $province = htmlentities($this->input->post('province'));
            if (empty($province)) {
                http_ajax_response(2, '一级区域名称输入非法!');
                return false;
            }
            $this->load->model('dict_area_model');
            $res = $this->dict_area_model
                ->setInsertData(['level' => 1, 'name' => $province])
                ->create();
            if (0 >= $res) {
                http_ajax_response(-1, '添加一级区域失败,请稍后再试!');
                return false;
            }

            http_ajax_response(0, '添加一级区域成功!');
            return true;
        } else {
            http_ajax_response(2, '非法请求');
            return false;
        }
    }

    /**
     * addCity 添加二级市区信息
     *
     * @return bool
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2017-01-17 15:37:37
     */
    public function addCity()
    {
        $this->load->helper('http');
        if ('post' == $this->input->method()) {
            $this->load->library('form_validation');
            if (false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
                return false;
            }

            $province = (int)$this->input->post('province');
            if (0 >= $province) {
                http_ajax_response(2, '一级区域名称选择非法!');
                return false;
            }
            $city = htmlentities($this->input->post('city'));
            if (empty($city)) {
                http_ajax_response(2, '二级区域名称输入非法!');
                return false;
            }
            $this->load->model('dict_area_model');
            $res = $this->dict_area_model
                ->setInsertData(['pid' => $province, 'level' => 2, 'name' => $city])
                ->create();
            if (0 >= $res) {
                http_ajax_response(-1, '添加二级区域失败,请稍后再试!');
                return false;
            }

            http_ajax_response(0, '添加二级区域成功!');
            return true;
        } else {
            http_ajax_response(2, '非法请求');
            return false;
        }
    }

    /**
     * addCounty 添加三级县区信息
     *
     * @return bool
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2017-01-17 15:43:00
     */
    public function addCounty()
    {
        $this->load->helper('http');
        if ('post' == $this->input->method()) {
            $this->load->library('form_validation');
            if (false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
                return false;
            }

            $province = (int)$this->input->post('province');
            if (0 >= $province) {
                http_ajax_response(2, '一级区域名称选择非法!');
                return false;
            }
            $city = (int)$this->input->post('city');
            if (0 >= $province) {
                http_ajax_response(2, '二级区域名称选择非法!');
                return false;
            }
            $county = htmlentities($this->input->post('county'));
            if (empty($county)) {
                http_ajax_response(2, '三级区域名称输入非法!');
                return false;
            }
            $this->load->model('dict_area_model');
            $res = $this->dict_area_model
                ->setInsertData(['pid' => $city, 'level' => 3, 'name' => $county])
                ->create();
            if (0 >= $res) {
                http_ajax_response(-1, '添加三级区域失败,请稍后再试!');
                return false;
            }

            http_ajax_response(0, '添加三级区域成功!');
            return true;
        } else {
            http_ajax_response(2, '非法请求');
            return false;
        }
    }
}
