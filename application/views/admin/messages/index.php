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
                foreach ($tr as $column_name => $td) { echo "<td>{$td}</td>";}
                echo '<td><button class="btn btn-info btn-xs btn-details" data-id="' . $tr['id'] . '">查看详情</button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs btn-delete" data-id="' . $tr['id'] . '">删除</button></td></tr>';
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
                <h4 class="modal-title" id="myModalLabel">留言详情</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="user-form">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="login_name" class="col-sm-3 control-label">用户名</label>
                        <div class="col-sm-9">
                            <input type="text" disabled class="form-control" id="login_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex" class="col-sm-3 control-label">手机号</label>
                        <div class="col-sm-9">
                            <input type="text" disabled class="form-control" id="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="qq" class="col-sm-3 control-label">QQ</label>
                        <div class="col-sm-9">
                            <input type="text" disabled class="form-control" id="qq">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">邮箱地址</label>
                        <div class="col-sm-9">
                            <input type="text" disabled class="form-control" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-sm-3 control-label">留言内容</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="15" disabled id="content"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reg_time" class="col-sm-3 control-label">留言时间</label>
                        <div class="col-sm-9">
                            <input type="text" disabled class="form-control" id="leave_time">
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
<script>
    $(function() {
        layui.use('layer', function(){
            var layer = layui.layer;
        });

        $('.btn-details').click(function(){
            var id = $(this).data('id');
            var url = "<?=base_url("/admin/messages/detail/")?>" + id;
            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                success: function(response){
                    if(0 == response.status) {
                        $("#login_name").val(response.data.login_name);
                        $("#phone").val(response.data.phone);
                        $("#email").val(response.data.email);
                        $("#qq").val(response.data.qq);
                        $("#content").val(response.data.content);
                        $("#leave_time").val(response.data.leave_time);
                        $('#myModal').modal();
                    } else {
                        layer.alert(response.msg, {icon: 2});
                    }
                }
            });
        });

        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            var url = "<?=base_url("/admin/messages/delete/")?>" + id;
            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                success: function(response){
                    if(0 == response.status) {
                        layer.alert(response.msg, {icon: 1}, function() {
                            window.location.reload();
                        });
                    } else {
                        layer.alert(response.msg, {icon: 5});
                    }
                }
            });
        });
    });
</script>
