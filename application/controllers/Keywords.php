<?php

/**
 * Class Keywords 关键字查询
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
            // 检测是否有查询权限
            if(0 != $this->_loginUser['status']) {
                $this->load->model('user_model');
                $status = $this->user_model->getUserStatus($this->_loginUser['id']);
                if(0 != $status) {
                    http_ajax_response(2, '您当前无查询权限');
                    return false;
                }
                $this->_loginUser['status'] = $status;
            }
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
                return false;
            }
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
            return true;
        } else {
            $this->load_view();
            return true;
        }
    }

    /**
     * address 地址/旺旺/phone关键字操作页面
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-25 20:58:30
     */
    public function address()
    {
        $this->_headerViewVar['title'] = '地址关键字检测';
        if('post' == $this->input->method()) {
            // 检测登录
            if (! $this->is_login()) {
                http_ajax_response(-1, '请您先登陆');
                return false;
            }
            // 检测是否有查询权限
            if(0 != $this->_loginUser['status']) {
                $this->load->model('user_model');
                $status = $this->user_model->getUserStatus($this->_loginUser['id']);
                if(0 != $status) {
                    http_ajax_response(2, '您当前无查询权限');
                    return false;
                }
                $this->_loginUser['status'] = $status;
            }
            $this->load->library('form_validation');
            if(false === $this->form_validation->run()) {
                http_ajax_response(1, $this->form_validation->error_string());
            } else {
                // 获取要被匹配查询的地址信息
                $province_id = (int)$this->input->post('province');
                $city_id = (int)$this->input->post('city');
                $county_id = (int)$this->input->post('county');
                $address = (string)htmlentities($_POST['address']);
                // 查询地址关键字信息
                $this->load->model('address_keywords_model');
                $condition = [
                    'province_id' => $province_id,
                    'city_id' => $city_id,
                    'county_id' => $county_id,
                    'address' => $address,
                    'status' => 0
                ];
                $count = $this->address_keywords_model
                    ->setAndCond($condition)
                    ->count();
                // 查询出省市县名称
                $this->load->model('dict_area_model');
                $areas = $this->dict_area_model
                    ->setSelectFields('id,name')
                    ->setAndCond(['id []' => [$province_id, $city_id, $county_id], 'status' => 0])
                    ->read();
                if (! empty($areas)) {
                    $area = array_column($areas, 'name', 'id');
                }
                $province_name = empty($area[$province_id]) ? '' : $area[$province_id];
                $city_name = empty($area[$city_id])? '' : $area[$city_id];
                $county_name = empty($area[$county_id]) ? '' : $area[$county_id];
                if( 0 >= $count) {
                    $contents = '省市区/县：' . $province_name . $city_name . $county_name;
                    $contents .= '<br />详细地址：' . $address;
                } else {
                    $contents = '省市区/县：<span style="color:red">' . $province_name . $city_name . $county_name . '</span>';
                    $contents .= '<br />详细地址：<span style="color:red">' . $address . '</span>';
                }

                // 查询旺旺关键字
                $wangwang = (string)htmlentities($this->input->post('wangwang'));
                if (! empty($wangwang)) {
                    $word = $this->_model
                        ->setSelectFields('word')
                        ->setAndCond(['word' => $wangwang, 'type' => 3, 'status' => 0])
                        ->get();
                    if(! empty($word['word']) && $wangwang == $word['word']) {
                        $contents .= '<br />旺旺账号：<span style="color:red">' . $wangwang . '</span>';
                    } else {
                        $contents .= '<br />旺旺账号：' . $wangwang . '</span>';
                    }
                }
                // 查询电话关键字
                $phone = (string)htmlentities($this->input->post('phone'));
                if (! empty($phone)) {
                    $word = $this->_model
                        ->setSelectFields('word')
                        ->setAndCond(['word' => $phone, 'type' => 4, 'status' => 0])
                        ->get();
                    if(! empty($word['word']) && $phone == $word['word']) {
                        $contents .= '<br />手机号码：<span style="color:red">' . $phone . '</span>';
                    } else {
                        $contents .= '<br />手机号码：' . $phone . '</span>';
                    }
                }

                $contents = '<p style="padding:20px;font-size:14px;line-height:200%;">' . $contents;
                $contents .= '<div style="padding:0 20px;font-size:10px;">注：匹配到的内容用红色字体表示</div></p>';
                http_ajax_response(0, 'ok', ['contents' => $contents]);
            }
        } else {
            // 获取省份地址信息
            $this->load->model('dict_area_model');
            $this->_viewVar['provinces'] = $this->dict_area_model
                ->setSelectFields('id,name')
                ->setAndCond(['level' => 1, 'status' => 0])
                ->read();
            $this->load_view();
        }
        return true;
    }

    /**
     * onlyAddress 单独地址关键字操作页面
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-23 17:33:47
     */
    public function onlyAddress()
    {
        $this->_headerViewVar['title'] = '地址关键字检测';
        if('post' == $this->input->method()) {
            // 检测登录
            if (! $this->is_login()) {
                http_ajax_response(-1, '请您先登陆');
                return false;
            }
            // 检测是否有查询权限
            if(0 != $this->_loginUser['status']) {
                $this->load->model('user_model');
                $status = $this->user_model->getUserStatus($this->_loginUser['id']);
                if(0 != $status) {
                    http_ajax_response(2, '您当前无查询权限');
                    return false;
                }
                $this->_loginUser['status'] = $status;
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
        return true;
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
            // 检测登录
            if (! $this->is_login()) {
                http_ajax_response(-1, '请您先登陆');
                return false;
            }
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
        return true;
    }
}
