<!-- main content -->
<div class="container-fluid">
    <div class="row">
        <!-- left nav -->
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li <?='area' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/webSetting/area')?>">区域数据管理<?='area' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
            </ul>
        </div>
        <!-- right content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header"><?=$h1_title?></h3>