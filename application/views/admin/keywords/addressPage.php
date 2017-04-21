<div class="container-fluid">
    <div class="row" style="margin-bottom:20px;">
        <button id="add-keywords" class="layui-btn"><i class="layui-icon">&#xe608;</i>&nbsp;&nbsp;添加地址关键字</button>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead><tr>
            <?php foreach($table_header as $header):echo "<th>{$header}</th>";endforeach;?>
        </tr></thead>
        <tbody>
        <?php
        if(! empty($data)){
            foreach($data as $tr) {
                echo '<tr>';
                foreach ($tr as $column_name => $td) {echo "<td>{$td}</td>";}
                echo '<td><button class="btn btn-danger btn-xs but-delete" data-address="' . $tr['id'] . '">删除</button></td></tr>';
            }
        } else {
            echo '<tr><td style="text-align:center;font-size:16px;padding:30px 0px;" colspan="' . (count($table_header) + 1) .'">暂无数据</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?php if(! empty($page)){echo $page;}?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加地址关键字</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="address-form">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="province" class="col-sm-2 control-label">省份</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="province" id="province">
                                <option value="0">-- 请选择省份 --</option>
                                <?php if(! empty($provinces)):foreach($provinces as $province):?>
                                <option value="<?=$province['id']?>"><?=$province['name']?></option>
                                <?php endforeach;endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;" id="city-swap">
                        <label for="city" class="col-sm-2 control-label">市区</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="city" id="city">
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;" id="county-swap">
                        <label for="county" class="col-sm-2 control-label">县城</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="county" id="county">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">详细地址</label>
                        <div class="col-sm-10">
                            <textarea name="address" id="address" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="main-submit" type="button" class="btn btn-primary btn-lg btn-block">添加地址关键字</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        layui.use('layer', function(){
            var layer = layui.layer;
        });
        // 点击添加地址关键字
        $("#add-keywords").click(function() {
            $('#myModal').modal();
        });
        // 取消添加地址
        $('#myModal').on('hidden.bs.modal', function (e) {
            $("#address-form")[0].reset();
            $("#city-swap").hide();
            $("#county-swap").hide();
            $("#city").empty();
            $("#county").empty();
        });
        // 省份选择改变,获取市区信息
        $("#province").change(function() {
            var province = $(this).val();
            if(undefined == province || null == province || 0 > province) {
                layer.alert('省份选择有误', {icon: 2});
                return false;
            }
            $("#city-swap").hide();
            $("#city").empty();
            $("#county-swap").hide();
            $("#county").empty();
            if(0 == province) {
                return true;
            }
            // 获取市区地址信息
            $.ajax({
                type: "GET"
                ,url: "<?=base_url('dict/areaCity/')?>" + province
                ,dataType: "JSON"
                ,success: function(response) {
                    $("#city").empty();
                    $("#county").empty();
                    if(0 == response.status) {
                        var option = '<option value="0">-- 请选择市区 --</option>';
                        for(var i in response.data) {
                            option += '<option value="' + response.data[i]["id"] + '">' + response.data[i]["name"] + "</option>";
                        }
                        $("select[name='city']").append(option);
                        $("#city-swap").show();
                    } else {
                        layer.alert(response.msg, {icon: 2});
                    }
                }
            });
        });
        // 市区选择改变,获取县城信息
        $("#city").change(function() {
            var city = $(this).val();
            if(undefined == city || null == city || 0 > city) {
                layer.alert('市区选择有误', {icon: 2});
                return false;
            }
            $("#county-swap").hide();
            $("#county").empty();
            if(0 == city) {
                return true;
            }
            // 获取市区地址信息
            $.ajax({
                type: "GET"
                ,url: "<?=base_url('dict/areaCounty/')?>" + city
                ,dataType: "JSON"
                ,success: function(response) {
                    $("#county").empty();
                    if(0 == response.status) {
                        var option = '<option value="0">-- 请选择县城 --</option>';
                        for(var i in response.data) {
                            option += '<option value="' + response.data[i]["id"] + '">' + response.data[i]["name"] + "</option>";
                        }
                        $("select[name='county']").append(option);
                        $("#county-swap").show();
                    } else {
                        layer.alert(response.msg, {icon: 2});
                    }
                }
            });
        });
        // 添加地址关键字数据
        $("#main-submit").click(function() {
            $.ajax({
                type: "POST"
                , url: "<?=base_url('admin/keywords/addAddress')?>"
                , data: $("#address-form").serialize()
                , dataType: "JSON"
                , success: function (response) {
                    if (0 == response.status) {
                        window.location.reload();
                    } else {
                        layer.alert(response.msg, {icon: 2});
                    }
                }
            });
        });
        // 删除操作
        $('.but-delete').click(function(){
            var address = $(this).attr('data-address');
            if(undefined == address || null == address || 0 >= address) {
                layer.alert('非法操作!', {icon: 2});
                return false;
            }
            $.ajax({
                type: "POST",
                url: "<?=base_url('admin/keywords/deleteAddress')?>",
                data: {address: address},
                dataType: "JSON",
                success: function(response){
                    if(0 == response.status) {
                        window.location.reload();
                    } else {
                        layer.alert(response.msg, {icon: 2});
                    }
                }
            });
        });
    });
</script>
