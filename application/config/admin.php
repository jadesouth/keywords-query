<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台相关配置文件
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-13 20:17:30
 */
$config = [
    // 管理员管理
    'admin' => [
        'name' => '管理员',
        'index' => '管理员列表',
        'add' => '添加管理员',
        'edit' => '修改管理员',
        'table_header' => ['#', '登录账号', '添加时间', '状态<br>0:禁用,1:正常', '操作'],
        'index_field' => 'id,login_name,created_at,status',
    ],
];
