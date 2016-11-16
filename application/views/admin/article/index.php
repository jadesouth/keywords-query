<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead><tr>
            <?php foreach($table_header as $header):echo "<th>{$header}</th>";endforeach;?>
        </tr></thead>
        <tbody>
        <?php
        if(! empty($data)){
            $status = ['<span class="label label-success">正常</span>', '<span class="label label-danger">隐藏</span>'];
            foreach($data as $tr) {
                echo '<tr>';
                foreach ($tr as $column_name => $td) {
                    $td = 'status' == $column_name ? $status[$td] : $td;
                    echo "<td>{$td}</td>";
                }
                echo '<td><a class="btn btn-info btn-xs" href="' . base_url() . "index.php/admin/article/edit/{$tr['id']}\">修改</a></td></tr>";
            }
        } else {
            echo '<tr><td style="text-align:center;font-size:16px;padding:30px 0px;" colspan="' . (count($table_header) + 1) .'">暂无数据</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?php if(! empty($page)){echo $page;}?>
