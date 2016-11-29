<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>管理系统</title>
    <!-- Bootstrap -->
    <link href="<?=base_url()?>resources/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- main -->
    <link href="<?=base_url()?>resources/assets/css/admin/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>resources/assets/libs/bootstrap/js/bootstrap.min.js"></script>
    <!-- layui -->
    <link href="<?=base_url()?>resources/assets/libs/layui/css/layui.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>resources/assets/libs/layui/layui.js" type="application/javascript"></script>
</head>
<body>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top main-nav-bg">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand website-title" href="#">管理系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav main-nav-font">
                <li<?='keywords' == $controller ? ' class="active"' : ''?>><a href="<?=base_url('admin/keywords/advertising')?>">关键字管理</a></li>
                <li<?='detection' == $controller ? ' class="active"' : ''?>><a href="<?=base_url('admin/detection')?>">申请检测管理</a></li>
                <li<?='article' == $controller ? ' class="active"' : ''?>><a href="<?=base_url('admin/article/business')?>">内容管理</a></li>
                <li<?='user' == $controller ? ' class="active"' : ''?>><a href="<?=base_url('admin/user')?>">用户管理</a></li>
                <li<?='admin' == $controller ? ' class="active"' : ''?>><a href="<?=base_url('admin/index')?>">管理员管理</a></li>
                <li<?='articles' == $controller ? ' class="active"' : ''?>><a href="<?=base_url('admin/articles')?>">最新咨訊</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right main-nav-user-info">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=empty($_SESSION['admin_login_user']['login_name']) ? '未知用户' : $_SESSION['admin_login_user']['login_name']?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url('admin/logout')?>">退出系统</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>