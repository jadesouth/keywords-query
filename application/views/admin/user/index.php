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
                foreach ($tr as $column_name => $td) { $td = 'status' == $column_name ? $status[$td] : $td; echo "<td>{$td}</td>";}
                if('status' == $column_name && 0 == $td){
                    echo '<td><a class="btn btn-info btn-xs user-op"'.">关闭权限</a></td></tr>";
                }else{
                    echo '<td><a class="btn btn-info btn-xs user-op"'.">开通权限</a></td></tr>";
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
<script type="javascript">
    var a =$("#user-op").val();
    if('关闭权限' == a){
        $.ajax({
            cache: true,
            type: "POST",
            url:'',
            data:{},
            async: false,
            error: function(request) {
                alert("Connection error");
            },
            success: function(data) {
                $("#commonLayout_appcreshi").parent().html(data);
            }
        });
    }
    function changeUserStatus(user_status){
        if(0 == user_status){
            var url = 'admin/user/ajax_enable';
        }else{
            var url = 'admin/user/ajax_disable';
        }
        $.ajax({
            url:url,
            data:{},
            type:"post",
            success:function(response){ //ajax返回的数据
                console.log(response);
            },
            error:function (response) {
                console.log(response);
            }
        });
    }
</script>