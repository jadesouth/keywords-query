<?php

/**
 * Admin_Controller.php
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-11 03:13:09
 */
class Admin_Controller extends MY_Controller
{
    /**
     * @var string 当前Controller对应的主要Model名称
     */
    protected $_modelName = 'MY_Model';
    /**
     * @var array 后台相关配置文件
     */
    protected $_adminConfig = [];


    /**
     * Admin_Controller constructor.
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 20:00:13
     */
    public function __construct()
    {
        parent::__construct();

        // 检测登陆
        if(empty($this->session->admin_login_user)) {
            redirect('admin/login');
        }
        // 赋值登陆信息
        $this->_login_user = $this->session->admin_login_user;

        // 加载后台控制器操作的主model
        $this->_modelName = $this->_className . '_model';
        $this->load->model($this->_modelName);
        // 加载后台相关的配置文件
        $this->config->load('admin', true);
        $this->_adminConfig = $this->config->item('admin');
        // 后台导航用的控制器名
        $this->_headerViewVar['controller'] = $this->_className;
    }

    /**
     * index 后台通用列表页
     *
     * @param int $page 分页页码
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 21:26:37
     */
    public function index(int $page = 0)
    {
        // 分页页码
        $page = 0 >= $page ? 1 : $page;

        // view data
        $this->_headerViewVar['h1_title'] = $this->_adminConfig[$this->_className][__FUNCTION__];
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = $this->_adminConfig[$this->_className]['table_header'];

        // model
        $model = $this->_modelName;

        // 获取记录总条数
        $count = $this->$model->count();
        if(! empty($count)) {
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("admin/{$this->_className}/index");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();
            // get page data
            $this->_viewVar['data'] = $this->$model
                ->setSelectFields($this->_adminConfig[$this->_className]['index_field'])
                ->getPage($page, ADMIN_PAGE_SIZE);
        }
        // 加载视图
        $this->load_view('index_list');
    }

    /**
     * add 后台通用的添加方法
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 21:00:04
     */
    public function add()
    {
        if ('post' == $this->input->method()) {
            $this->load->helper('http');
            $this->load->library('form_validation');
            if (false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
            } else {
                // model
                $model = $this->_modelName;
                $insert_id = $this->$model->add($_POST);
                if (false !== $insert_id) {
                    http_ajax_response(0, $this->_adminConfig[$this->_className]['name'] . '添加成功!');
                } else {
                    http_ajax_response(2, $this->_adminConfig[$this->_className]['name'] . '添加失败!');
                }
            }
        } else {
            // view data
            $this->_headerViewVar['h1_title'] = $this->_adminConfig[$this->_className][__FUNCTION__];
            $this->_headerViewVar['method_name'] = __FUNCTION__;
            $this->load_view();
        }
    }

    /**
     * edit 后台通用修改方法
     *
     * @param int id 数据表主键
     *
     * @return json {"status":0, "msg":"info"}
     * @author wangnan
     * @date 2016-05-04 14:53:16
     */
    public function edit(int $id = 0)
    {
        // model
        $model = $this->_modelName;
        if('post' == $this->input->method()) {
            $this->load->helper('http');
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
            } else {
                $id = (int)$_POST['id'];
                unset($_POST['id']);
                $model_name = $this->_className . '_model';
                $affected_rows = $this->$model_name
                    ->setUpdateData($_POST)
                    ->edit($id);
                if(0 >= $affected_rows) {
                    http_ajax_response(2, $this->_adminConfig[$this->_className]['name'] . '修改失败!');
                } else {
                    http_ajax_response(0, $this->_adminConfig[$this->_className]['name'] . '修改成功!');
                }
            }
        } else {
            // view data
            $this->_headerViewVar['h1_title'] = $this->_adminConfig[$this->_className][__FUNCTION__];
            $this->_headerViewVar['method_name'] = __FUNCTION__;
            $this->_viewVar['data'] = $this->$model
                ->setSelectFields($this->_adminConfig[$this->_className]['index_field'])
                ->find($id);
            $this->load_view();
        }
    }

    /**
     * load_view 加载模板
     *
     * @param string $view 模板名称,默认取与调用此方法的方法同名的视图
     * @param array  $var 分配给模板的变量,会和类变量$_viewVar合并
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-11 00:45:20
     */
    public function load_view(string $view = '', array $var = [])
    {
        // 获取默认视图,默认取与调用此方法的方法同名的视图
        if(empty($view)) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            $view = $this->_className . '/' .$backtrace[1]['function'];
        }

        // 将分配给_viewVar的视图数据和传入的视图数据合并,如果有相同键名则覆盖_viewVar的键值
        $var = array_merge($this->_viewVar, $var);
        // 加载视图并分配视图变量
        $this->load->view('admin/public/header', $this->_headerViewVar);
        $this->load->view("admin/left_nav/{$this->_className}.php");
        $this->load->view('admin/' . $view, $var);
        $this->load->view('admin/public/footer');
    }
}
