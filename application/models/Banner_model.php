<?php

/**
 * Class Banner_model Banner管理模型
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   16-12-28 13:56
 */
class Banner_model extends MY_Model
{
    /**
     * add 添加 Banner
     *
     * @param array $banner_info Banner 信息
     *
     * @return mixed
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-28 21:52:17
     */
    public function add(array $banner_info)
    {
        if (empty($banner_info['banner'])) {
            return false;
        }

        $this->_insertData['img_path'] = $banner_info['banner'];
        return $this->create();
    }
}
