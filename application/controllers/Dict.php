<?php

/**
 * Class DictArea
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-12-25 18:54:51
 */
class Dict extends Home_Controller
{
    /**
     * areaCity 根据省份ID获取市区信息
     *
     * @param int $province_id 省份ID
     *
     * @return bool
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-25 19:05:20
     */
    public function areaCity(int $province_id)
    {
        $this->load->helper('http');
        if (0 >= $province_id) {
            http_ajax_response(1, '非法请求!');
            return false;
        }

        $this->load->model('dict_area_model');
        $city = $this->dict_area_model->setSelectFields('id,name')
            ->setAndCond(['pid' => $province_id, 'status' => 0])
            ->read();

        http_ajax_response(0, '获取市区信息成功', $city);
        return true;
    }

    /**
     * areaCounty 根据市区ID获取县城信息
     *
     * @param int $city_id 市区ID
     *
     * @return bool
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-12-25 19:38:47
     */
    public function areaCounty(int $city_id)
    {
        $this->load->helper('http');
        if (0 >= $city_id) {
            http_ajax_response(1, '非法请求!');
            return false;
        }

        $this->load->model('dict_area_model');
        $city = $this->dict_area_model->setSelectFields('id,name')
            ->setAndCond(['pid' => $city_id, 'status' => 0])
            ->read();

        http_ajax_response(0, '获取县城信息成功', $city);
        return true;
    }
}
