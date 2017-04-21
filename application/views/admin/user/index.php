<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead><tr>
            <?php foreach($table_header as $header):echo "<th>{$header}</th>";endforeach;?>
        </tr></thead>
        <tbody>
        <?php
        if(! empty($data)){
            $status = ['<span class="label label-success">有权限</span>', '<span class="label label-danger">无权限</span>'];
            foreach($data as $tr) {
                echo '<tr>';
                foreach ($tr as $column_name => $value) { $td = 'status' == $column_name ? $status[$value] : $value; echo "<td>{$td}</td>";}
                if('status' == $column_name && 0 == $value){ // 0.有权限 1.无权限
                    echo '<td><a class="btn btn-danger btn-xs user-disable" data-user_id="'. $tr['id'] . '">关闭权限</a>&nbsp;&nbsp;<a class="btn btn-default btn-xs user-info" data-user_id="'. $tr['id'] . '">查看详情</a></td></tr>';
                }else{
                    echo '<td><a class="btn btn-success btn-xs user-enable" data-user_id="'. $tr['id'] . '">开启权限</a>&nbsp;&nbsp;<a class="btn btn-default btn-xs user-info" data-user_id="'. $tr['id'] . '">查看详情</a></td></tr>';
                }
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
                <h4 class="modal-title" id="myModalLabel">用户详情</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="user-form">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="login_name" class="col-sm-4 control-label">登录名</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="login_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex" class="col-sm-4 control-label">性别</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="sex">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-4 control-label">手机号</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="real_name" class="col-sm-4 control-label">真实姓名</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="real_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">邮箱地址</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="idcard" class="col-sm-4 control-label">身份证</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="idcard">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="qq" class="col-sm-4 control-label">QQ</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="qq">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reg_time" class="col-sm-4 control-label">注册时间</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="reg_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reg_ip" class="col-sm-4 control-label">注册IP</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="reg_ip">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_login_time" class="col-sm-4 control-label">上次登录时间</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="last_login_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_login_ip" class="col-sm-4 control-label">上次登录IP</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="last_login_ip">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-4 control-label">权限状态</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" id="status">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    $(function() {
        layui.use('layer', function(){
            var layer = layui.layer;
        });
        // 关闭账号权限
        $(".user-disable").click(function() {
            var user_id = $(this).data("user_id");
            $.ajax({
                type: "POST",
                url: "<?=base_url("admin/user/ajax_disable")?>",
                data: {"user_id":user_id},
                dataType: "json",
                success: function(response){
                    if(0 == response.status) {
                        layer.alert(response.msg, {icon: 1}, function() {
                            window.location.reload();
                        });
                    } else {
                        layer.alert(response.msg, {icon: 2});
                    }
                }
            });
        });
        // 开通账号权限
        $(".user-enable").click(function() {
            var user_id = $(this).data("user_id");
            $.ajax({
                type: "POST",
                url: "<?=base_url("admin/user/ajax_enable")?>",
                data: {"user_id":user_id},
                dataType: "json",
                success: function(response){
                    if(0 == response.status) {
                        layer.alert(response.msg, {icon: 1}, function() {
                            window.location.reload();
                        });
                    } else {
                        layer.alert(response.msg, {icon: 2});
                    }
                }
            });
        });

        $(".user-info").click(function() {
            var user_id = $(this).data("user_id");
            $.ajax({
                type: "POST",
                url: "<?=base_url("admin/user/detail")?>",
                data: {"user_id":user_id},
                dataType: "json",
                success: function(response){
                    if(0 == response.status) {
                        $("#login_name").val(response.data.login_name);
                        $("#sex").val(response.data.sex);
                        $("#phone").val(response.data.phone);
                        $("#real_name").val(response.data.real_name);
                        $("#email").val(response.data.email);
                        $("#idcard").val(response.data.idcard);
                        $("#qq").val(response.data.qq);
                        $("#reg_time").val(response.data.reg_time);
                        $("#reg_ip").val(response.data.reg_ip);
                        $("#last_login_time").val(response.data.last_login_time);
                        $("#last_login_ip").val(response.data.last_login_ip);
                        $("#status").val(response.data.status);
                        $('#myModal').modal();
                    } else {
                        layer.alert(response.msg, {icon: 2});
                    }
                }
            });
        });
    });
</script>