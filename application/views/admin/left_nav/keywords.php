<!-- main content -->
<div class="container-fluid">
    <div class="row">
        <!-- left nav -->
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li <?='advertising' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/keywords/advertising')?>">广告法关键字<?='advertising' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='addressPage' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/keywords/addressPage')?>">地址关键字<?='advertising' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='wangwang' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/keywords/wangwang')?>">旺旺关键字<?='address' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='phone' == $method_name ? 'class="active"' : ''?>><a href="<?=base_url('admin/keywords/phone')?>">电话关键字<?='address' == $method_name ? '<span class="sr-only">(current)</span>' : ''?></a></li>
            </ul>
        </div>
        <!-- right content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header"><?=$h1_title?></h3>