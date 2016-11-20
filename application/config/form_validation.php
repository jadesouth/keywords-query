<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 表单验证匹配规则配置文件
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-13 20:17:30
 */
$config = [
    // 配置错误定界符
    'error_prefix' => '<p class="text-danger">',
    'error_suffix' => '</p>',
    // 管理管理员相关
    'admin/manager/login' => [ // 管理员登陆
        ['field' => 'login_name', 'label' => '用户名', 'rules' => 'trim|required|min_length[4]|max_length[18]'],
        ['field' => 'password', 'label' => '密码', 'rules' => 'trim|required|min_length[6]|max_length[18]'],
    ],
    'admin/admin/add' => [ // 添加管理员
        ['field' => 'login_name', 'label' => '登录账号', 'rules' => 'trim|required|min_length[4]|max_length[18]|is_unique[admin.login_name]'],
        ['field' => 'password', 'label' => '登录密码', 'rules' => 'trim|required|min_length[6]|max_length[18]'],
    ],
    'admin/admin/edit' => [ // 编辑管理员
        ['field' => 'id', 'label' => '登录密码', 'rules' => 'trim|required|integer'],
        ['field' => 'password', 'label' => '登录密码', 'rules' => 'trim|min_length[6]|max_length[18]'],
        ['field' => 'lock', 'label' => '是否禁用', 'rules' => 'trim|in_list[0,1]'],
    ],
    'admin/keywords/add' => [ // 添加管理员
        ['field' => 'type', 'label' => '关键字类型', 'rules' => 'trim|required|in_list[1,2]'],
        ['field' => 'word', 'label' => '关键字', 'rules' => 'trim|required'],
    ],
    'keywords/advertising' => [ // 广告法关键字查询
        ['field' => 'contents', 'label' => '内容', 'rules' => 'trim|required'],
    ],
    'user/ajax_register' => [ // 用户注册
        ['field' => 'login_name', 'laber' => '登录名', 'rules'=> 'trim|required|is_unique[user.login_name]'],
        ['field' => 'password', 'laber' => '密码', 'rules'=> 'trim|required'],
        ['field' => 'con_password', 'laber' => '确认密码', 'rules'=> 'trim|required|matches[password]'],
    ],
];
