<?php

/**
 * Articles.php
 *
 * @author yangbiao<yangbiao@163.com>
 * @date   2016-11-21 22:45:25
 */
class Articles extends Home_Controller
{
    public function index()
    {

    }

    /**
     * business 业务介绍id=>1
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-21 23:02:34
     */
    public function business()
    {
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
        $_id = 4;
        $this->load->model('article_model');
        $this->article_model->setSelectFields('content');
        $this->_viewVar['data'] = $this->article_model->find($_id);
        $this->load_view('articles/business');
    }

    /**
     * about 联系我们=>id:5
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-21 23:07:01
     */
    public function about()
    {
        $_id = 5;
        $this->load->model('article_model');
        $this->article_model->setSelectFields('content');
        $this->_viewVar['data'] = $this->article_model->find($_id);
        $this->load_view('articles/business');
    }

}