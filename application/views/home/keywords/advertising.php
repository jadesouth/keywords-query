<div class="m-width">
    <span style="margin-left:35px;" class="layui-breadcrumb">
        <a href="<?=base_url()?>">首页</a>
        <a><cite><?=$title?></cite></a>
    </span>
    <div style="margin-top:20px;">
        <form class="layui-form">
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">请填写文本</label>
                <div class="layui-input-block">
                    <textarea name="keywords" rows="10" placeholder="请输入或粘贴广告文本进入这里，然后点击【立即校验】按钮，此时文本出现红色的关键字提示。" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" id="check-ok" class="layui-btn layui-btn-normal layui-btn-big">立即校验</button>
                    <button type="reset" class="layui-btn layui-btn-primary layui-btn-big">重置</button>
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
    $("#check-ok").click(function() {
        var keyword = $("textarea[name='keywords']").val();
        if('' == keyword || null == keyword || undefined == keyword) {
            layer.open({
                icon: 2,
                content: "请输入检测内容"
            });
            return false;
        }
        $.ajax({
            type: "POST",
            url:"<?=base_url('keywords/advertising')?>",
            data: {contents:keyword},
            dataType: "JSON",
            success: function(data) {
                if(0 == data.status) {
                    layer.open({
                        type: 1,
                        title: '校验结果',
                        skin: 'layui-layer-rim', //加上边框
                        area: ['420px', '240px'], //宽高
                        content: data.data.contents
                    });
                    return true;
                } else {
                    layer.confirm('您暂无查询权限，是否申请？', {
                        icon: 3,
                        title: '无查询权限',
                        btn: ['申请权限', '否']
                    }, function(){
                        window.location.href = "<?=base_url('/keywords/apply')?>"
                    });
                    return false;
                }
            }
        });
    });
});
</script>
