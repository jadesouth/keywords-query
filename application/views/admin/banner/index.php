<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead><tr>
            <?php foreach($table_header as $header):echo "<th>{$header}</th>";endforeach;?>
        </tr></thead>
        <tbody>
        <?php
        if(! empty($data)){
            $status = ['<span class="label label-success">启用</span>', '<span class="label label-warning">禁用</span>'];
            foreach($data as $tr) {
                echo '<tr>';
                foreach ($tr as $column_name => $td) {
                    $td = 'img_path' == $column_name ? '<img src="' . base_url('resources/uploads/' . $td) . '" class="img-rounded" style="width:500px;height:100px;" />' : $td;
                    if ('status' == $column_name) {
                        if(0 == $td) {
                            $but_status = ' btn-warning banner-disable';
                            $but_text = '禁用';
                        } else {
                            $but_status = ' btn-success banner-enable';
                            $but_text = '启用';
                        }
                        $td = $status[$td];
                    }
                    echo "<td>{$td}</td>";
                }

                echo '<td><button class="btn btn-xs' . $but_status . '" data-banner="' . $tr['id'] . '">' . $but_text . '</button>';
                echo '&nbsp;&nbsp;<button class="btn btn-danger btn-xs but-delete" data-banner="' . $tr['id'] . '">删除</button></td></tr>';
            }
        } else {
            echo '<tr><td style="text-align:center;font-size:16px;padding:30px 0;" colspan="' . (count($table_header) + 1) .'">暂无数据</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?php if(! empty($page)){echo $page;}?>
<script>
    $(function() {
        layui.use('layer', function(){
            var layer = layui.layer;
        });
        // 删除 Banner
        $('.but-delete').click(function(){
            var banner = $(this).attr('data-banner');
            $.ajax({
                type: "POST",
                url: "<?=base_url('admin/banner/delete')?>",
                data: {id: banner},
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
        // 禁用 Banner
        $('.banner-disable').click(function(){
            var banner = $(this).attr('data-banner');
            $.ajax({
                type: "POST",
                url: "<?=base_url('admin/banner/disable')?>",
                data: {banner: banner},
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
        // 启用 Banner
        $('.banner-enable').click(function(){
            var banner = $(this).attr('data-banner');
            $.ajax({
                type: "POST",
                url: "<?=base_url('admin/banner/enable')?>",
                data: {banner: banner},
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
