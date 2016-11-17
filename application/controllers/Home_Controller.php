<?php

/**
 * Class Home_Controller
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   16-11-17 15:24
 */
class Home_Controller extends MY_Controller
{
    /**
     * load_view 加载模板
     *
     * @param string $view 模板名称,默认取与调用此方法的方法同名的视图
     * @param array  $var 分配给模板的变量,会和类变量$_viewVar合并
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-17 15:51:18
     */
    public function load_view(string $view = '', array $var = [])
    {
        // 获取默认视图,默认取与调用此方法的方法同名的视图
        if(empty($view)) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            $view = $this->_className . '/' .$backtrace[1]['function'];
        }

        // 将分配给_viewVar的视图数据和传入的视图数据合并,如果有相同键名则覆盖_viewVar的键值
        $var = array_merge($this->_headerViewVar, $this->_viewVar, $var);
        // 加载视图并分配视图变量
        $this->load->view('home/public/header', $var);
        $this->load->view('home/' . $view);
        $this->load->view('home/public/footer');
    }
}
