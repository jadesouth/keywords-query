<div class="m-width">
    <span style="margin-left:35px;" class="layui-breadcrumb">
        <a href="<?=base_url()?>">首页</a>
        <a><cite><?=$title?></cite></a>
    </span>
    <div style="margin-top:20px;">
        <form class="layui-form" id="apply-form">
            <div class="layui-form-item">
                <label class="layui-form-label">手机</label>
                <div class="layui-input-block">
                    <input type="tel" name="phone" lay-verify="phone" placeholder="请输入申请手机号码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">E-mail</label>
                <div class="layui-input-block">
                    <input type="text" name="email" lay-verify="email" placeholder="请输入申请电子邮箱" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">QQ号码</label>
                <div class="layui-input-block">
                    <input type="number" name="qq" lay-verify="number" placeholder="请输入申请QQ号码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button id="submit-apply" type="button" class="layui-btn">提交申请</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function() {
        // 加载 layui
        layui.use('layer', function(){
            var layer = layui.layer;
        });
        // 检测关键字
        $("#submit-apply").click(function() {
            $.ajax({
                type: "POST",
                url:"<?=base_url('keywords/apply')?>",
                data: $('#apply-form').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if(0 == data.status) {
                        layer.alert(data.msg, {
                            icon: 1,
                            title: '申请成功',
                        });
                        $('#apply-form')[0].reset();
                        return true;
                    } else if(-1 == data.status) {
                        layer.confirm('请您先登录', {
                            icon: 0,
                            title: '未登录',
                            btn: ['确认']
                        });
                        return false;
                    } else {
                        layer.alert(data.msg, {
                            icon: 2,
                            title: '申请失败',
                        });
                        return false;
                    }
                }
            });
        });
    });
</script>