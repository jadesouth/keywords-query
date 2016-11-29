<?php

/**
 * Keywords.php
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-17 15:32:24
 */
class Keywords extends Home_Controller
{
    /**
     * advertising 广告法关键字操作页面
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-16 16:05:40
     */
    public function advertising()
    {
        $this->_headerViewVar['title'] = '广告法检测';
        if('post' == $this->input->method()) {
            // 检测登录
            if (! $this->is_login()) {
                http_ajax_response(-1, '请您先登录');
                return false;
            }
            if(0 != $this->_loginUser['status']) {
                http_ajax_response(2, '您当前无查询权限');
                return false;
            }
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
                        $v = '<span style="color:red;">' . $v . '</span>';
                    });
                    $contents = str_ireplace($keywords, $keywords_replace, $contents);
                }
                $contents = '<p style="padding:20px 10px;line-height:150%">' . $contents . '</p>';
                http_ajax_response(0, 'ok', ['contents' => $contents]);
            }
        } else {
            $this->load_view();
        }
    }

    /**
     * address 地址关键字操作页面
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-23 17:33:47
     */
    public function address()
    {
        $this->_headerViewVar['title'] = '地址关键字检测';
        if('post' == $this->input->method()) {
            // 检测登录
            if (! $this->is_login()) {
                http_ajax_response(-1, '请您先登录');
                return false;
            }
            if(0 != $this->_loginUser['status']) {
                http_ajax_response(2, '您当前无查询权限');
                return false;
            }
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
            } else {
                // 获取要被匹配查询的内容
                $contents = htmlentities($_POST['contents']);
                // 查询出所有的广告关键字
                $keywords = $this->_model
                    ->setSelectFields('word')
                    ->setAndCond(['type' => 2, 'status' => 0])
                    ->read();
                if(! empty($keywords)) {
                    $keywords = array_column($keywords, 'word');
                    $keywords_replace = $keywords;
                    array_walk($keywords_replace, function(&$v, $k){
                        $v = '<span style="color:red">' . $v . '</span>';
                    });
                    $contents = str_ireplace($keywords, $keywords_replace, $contents);
                }
                $contents = '<p style="padding:20px 10px;line-height:150%">' . $contents . '</p>';
                http_ajax_response(0, 'ok', ['contents' => $contents]);
            }
        } else {
            $this->load_view();
        }
    }

    /**
     * apply 查询权限申请
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-27 22:00:41
     */
    public function apply()
    {
        if('post' == $this->input->method()) {
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
            } else {
                $insert_data = [
                    'user_id'    => $this->_loginUser['id'],
                    'phone'      => $_POST['phone'],
                    'qq'         => $_POST['qq'],
                    'email'      => $_POST['email'],
                    'apply_time' => date('Y-m-d H:i:s'),
                ];
                // 插入申请数据
                $this->load->model('detection_apply_info_model');
                $res = $this->detection_apply_info_model
                    ->setInsertData($insert_data)
                    ->create();
                if(false !== $res) {
                    http_ajax_response(0, '申请成功，我们会及时联系您给您开通权限！');
                } else {
                    http_ajax_response(2, '申请失败，请稍后再试！');
                }
            }
        } else {
            $this->_headerViewVar['title'] = '检测权限申请';
            $this->load_view();
        }
    }
}
