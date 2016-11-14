<?php

/**
 * Class Admin_model
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   16-11-12 下午9:43
 */
class Admin_model extends MY_Model
{
    /**
     * add 添加管理员
     *
     * @param array $admin_info 管理员信息
     * @return mixed
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 20:46:43
     */
    public function add(array $admin_info)
    {
        if(empty($admin_info['login_name']) || empty($admin_info['password'])) {
            return false;
        }

        $this->load->helper(['tools', 'security']);
        $this->_insertData['login_name'] = $admin_info['login_name'];
        $this->_insertData['salt']       = random_characters();
        $this->_insertData['password']   = generate_admin_password($admin_info['password'], $this->_insertData['salt']);
        $this->_insertData['status']     = 0; // 状态[0:正常,1:禁止]

        return $this->create();
    }

    /**
     * edit 根据ID修改管理员信息
     *
     * @param int $id 主键ID
     * @return int 影响的行数
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 20:47:21
     */
    public function edit(int $id)
    {
        if(0 >= $id ) {
            return false;
        }
        $this->load->helper(['tools', 'security']);
        $this->_updateData['status'] = $this->_updateData['lock']; // 状态[0:正常,1:禁止]
        unset($this->_updateData['lock']);
        if(! empty($this->_updateData['password'])) {
            $this->_updateData['salt'] = random_characters();
            $this->_updateData['password'] = generate_admin_password($this->_updateData['password'], $this->_updateData['salt']);
        }
        $this->_conditions['AND']['id ='] = $id;
        return $this->update();
    }
}