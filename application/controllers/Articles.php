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

    /**
     * business 最新咨询
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-26 23:48:45
     */
    public function index(int $page = 0)
    {
        // 分页页码
        $page = 0 >= $page ? 1 : $page;
        // view data
        $this->_headerViewVar['title'] = '咨询列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = ['文章标题', '短标题'];

        // model
        $this->load->model('article_model');
        // 获取记录总条数
        $Conditions = ['AND'=>['cid'=>1,'status !='=>1]];
        $this->article_model->setConditions($Conditions);
        $count = $this->article_model->count(false);
        if(! empty($count)) {
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("articles/index");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();
            // get page data
            $this->_viewVar['data'] = $this->article_model
                ->setSelectFields('id,title,resume,subtitle')
                ->getPage($page, ADMIN_PAGE_SIZE);

        }
        // 加载视图
        $this->load_view();
    }
    public function desc(int $id = 0)
    {
        $this->_headerViewVar['title'] = '咨询详情';
        $this->load->model('article_model');
        $this->article_model->setSelectFields('*');
        $this->_viewVar['data'] = $this->article_model->find($id);
        $this->load_view();
    }
}
