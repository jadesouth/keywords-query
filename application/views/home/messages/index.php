<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>给我们留言</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="<?=base_url()?>resources/assets/libs/layui/css/layui.css" rel="stylesheet" type="text/css">
    <style>
        .w60{width:60px;padding-left:0;}
        .m100{margin-left:100px;}
    </style>
</head>
<body>
<blockquote class="layui-elem-quote">给我们留言</blockquote>
<div style="padding:10px 25px;">
    <form class="layui-form" id="leave_message">
        <div class="layui-form-item">
            <label class="layui-form-label w60">手机</label>
            <div class="layui-input-block m100">
                <input type="tel" name="phone" lay-verify="phone" autocomplete="off" class="layui-input" placeholder="请输入手机">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label w60">邮箱</label>
            <div class="layui-input-block m100">
                <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input" placeholder="请输入邮箱">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label w60">QQ</label>
            <div class="layui-input-block m100">
                <input type="number" name="qq" lay-verify="number" autocomplete="off" class="layui-input" placeholder="请输入QQ">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label w60">留言内容</label>
            <div class="layui-input-block m100">
                <textarea placeholder="请输入内容" class="layui-textarea" lay-verify="required" name="content"></textarea>
            </div>
        </div>
        <div class="layui-form-item" style="margin-top:26px;">
            <button lay-submit class="layui-btn" style="width:100%" lay-filter="go">提交</button>
        </div>
    </form>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="<?=base_url()?>resources/assets/libs/layui/layui.js" type="application/javascript"></script>
<script>
    layui.use(['form'], function(){
        var form = layui.form();
        //监听提交
        form.on('submit(go)', function(data){
            $.ajax({
                type: "POST",
                url: "/messages/ajax_leave_message",
                data: $('#leave_message').serialize(),
                dataType: "json",
                success: function (response) {
                    if (0 == response.status) {
                        var index = parent.layer.getFrameIndex(window.name);
                        window.parent.layer.msg(response.msg, {icon: 6});
                        parent.layer.close(index);

                    } else if (1 == response.status) {
                        layer.msg(response.msg);
                        return false;
                    }
                }
            });
            return false;
        });
    });
</script>
</body>
</html>