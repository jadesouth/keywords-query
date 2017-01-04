<!-- main content -->
<div class="container-fluid">
    <div class="row">
        <!-- left nav -->
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li <?='business' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/article/business')?>">业务介绍<?='business' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='cases' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/article/cases')?>">合作案例<?='cases' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='property' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/article/property')?>">知识产权服务<?='property' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='price' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/article/price')?>">外包服务<?='price' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='about' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/article/about')?>">联系我们<?='about' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
            </ul>
        </div>
        <!-- right content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header"><?=$h1_title?></h3>