<?php

/**
 * Class MY_Controller 应用的基控制器
 *
 * @property Admin_model                   $admin_model
 * @property CI_Config                     $config
 * @property CI_Form_validation            $form_validation
 * @property CI_Input                      $input
 * @property CI_Pagination                 $pagination
 * @property CI_Session                    $session
 * @property Detection_apply_info_model    $detection_apply_info_model
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-11 00:42:03
 */
class MY_Controller extends CI_Controller
{
    /**
     * @var MY_Model 当前Controller对应的主Model名称
     */
    protected $_model = 'MY_Model';
    /**
     * @var array 登录用户信息
     */
    protected $_loginUser = [];
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
        // 如果类名对应的模型存在就加载,否则加载MY_Model
        $model_path = PATH_MODEL . ucfirst($this->_className) . '_model.php';
        if(file_exists($model_path)) {
            $this->_model = $this->_className . '_model';
        }
        // 加载控制器操作的主model
        $this->load->model($this->_model);
        $this->_model = $this->{$this->_model};
        // 导航用的控制器名
        $this->_headerViewVar['controller'] = $this->_className;
    }

    /**
     * is_login 是否登录
     *
     * @return bool
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-23 22:20:16
     */
    protected function is_login(): bool
    {
        return empty($this->_loginUser) ? false : true;
    }
}
