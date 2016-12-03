<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?=$title?></title>
    <link href="<?=base_url()?>resources/assets/css/home/style.css" rel="stylesheet">
    <!-- layui -->
    <link href="<?=base_url()?>resources/assets/libs/layui/css/layui.css" rel="stylesheet" type="text/css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <link href="<?=base_url()?>resources/assets/libs/qq-chat/css/zzsc.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div style="width:100%;padding:5px 0;background-color:#333;float:left;">
    <span class="layui-breadcrumb" lay-separator="|" style="float:right;padding-right:6%;color:#FFFFFF">
        <?php if(empty($_SESSION['home_login_user'])){?>
            <a><span style="color:#FFFFFF;" class="register-btn">注册</span></a>
            <a><span style="color:#FFFFFF;" class="login-btn">登陆</span></a>
        <?php }else{ ?>
            <a href="/user/detail"><span style="color:#FFFFFF;cursor:Default;">个人中心</span></a>
            <a href="/user/logout"><span style="color:#FFFFFF;cursor:Default;">退出</span></a>
        <?php }?>
    </span>
</div>

<div class="header clearfix">
    <div class="m-width clearfix">
        <div class="h-logo fl"><i class="fl"><a href=""><img src="/resources/assets/images/logo.png"/></a></i>西今科技</div>
        <div class="h-hot-menu fl">
            <a <?='index' == $method_name ? 'class="menu-hover"' : ''?> href="<?=base_url()?>">首页</a>
            <a <?='business' == $method_name ? 'class="menu-hover"' : ''?> href="<?=base_url('articles/business')?>">业务介绍</a>
            <a <?='property' == $method_name ? 'class="menu-hover"' : ''?> href="<?=base_url('articles/property')?>">知识产权服务</a>
            <a <?='price' == $method_name ? 'class="menu-hover"' : ''?> href="<?=base_url('articles/price')?>">价格管控</a>
            <a <?='cases' == $method_name ? 'class="menu-hover"' : ''?> href="<?=base_url('articles/cases')?>">合作案例</a>
            <a <?='advertising' == $method_name ? 'class="menu-hover"' : ''?> href="<?=base_url('keywords/advertising')?>">广告法检测</a>
            <a <?='address' == $method_name ? 'class="menu-hover"' : ''?> href="<?=base_url('keywords/address')?>">地址检测</a>
            <a <?='about' == $method_name ? 'class="menu-hover"' : ''?> href="<?=base_url('articles/about')?>">关于我们</a>
        </div>
    </div>
</div>