<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>后台登录-西今科技有限公司</title>
    <meta name="author" content="DeathGhost" />
    <link href="<?=base_url()?>resources/assets/css/admin/login.css" tppabs="<?=base_url()?>resources/assets/css/admin/login.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>resources/assets/libs/layui/css/layui.css" rel="stylesheet" type="text/css">
    <style>
        body{height:100%;background:#16a085;overflow:hidden;}
        canvas{z-index:-1;position:absolute;}
    </style>
</head>
<body>
<form id="login-form">
<dl class="admin_login">
    <dt>
        <strong>西今科技后台管理系统</strong>
        <em>Management System</em>
    </dt>
    <dd class="user_icon">
        <input id="login-name" name="login_name" type="text" placeholder="账号" class="login_txtbx"/>
    </dd>
    <dd class="pwd_icon">
        <input id="password" type="password" name="password" placeholder="密码" class="login_txtbx"/>
    </dd>
    <dd class="val_icon">
        <div class="checkcode">
            <input type="text" id="J_codetext" placeholder="验证码" maxlength="4" class="login_txtbx">
            <canvas class="J_codeimg" id="myCanvas" onclick="createCode()">对不起，您的浏览器不支持canvas，请下载最新版浏览器!</canvas>
        </div>
        <input id="verify-code" type="button" value="验证码核验" class="ver_btn" onClick="validate();">
    </dd>
    <dd>
        <input id="submit" type="button" value="立即登录" class="submit_btn"/>
    </dd>
    <dd>
        <p>© 2016-2018 xijin.com 版权所有</p>
        <p></p>
    </dd>
</dl>
</form>
<script src="<?=base_url()?>resources/assets/libs/jquery/jquery-3.1.1.min.js" type="text/javascript" ></script>
<script src="<?=base_url()?>resources/assets/js/admin/login_verificationNumbers.js" tppabs="<?=base_url()?>resources/assets/js/admin/login_verificationNumbers.js" type="text/javascript" ></script>
<script src="<?=base_url()?>resources/assets/js/admin/login_Particleground.js" tppabs="<?=base_url()?>resources/assets/js/admin/login_Particleground.js" type="text/javascript" ></script>
<script src="<?=base_url()?>resources/assets/libs/layui/layui.js" type="application/javascript"></script>
<script>
$(document).ready(function() {
    //粒子背景特效
    $('body').particleground({
        dotColor: '#5cbdaa',
        lineColor: '#5cbdaa'
    });
    //验证码
    createCode();
    // 加载 layui
    layui.use('layer', function(){
        var layer = layui.layer;
    });
    //测试提交，对接程序删除即可
    $("#submit").click(function(){
        // 对用户输入进行验证
        var $login_name = $('#login-name').val();
        if(undefined == $login_name || '' == $login_name || false == $login_name) {
            layer.tips('请输入登录账号', '#login-name', {
                tips: [2, '#F24100']
            });
            return false;
        }
        var $password = $('#password').val();
        if(undefined == $password || '' == $password || false == $password) {
            layer.tips('请输入登录密码', '#password', {
                tips: [2, '#F24100']
            });
            return false;
        }
        var $verify_code = $('#J_codetext').val();
        if(undefined == $verify_code || '' == $verify_code || false == $verify_code) {
            layer.tips('请输入验证码', '#verify-code', {
                tips: [2, '#F24100']
            });
            return false;
        }

        if(true == validate()) { // 验证码验证通过
            // Ajax提交表单
            $.ajax({
                type: "POST",
                url: "<?=base_url('admin/login')?>",
                data: $("#login-form").serialize(),
                dataType: "json",
                success: function(response){
                    if(0 == response.status) {
                        window.location.href = "<?=base_url('admin')?>";
                    } else if(1 == response.status) {
                        layer.tips(response.msg, '#submit', {
                            tips: [1, '#F24100']
                        });
                    } else if(2 == response.status) {
                        layer.tips(response.msg, '#login-name', {
                            tips: [2, '#F24100']
                        });
                    } else if(3 == response.status) {
                        layer.tips(response.msg, '#password', {
                            tips: [2, '#F24100']
                        });
                    }
                }
            });
        } else {
            layer.tips('验证码输入有误', '#verify-code', {
                tips: [2, '#F24100']
            });
            return false;
        }
    });
});
</script>
</body>
</html>
