<?php

/**
 * Articles.php
 *
 * @author yangbiao<yangbiao@163.com>
 * @date   2016-11-21 22:45:25
 */
class Articles extends Home_Controller
{
    /**
     * business 业务介绍id=>1
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-21 23:02:34
     */
    public function business()
    {
        $this->_headerViewVar['title'] = '业务介绍';
        $_id = 1;
        $this->load->model('article_model');
        $this->article_model->setSelectFields('content');
        $this->_viewVar['data'] = $this->article_model->find($_id);
        $this->load_view();
    }

    /**
     * cases 合作案例id=>2
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-21 23:06:48
     */
    public function cases()
    {
        $this->_headerViewVar['title'] = '合作案例';
        $_id = 2;
        $this->load->model('article_model');
        $this->article_model->setSelectFields('content');
        $this->_viewVar['data'] = $this->article_model->find($_id);
        $this->load_view('articles/business');
    }

    /**
     * property 知识产权服务id=>3
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-21 23:06:55
     */
    public function property()
    {
        $this->_headerViewVar['title'] = '知识产权服务';
        $_id = 3;
        $this->load->model('article_model');
        $this->article_model->setSelectFields('content');
        $this->_viewVar['data'] = $this->article_model->find($_id);
        $this->load_view('articles/business');
    }

    /**
     * price 价格管控id=>4
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-21 23:06:57
     */
    public function price()
    {
        $this->_headerViewVar['title'] = '价格管控';
        $_id = 4;
        $this->load->model('article_model');
        $this->article_model->setSelectFields('content');
        $this->_viewVar['data'] = $this->article_model->find($_id);
        $this->load_view('articles/business');
    }

    /**
     * about 关于我们=>id:5
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-21 23:07:01
     */
    public function about()
    {
        $this->_headerViewVar['title'] = '关于我们';
        $_id = 5;
        $this->load->model('article_model');
        $this->article_model->setSelectFields('content');
        $this->_viewVar['data'] = $this->article_model->find($_id);
        $this->load_view('articles/business');
    }
}
