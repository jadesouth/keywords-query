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
                    foreach ($tr as $td) {echo "<td>{$td}</td>";}
                    echo '<td><a class="btn btn-info btn-xs" href="' . base_url() . "admin/{$controller}/edit/{$tr['id']}\">修改</a>&nbsp;&nbsp;&nbsp;";
                    echo '<a class="btn btn-danger btn-xs" href="' . base_url() . "admin/{$controller}/delete/{$tr['id']}\">删除</a></td></tr>";
                }
            } else {
                echo '<tr><td style="text-align:center;font-size:16px;padding:30px 0px;" colspan="' . (count($table_header) + 1) .'">暂无数据</td></tr>';
            }
        ?>
        </tbody>
    </table>
</div>
<?php if(! empty($page)){echo $page;}?>
