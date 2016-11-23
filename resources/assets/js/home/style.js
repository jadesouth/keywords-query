$(document).ready(function() {
    jQuery.jqtab = function(tabtit,tab_conbox,shijian) {
        $(tab_conbox).find("div").hide();
        $(tabtit).find("p:first").addClass("thistab").show();
        $(tab_conbox).find("div:first").show();

        $(tabtit).find("p").bind(shijian,function(){
            $(this).addClass("thistab").siblings("p").removeClass("thistab");
            var activeindex = $(tabtit).find("p").index(this);
            $(tab_conbox).children().eq(activeindex).show().siblings().hide();
            return false;
        });

    };
    /*调用方法如下：*/
    $.jqtab(".main-Brand dt",".main-Brand dd","click");
    $.jqtab(".m3-k",".m4","click");
    //$.jqtab("#tabs2","#tab_conbox2","mouseenter");

});

$(document).ready(function() {
    jQuery.newstab = function(tabtit,tab_conbox,shijian) {
        $(tab_conbox).find(".main-News-Con").hide();
        $(tabtit).find("p:first").addClass("thistab").show();
        $(tab_conbox).find(".main-News-Con:first").show();

        $(tabtit).find("p").bind(shijian,function(){
            $(this).addClass("thistab").siblings("p").removeClass("thistab");
            var activeindex = $(tabtit).find("p").index(this);
            $(tab_conbox).children().eq(activeindex).show().siblings().hide();
            return false;
        });

    };
    /*调用方法如下：*/
    $.newstab(".main-News-Tab-Box",".main-News-Con-Box","mouseenter");

    //$.newstab("#tabs2","#tab_conbox2","mouseenter");

});

$(document).ready(function() {
    jQuery.doctab = function(tabtit,tab_conbox,shijian) {
        $(tab_conbox).find(".doc-box-box").hide();
        $(tabtit).find("p:first").addClass("thistab").show();
        $(tab_conbox).find(".doc-box-box:first").show();

        $(tabtit).find("p").bind(shijian,function(){
            $(this).addClass("thistab").siblings("p").removeClass("thistab");
            var activeindex = $(tabtit).find("p").index(this);
            $(tab_conbox).children().eq(activeindex).show().siblings().hide();
            return false;
        });

    };
    /*调用方法如下：*/
    $.doctab(".doc-box-tab",".doc-box","click");

    //$.doctab("#tabs2","#tab_conbox2","mouseenter");

});

$(function(){
    $('.login-btn').click(function(){
        $('.denglu').show(0);
        $('.content_mark').show(0);
    });
    $('.register-btn').click(function(){
        $('.register').show(0);
        $('.content_mark').show(0);
    });
    $('.content_mark').click(function(){
        $('.denglu').hide(0);
        $('.register').hide(0);
        $('.content_mark').hide(0);
    });
    $('.close').click(function(){
        $('.denglu').hide(0);
        $('.register').hide(0);
        $('.content_mark').hide(0);
    });
    //添加家人弹出层
    $('.addhome-btn').click(function(){
        $('.addhome-walk').show(0);
        $('.addhome-mark').show(0);
    });
    $('.addhome-mark').click(function(){
        $('.addhome-walk').hide(0);
        $('.addhome-mark').hide(0);
    });
    $('.addhome-close').click(function(){
        $('.addhome-walk').hide(0);
        $('.addhome-mark').hide(0);
    });
});
// 加载layer
layui.use(['layer', 'form', 'upload', 'element'], function () {
    var layer = layui.layer;
    var form = layui.form();
    var element = layui.element();
});
// 注册账号
$(".btn-register").click(function () {
    var login_name = $('.register .login_name input').val();
    var password = $('.register .password input').val();
    var con_password = $('.register .con_password input').val();
    
    if (undefined == login_name || '' == login_name || false == login_name) {
        layer.msg('请输入用户名');
        return false;
    }
    if (!(/^[a-zA-Z]{1}([a-zA-Z0-9]|[._]){4,19}$/).exec(login_name)){
        layer.msg('请输入5-20位以字母开头的用户名');
        return false;
    }
    if (undefined == password || '' == password || false == password) {
        layer.msg('请输入登录密码');
        return false;
    }
    if (password.length > 16 || password.length < 6){
        layer.msg('请输入6-16位密码');
        return;
    }
    if (undefined == con_password || '' == con_password || false == con_password) {
        layer.msg('请输入确定密码');
        return false;
    }
    if (password != con_password) {
        layer.msg('您输入的密码不一致,请重新输入');
        return false;
    }

    $.ajax({
        type: "POST",
        url: "/user/ajax_register",
        data: {'login_name': login_name, 'password': password, 'con_password': con_password},
        dataType: "json",
        success: function (response) {
            if (0 == response.status) {
                layer.msg(response.msg, {icon: 6, time:1000}, function () {
                    window.location.reload();
                });
            } else if (1 == response.status) {
                layer.alert(response.msg, {icon: 2});
                return false;
            }
        }
    });
});

// 登录账号
$(".btn-login").click(function () {
    var login_name = $('.denglu .login_name input').val();
    var password = $('.denglu .password input').val();
    
    if (undefined == login_name || '' == login_name || false == login_name) {
        layer.msg('请输入用户名');
        return false;
    }
    if (undefined == password || '' == password || false == password) {
        layer.msg('请输入登录密码');
        return false;
    }

    $.ajax({
        type: "POST",
        url: "/user/ajax_login",
        data: {'login_name': login_name, 'password': password},
        dataType: "json",
        success: function (response) {
            if (0 == response.status) {
                layer.msg(response.msg, {icon: 6, time:1000}, function () {
                    window.location.reload();
                });
            } else if (1 == response.status) {
                layer.alert(response.msg, {icon: 2});
                return false;
            }
        }
    });
});

// 修改信息
$(".btn-edit-user").click(function () {
    $.ajax({
        type: "POST",
        url: "/user/detail",
        data: $('#user-detail').serialize(),
        dataType: "json",
        success: function (response) {
            if (0 == response.status) {
                layer.alert(response.msg, {icon: 6}, function () {
                    window.location.reload();
                });
            } else if (1 == response.status) {
                layer.alert(response.msg);
                return false;
            }
        }
    });
});

// 修改密码
$(".btn-change-password").click(function () {
    $.ajax({
        type: "POST",
        url: "/user/change_password",
        data: $('#user-change-password').serialize(),
        dataType: "json",
        success: function (response) {
            if (0 == response.status) {
                layer.alert(response.msg, {icon: 6}, function () {
                    window.location.reload();
                });
            } else if (1 == response.status) {
                layer.alert(response.msg);
                return false;
            }
        }
    });
});
