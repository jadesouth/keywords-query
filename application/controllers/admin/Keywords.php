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
        if('post' == $this->input->method()) {
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
     * @date 2016-11-21 22:13:27
     */
    public function index(int $page = 0)
    {
        $this->advertising();
    }

    /**
     * edit 编辑方法定向到 advertising
     *
     * @param int $id 数据表主键
     * @return json|void
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-21 22:12:42
     */
    public function edit(int $id = 0)
    {
        $this->advertising();
    }
}
