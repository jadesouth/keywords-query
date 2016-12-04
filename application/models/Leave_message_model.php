<?php
/**
 * Created by PhpStorm.
 * User: haokaiyang
 * Date: 2016/11/30
 * Time: 下午10:07
 */
class Leave_message_model extends MY_Model
{
    /**
     * getAllCount 获取列表总数
     *
     * @return bool|int 总数
     * @author haokaiyang
     * @date 2016-11-30 22:10:04
     */
    public function getAllCount()
    {
        $this->_leftJoin = ['user' => 'leave_message.user_id = user.id'];
        $this->_conditions = [
            'AND' => [
                'leave_message.status' => 0,
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
     * @author haokaiyang
     * @date   2016-11-30 22:10:22
     */
    public function getAllPage(int $page = 1, int $page_size = ADMIN_PAGE_SIZE)
    {
        $page = 0 >= $page ? 1 : $page;
        $offset = ($page - 1) * $page_size;
        // 左关联查询
        $this->_leftJoin = ['user' => 'leave_message.user_id = user.id'];
        $this->_conditions = [
            'AND'   => [
                'leave_message.status' => 0,
            ],
            'LIMIT' => [$page_size, $offset],
            'ORDER' => 'id DESC',
        ];
        $this->_selectFields = ['leave_message.id', 'login_name', 'phone', 'qq', 'email', 'content', 'leave_time'];

        return $this->leftRead();
    }
}
