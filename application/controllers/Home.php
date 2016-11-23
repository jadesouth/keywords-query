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
        $this->load_view();
    }
}
