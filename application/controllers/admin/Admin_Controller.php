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
     * @var string 当前初始化的类名称
     */
    protected $_className = __CLASS__;
    /**
     * @var array 给Header视图分配的变量
     */
    protected $_headerViewVar = [];
    /**
     * @var array 给视图分配的变量
     */
    protected $_viewVar = [];


    /**
     * Admin_Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_className = strtolower(get_class($this));
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
            $view = $backtrace[1]['function'];
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
