<?php

/**
 * Home.php
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-23 22:59:07
 */
class Home extends Home_Controller
{
    /**
     * index 首页
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-16 16:05:40
     */
    public function index()
    {
        $this->_headerViewVar['title'] = '首页';
        // 获取各板块内容
        $this->load->model('article_model');
        $condition = [
            'AND' => ['id []' => [1, 2, 3, 4]],
        ];
        $this->_viewVar['areas'] = $this->article_model
            ->setSelectFields('id,resume')
            ->setAndCond($condition)
            ->read();
        // 获取最新动态

        $condition = [
            'AND'   => [
                'cid'    => 1,
                'status' => 0,
            ],
            'ORDER' => 'id DESC',
            'LIMIT' => 9,
        ];
        $this->_viewVar['articles'] = $this->article_model
            ->setSelectFields('id,title')
            ->setConditions($condition)
            ->read();
        $this->load_view();
    }
}
