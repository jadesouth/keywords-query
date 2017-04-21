<?php

/**
 * Class Detection_apply_info_model
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   16-11-27 下午8:18
 */
class Detection_apply_info_model extends MY_Model
{
    /**
     * getAllCount 获取列表总数
     *
     * @return bool|int 总数
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-27 20:54:27
     */
    public function getAllCount()
    {
        $this->_leftJoin = ['user' => 'detection_apply_info.user_id = user.id'];
        $this->_conditions = [
            'AND' => [
                'detection_apply_info.status' => 0,
            ],
        ];

        return $this->leftCount();
    }

    /**
     * getAllPage 获取分页数据
     *
     * @param int $page      第几页
     * @param int $page_size 分页大小
     *
     * @return array|bool
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-11-27 21:00:26
     */
    public function getAllPage(int $page = 1, int $page_size = ADMIN_PAGE_SIZE)
    {
        $page = 0 >= $page ? 1 : $page;
        $offset = ($page - 1) * $page_size;
        // 左关联查询
        $this->_leftJoin = ['user' => 'detection_apply_info.user_id = user.id'];
        $this->_conditions = [
            'AND'   => [
                'detection_apply_info.status' => 0,
            ],
            'LIMIT' => [$page_size, $offset],
            'ORDER' => 'id DESC',
        ];
        $this->_selectFields = ['detection_apply_info.id', 'login_name', 'phone', 'qq', 'email', 'apply_time'];

        return $this->leftRead();
    }
}
