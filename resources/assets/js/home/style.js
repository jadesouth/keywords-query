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
    $('.content_mark').click(function(){
        $('.denglu').hide(0);
        $('.content_mark').hide(0);
    });
    $('.close').click(function(){
        $('.denglu').hide(0);
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
//banner
//$(document).ready(function(){
//    $('.flicker-example').flicker();
//});
//表单美化