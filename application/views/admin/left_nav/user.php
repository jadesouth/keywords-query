<!-- main content -->
<div class="container-fluid">
    <div class="row">
        <!-- left nav -->
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li <?='all' == $user_type ? 'class="active"' : ''?>><a href="<?=base_url('/admin/user/?type=all')?>">用户列表<?='all' == $user_type ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='authorized' == $user_type ? 'class="active"' : ''?>><a href="<?=base_url('/admin/user/?type=authorized')?>">有权限的用户列表<?='authorized' == $user_type ? '<span class="sr-only">(current)</span>' : ''?></a></li>
                <li <?='normal' == $user_type ? 'class="active"' : ''?>><a href="<?=base_url('/admin/user/?type=normal')?>">无权限的用户列表<?='normal' == $user_type ? '<span class="sr-only">(current)</span>' : ''?></a></li>
            </ul>
        </div>
        <!-- right content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header"><?=$h1_title?></h3>