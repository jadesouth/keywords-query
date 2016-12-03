<link href="<?=base_url()?>resources/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="<?=base_url()?>resources/assets/libs/bootstrap/js/bootstrap.min.js"></script>

<div class="m-width">
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <tbody>
        <?php
        if(! empty($data)){
            foreach($data as $tr) {
                echo '<tr class="info">';
                foreach ($tr as $column_name => $td) {
                    if( 'id' != $column_name){
                        echo "<td>{$td}</td>";
                    }
                }
                echo '<td><a class="btn btn-info btn-xs" href="' . base_url() . "index.php/articles/desc/{$tr['id']}\">详情</a></td></tr>";
            }
        } else {
            echo '<tr><td style="text-align:center;font-size:16px;padding:30px 0px;" colspan="' . (count($table_header) + 1) .'">暂无数据</td></tr>';
        }
        ?>
        </tbody>
    </table>
    <?php if(! empty($page)){echo $page;}?>
</div>
</div>