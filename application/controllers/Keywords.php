<?php

/**
 * Keywords.php
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-17 15:32:24
 */
class Keywords extends Home_Controller
{
    public function test()
    {
        $this->load_view();
    }
    
    /**
     * advertising 广告法关键字操作页面
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-16 16:05:40
     */
    public function advertising()
    {
        if('post' == $this->input->method()) {
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
            } else {
                // 获取要被匹配查询的内容
                $contents = htmlentities($_POST['contents']);
                // 查询出所有的广告关键字
                $keywords = $this->_model
                    ->setSelectFields('word')
                    ->setAndCond(['type' => 1, 'status' => 0])
                    ->read();
                if(! empty($keywords)) {
                    $keywords = array_column($keywords, 'word');
                    $keywords_replace = $keywords;
                    array_walk($keywords_replace, function(&$v, $k){
                        $v = '<span style="color:red">' . $v . '</span>';
                    });
                    $contents = str_ireplace($keywords, $keywords_replace, $contents);
                }

                http_ajax_response(0, 'ok', $contents);
            }
        } else {
            $this->load_view();
        }
    }
}
