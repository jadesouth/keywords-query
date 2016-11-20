<?php
/**
 * Created by PhpStorm.
 * User: haokaiyang
 * Date: 16-11-12
 * Time: 19:56:50
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User_model 用户模型
 */
class User_model extends MY_Model
{
    /**
     * add 添加用户,同时添加user和user_profile表数据
     *
     * @param array $user_info 用户信息
     *
     * @return bool
     *
     * @author haokaiyang
     * @date   2016-11-20 15:27:44
     */
    public function add(array $user_info)
    {
        if (empty($user_info['login_name']) || empty($user_info['password'])) {
            return false;
        }
        $this->load->helper(['tools', 'security']);
        $this->db->trans_start();
        $this->_insertData['login_name'] = $user_info['login_name'];
        $this->_insertData['salt'] = random_characters();
        $this->_insertData['password'] = generate_admin_password($user_info['password'], $this->_insertData['salt']);
        $this->_insertData['status'] = 1; // 状态[0:有权限,1:无权限]
        $user_id = $this->create([], true);
        $this->_table = 'user_profile';
        $this->_insertData['user_id'] = $user_id;
        $this->_insertData['reg_time'] = time();
        $this->_insertData['reg_ip'] = get_ip();
        $this->create();
        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            return false;
        }
        return $user_id;
    }

    /**
     * read_user_list 读取用户列表
     *
     * @param int $page
     * @param int $page_size
     * @param string $order
     * @param array $condition
     *
     * @return array
     * @author haokaiyang
     * @date   2016-11-12 23:35:55
     */
    public function read_user_list(int $page = 0, int $page_size = ADMIN_PAGE_SIZE, string $order = '', array $condition = [])
    {
        $this->load->database();
        if (! empty($condition)) {
            $this->db->where($condition);
        }
        $page = 0 >= $page ? 1 : $page;
        $limit = 0 >= $page_size ? 20 : $page_size;
        $offset = 0 > $page ? 0 : ($page - 1) * $page_size;

        $order = empty($order) ? 'user.created_at DESC' : (string)$order;
        $select_field = 'user.id,user.login_name,user_profile.phone,user_profile.real_name,user_profile.qq,user_profile.reg_time,user.status';
        return $this->db->select($select_field)
                        ->from('user')
                        ->join('user_profile', 'user_profile.user_id=user.id')
                        ->where('user.deleted_at', '0000-00-00 00:00:00')
                        ->order_by($order)
                        ->limit($limit, $offset)
                        ->get()
                        ->result_array();
    }

    /**
     * get_user_info
     * 获取用户信息
     *
     * @param int $user_id
     *
     * @author haokaiyang
     * @date   2016-11-15 23:27:47
     */
    public function get_user_info(int $user_id)
    {
        $this->load->database();
        $select_field = 'user.id,user.login_name,user_profile.sex,user_profile.phone,user_profile.real_name,user_profile.email,user_profile.idcard,user_profile.qq,user_profile.reg_time,user_profile.reg_ip,user_profile.last_login_time,user_profile.last_login_ip,user.status';
        return $this->db->select($select_field)
                        ->from('user')
                        ->join('user_profile', 'user_profile.user_id=user.id')
                        ->where('user.deleted_at', '0000-00-00 00:00:00')
                        ->get()
                        ->row_array();
    }
}