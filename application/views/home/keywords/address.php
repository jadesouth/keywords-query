<div class="m-width">
    <span style="margin-left:35px;" class="layui-breadcrumb">
        <a href="<?=base_url()?>">首页</a>
        <a><cite><?=$title?></cite></a>
    </span>
    <div style="margin-top:20px;">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">行内选择框</label>
                <div class="layui-input-inline">
                    <select name="province" lay-verify="required" lay-filter="province">
                        <option value="">请选择省</option>
                        <?php if(! empty($provinces)):foreach($provinces as $province):?>
                            <option value="<?=$province['id']?>"><?=$province['name']?></option>
                        <?php endforeach;endif;?>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="city" lay-verify="required" lay-filter="city">
                        <option value="">请选择市</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="county" lay-verify="required">
                        <option value="">请选择县/区</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">旺旺账号</label>
                <div class="layui-input-block">
                    <input type="text" name="wangwang" autocomplete="off" placeholder="请输入旺旺账号" class="layui-input" />
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">电话号码</label>
                <div class="layui-input-block">
                    <input type="text" name="phone" autocomplete="off" placeholder="请输入电话号码" class="layui-input" />
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">详细地址</label>
                <div class="layui-input-block">
                    <textarea lay-verify="required" name="address" rows="3" placeholder="请输入或粘贴详细地址文本进入这里，然后点击【立即校验】按钮，此时文本出现红色的关键字提示。" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button id="check-ok" class="layui-btn layui-btn-normal layui-btn-big" lay-submit lay-filter="*">立即校验</button>
                    <button type="reset" class="layui-btn layui-btn-primary layui-btn-big">重置</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function() {
        // 加载 layui
        layui.use(['layer','form'], function(){
            var layer = layui.layer;
            var form = layui.form();
            form.on('submit(*)', function(data){
                $.ajax({
                    type: "POST",
                    url:"<?=base_url('keywords/address')?>",
                    data: data.field,
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
                        } else if(-1 == data.status) {
                            layer.confirm('请您先登录', {
                                icon: 0,
                                title: '未登录',
                                btn: ['确认']
                            });
                        } else if(2 == data.status) {
                            layer.confirm('您暂无查询权限，是否申请？', {
                                icon: 3,
                                title: '无查询权限',
                                btn: ['申请权限', '否']
                            }, function(){
                                window.location.href = "<?=base_url('/keywords/apply')?>"
                            });
                        } else {
                            layer.confirm(data.msg, {
                                icon: 3,
                                title: '错误',
                                btn: ['确认']
                            });
                        }
                    }
                });

                return false;
            });
            form.on('select(province)', function(data){
                // 获取市区地址信息
                $.ajax({
                    type: "GET"
                    ,url: "<?=base_url('dict/areaCity/')?>" + data.value
                    ,dataType: "JSON"
                    ,success: function(response) {
                        if(0 == response.status) {
                            var option = '<option value="">请选择市</option>';
                            for(var i in response.data) {
                                option += '<option value="' + response.data[i]["id"] + '">' + response.data[i]["name"] + "</option>";
                            }
                            $("select[name='city']").empty().append(option);
                            $("select[name='county']").empty().append('<option value="">请选择县/区</option>');
                            form.render('select');
                        } else {
                            layer.alert(response.msg, {icon: 2});
                        }
                    }
                });
            });
            form.on('select(city)', function(data){
                // 获取市区地址信息
                $.ajax({
                    type: "GET"
                    ,url: "<?=base_url('dict/areaCounty/')?>" + data.value
                    ,dataType: "JSON"
                    ,success: function(response) {
                        $("#county").empty();
                        if(0 == response.status) {
                            var option = '<option value="">请选择县/区</option>';
                            for(var i in response.data) {
                                option += '<option value="' + response.data[i]["id"] + '">' + response.data[i]["name"] + "</option>";
                            }
                            $("select[name='county']").empty().append(option);
                            form.render('select');
                        } else {
                            layer.alert(response.msg, {icon: 2});
                        }
                    }
                });
            });
        });
    });
</script>