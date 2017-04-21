<form id="main-form" class="form-horizontal">
    <div class="form-group" style="margin-top:60px;">
        <div class="col-sm-offset-1 col-sm-3">
            <input type="file" name="banner-image" lay-title="请上传一张 Banner 图片"  class="layui-upload-file banner-image">
            <input type="hidden" name="banner" value="">
        </div>
        <div class="col-sm-3"><button type="button" id="add-banner" class="layui-btn">添加 Banner</button></div>
    </div>
</form>
<script type="application/javascript">
$(function() {
    layui.use(['layer', 'form', 'upload'], function () {
        layer = layui.layer;
        form = layui.form();
        upload = layui.upload();
        // 上传课程封面图
        layui.upload({
            elem: $('.banner-image')
            , url: '/upload/bannerImage'
            , ext: 'jpg|png|gif|jpeg'
            , success: function (response) {
                if (0 == response.status) {
                    layer.msg(response.msg, {
                        icon: 6,
                        time: 1000
                    });
                    // 赋值
                    $("input[name='banner']").val(response.data.banner);
                } else {
                    layer.open({
                        icon: 2,
                        content: response.msg
                    });
                }
            }
        });
    });
    // 提交表单
    $("#add-banner").click(function() {
        var banner = $("input[name='banner']").val();
        if (undefined == banner || null == banner || '' == banner) {
            layer.confirm('请先上传 Banner 图片', {
                icon: 2,
                title: '错误',
                btn: ['确认']
            });
            return false;
        }
        $.ajax({
            type: "POST",
            url:"<?=base_url('admin/banner/add')?>",
            data: {banner: banner},
            dataType: "JSON",
            success: function(data) {
                if(0 == data.status) {
                    layer.confirm('添加 Banner 成功，是否继续添加？', {
                        icon: 1,
                        title: '成功',
                        btn: ['继续添加', '返回列表']
                    }, function(){
                        window.location.reload();
                    }, function(){
                        window.location.href = "<?=base_url('/admin/banner')?>"
                    });
                } else {
                    layer.confirm(data.msg, {
                        icon: 2,
                        title: '错误',
                        btn: ['确认']
                    });
                }
            }
        });
    });
});
</script>