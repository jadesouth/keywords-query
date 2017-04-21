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
        'name'         => '管理员',
        'index'        => '管理员列表',
        'add'          => '添加管理员',
        'edit'         => '修改管理员',
        'table_header' => ['#', '登录账号', '添加时间', '状态<br>0:禁用,1:正常', '操作'],
        'index_field'  => 'id,login_name,created_at,status',
    ],
    'article' => [
        'name'         => '文章管理',
        'index'        => '文章列表',
        'add'          => '添加文章',
        'edit'         => '修改文章',
        'table_header' => ['#', '文章标题', '所属类型', '短标题', '状态<br>0:显示,1:隐藏', '操作'],
        'index_field'  => 'id,title,cid,subtitle,status',
    ],
    // 查询权限申请管理
    'detection' => [
        'name'         => '申请管理',
        'index'        => '申请列表',
        'table_header' => ['#', '申请用户', '电话', 'QQ', 'E-mail', '申请时间', '操作'],
        'index_field'  => 'id,title,cid,subtitle,status',
    ],
    // Banner 管理
    'banner' => [
        'name'         => 'Banner 管理',
        'index'        => 'Banner 列表',
        'add'          => '添加 Banner',
        'table_header' => ['#', 'Banner', '添加时间', '状态', '操作'],
        'index_field'  => 'id,img_path,created_at,status',
    ],
];
