<!-- main content -->
<div class="container-fluid">
    <div class="row">
        <!-- left nav -->
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li <?='index' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/index')?>">管理员列表<?='index' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='add' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/add')?>">添加管理员<?='add' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
            </ul>
        </div>
        <!-- right content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header"><?=$h1_title?></h3>