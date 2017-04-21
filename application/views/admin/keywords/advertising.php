<div class="container-fluid">
    <div class="row" style="margin-top:30px;margin-bottom:10px;">
        <div class="layui-form-item">
            <div class="layui-inline">
                <div class="layui-input-inline" style="width:200px;">
                    <input type="text" name="keywords" placeholder="请输入关键字" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-input-inline" style="width: 100px;">
                    <button id="add-keywords" class="layui-btn"><i class="layui-icon">&#xe608;</i>&nbsp;&nbsp;添加广告法关键字</button>
                </div>
            </div>
            <div class="layui-inline" style="margin-left:200px;">
                <div class="layui-input-inline" style="width:200px;">
                    <input type="text" name="search-keywords" placeholder="请输入查询关键字" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-input-inline" style="width: 100px;">
                    <button id="search-keywords" class="layui-btn"><i class="layui-icon">&#xe615;</i>&nbsp;&nbsp;查询广告法关键字</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default" style="border-radius:0;">
            <div class="panel-heading" style="border-radius:0;">
                <h3 class="panel-title">全部广告法关键字</h3>
            </div>
            <div id="all-keywords" class="panel-body" style="border-radius:0;">
                <?php if(! empty($keywords)):foreach($keywords as $keyword):?>
                <button data-id="<?=$keyword['id']?>" style="margin:0 6px 6px 0;" class="layui-btn layui-btn-small layui-btn-normal"><?=$keyword['word']?>&nbsp;&nbsp;<i class="layui-icon">&#x1006;</i></button>
                <?php endforeach;else:echo'<span id="no-keywords">暂无关键字</span>';endif;?>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    // 加载 layui
    layui.use('layer', function(){
        var layer = layui.layer;
    });
    // 搜索关键字
    $("#search-keywords").click(function() {
        var keyword = $("input[name='search-keywords']").val();
        if('' == keyword || null == keyword || undefined == keyword) {
            layer.open({
                icon: 2,
                content: '请输入搜索关键字'
            });
            return;
        }
        $.ajax({
            type: "POST",
            url:"<?=base_url('admin/keywords/search')?>",
            data: {type:1, word:keyword},
            dataType: "JSON",
            success: function(data) {
                if(0 == data.status) {
                    layer.open({
                        icon: data.data.status,
                        content: data.msg
                    });
                    return true;
                } else {
                    layer.open({
                        icon: 2,
                        content: data.msg
                    });
                    return false;
                }
            }
        });
    });
    // 添加关键字
    $("#add-keywords").click(function() {
        var keyword = $("input[name='keywords']").val();
        if('' == keyword || null == keyword || undefined == keyword) {
            layer.open({
                icon: 2,
                content: '请输入关键字'
            });
            return;
        }
        $.ajax({
            type: "POST",
            url:"<?=base_url('admin/keywords/add')?>",
            data: {type:1, word:keyword},
            dataType: "JSON",
            success: function(data) {
                if(0 == data.status) {
                    $("#no-keywords").remove();
                    var keyword = '<button data-id="' + data.data.id
                        + '" style="margin:0 6px 6px 0;" class="delete-keyword layui-btn layui-btn-small layui-btn">'
                        + data.data.word + '&nbsp;&nbsp;<i class="layui-icon">&#x1006;</i></button>';
                    $("#all-keywords").prepend(keyword);
                    $("input[name='keywords']").val("");
                    return true;
                } else {
                    layer.open({
                        icon: 2,
                        content: data.msg
                    });
                    return false;
                }
            }
        });
    });
    // 删除关键字
    var all_keyword = $("#all-keywords");
    all_keyword.delegate("button", "click", function(){
        var butE = $(this);
        var keyword = butE.attr("data-id");
        if('' == keyword || null == keyword || undefined == keyword || 0 >= keyword) {
            layer.open({
                icon: 2,
                content: "删除操作不合法,请刷新重试!"
            });
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?=base_url('admin/keywords/delete')?>",
            data: {id: keyword},
            dataType: "JSON",
            success: function(data) {
                if(0 == data.status) {
                    butE.remove();
                    if(0 >= all_keyword.children().length) {
                        all_keyword.prepend('<span id="no-keywords">暂无关键字</span>');
                    }
                    return true;
                } else {
                    layer.open({
                        icon: 2,
                        content: data.msg
                    });
                    return false;
                }
            }
        });
    });
})
</script>
