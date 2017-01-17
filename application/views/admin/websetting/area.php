<div class="container-fluid">
    <div class="row" style="margin-top:30px;margin-bottom:10px;">
        <form class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <div class="layui-input-inline" style="width:200px;">
                        <input type="text" name="province" placeholder="一级区域名称" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <button type="button" id="add-province" class="layui-btn"><i class="layui-icon">&#xe608;</i>&nbsp;&nbsp;添加一级区域</button>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <div class="layui-input-inline" style="width:200px;">
                        <select name="province_one">
                            <option value="">请选择省</option>
                            <?php if(! empty($provinces)):foreach($provinces as $province):?>
                            <option value="<?=$province['id']?>"><?=$province['name']?></option>
                            <?php endforeach;endif;?>
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:200px;">
                        <input type="text" name="city" placeholder="二级区域名称" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width:100px;">
                        <button id="add-city" type="button" class="layui-btn"><i class="layui-icon">&#xe608;</i>&nbsp;&nbsp;添加二级区域</button>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <div class="layui-input-inline" style="width:200px;">
                        <select name="province_two" lay-filter="province-two">
                            <option value="">请选择省</option>
                            <?php if(! empty($provinces)):foreach($provinces as $province):?>
                            <option value="<?=$province['id']?>"><?=$province['name']?></option>
                            <?php endforeach;endif;?>
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:200px;">
                        <select name="city_two" lay-verify="required" lay-filter="city-two">
                            <option value="">请选择市</option>
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:200px;">
                        <input type="text" name="county" placeholder="三级区域名称" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width:100px;">
                        <button type="button" id="add-county" class="layui-btn"><i class="layui-icon">&#xe608;</i>&nbsp;&nbsp;添加三级区域</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function() {
        // 加载 layui
        layui.use(['layer', 'form'], function(){
            var layer = layui.layer,
                form = layui.form();
            form.on('select(province-two)', function(data){
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
                            $("select[name='city_two']").empty().append(option);
                            form.render('select');
                        } else {
                            layer.alert(response.msg, {icon: 2});
                        }
                    }
                });
            });
        });
        // 添加一级区域
        $("#add-province").click(function() {
            var province = $("input[name='province']").val();
            if('' == province || null == province || undefined == province) {
                layer.open({
                    icon: 2,
                    content: '请输入一级区域名称'
                });
                return false;
            }
            $.ajax({
                type: "POST",
                url: "<?=base_url('admin/websetting/addProvince')?>",
                data: {province: province},
                dataType: "JSON",
                success: function(data) {
                    if(0 == data.status) {
                        layer.open({
                            icon: 1
                            ,content: data.msg
                            ,yes: function(index, layero){
                                window.location.reload();
                            }
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
        // 添加二级区域
        $("#add-city").click(function() {
            var province = $("select[name='province_one']").val();
            if('' == province || null == province || undefined == province || 0 >= province) {
                layer.open({
                    icon: 2,
                    content: '请选择一级区域'
                });
                return false;
            }
            var city = $("input[name='city']").val();
            if('' == city || null == city || undefined == city) {
                layer.open({
                    icon: 2,
                    content: '请输入二级区域名称'
                });
                return false;
            }
            $.ajax({
                type: "POST",
                url: "<?=base_url('admin/websetting/addCity')?>",
                data: {province: province, city: city},
                dataType: "JSON",
                success: function(data) {
                    if(0 == data.status) {
                        layer.open({
                            icon: 1
                            ,content: data.msg
                            ,yes: function(index, layero){
                                window.location.reload();
                            }
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
        // 添加三级区域
        $("#add-county").click(function() {
            var province = $("select[name='province_two']").val();
            var city = $("select[name='city_two']").val();
            if('' == province || null == province || undefined == province || 0 >= province) {
                layer.open({
                    icon: 2,
                    content: '请选择一级区域'
                });
                return false;
            }
            if('' == city || null == city || undefined == city || 0 >= city) {
                layer.open({
                    icon: 2,
                    content: '请选择二级区域'
                });
                return false;
            }
            var county = $("input[name='county']").val();
            if('' == county || null == county || undefined == county) {
                layer.open({
                    icon: 2,
                    content: '请输入三级区域名称'
                });
                return false;
            }
            $.ajax({
                type: "POST",
                url: "<?=base_url('admin/websetting/addCounty')?>",
                data: {province: province, city: city, county: county},
                dataType: "JSON",
                success: function(data) {
                    if(0 == data.status) {
                        layer.open({
                            icon: 1
                            ,content: data.msg
                            ,yes: function(index, layero){
                                window.location.reload();
                            }
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
    })
</script>
