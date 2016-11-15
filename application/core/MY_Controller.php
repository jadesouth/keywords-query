<?php

/**
 * Class MY_Controller 应用的基控制器
 *
 * @property Admin_model           $admin_model
 * @property CI_Config             $config
 * @property CI_Form_validation    $form_validation
 * @property CI_Input              $input
 * @property CI_Pagination         $pagination
 * @property CI_Session            $session
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-11 00:42:03
 */
class MY_Controller extends CI_Controller
{
    /**
     * @var array 登录用户信息
     */
    protected $_login_user = [];
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
     * MY_Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_className = strtolower(get_class($this));
    }
}
