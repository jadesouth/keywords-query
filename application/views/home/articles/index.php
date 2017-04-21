<link href="<?=base_url()?>resources/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="<?=base_url()?>resources/assets/libs/bootstrap/js/bootstrap.min.js"></script>
<div style="height:60px;"></div>
<div class="m-width">
    <div class="container mp30">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default" style="border-radius:0;">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;最新动态
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="demo1">
                                    <li class="news-item">
                                        <table cellpadding="">
                                            <?php
                                            if(! empty($data)){
                                                foreach($data as $tr) {
                                                    echo '<tr class="info">';
                                                    echo "<td class='col-xs-1'>{$tr['id']}</td>";
                                                    echo "<td class='col-xs-4'><h4><a href='" . base_url('articles/desc/'.$tr['id']) ."'>{$tr['title']}</a></h4></td>";
                                                    echo "<td class='col-xs-5'>{$tr['resume']}</td>";
                                                    echo "<td class='col-xs-2' style='text-align: right;'>" . date('Y-m-d', strtotime($tr['updated_at'])) . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo '<tr><td style="text-align:center;font-size:16px;padding:30px 0px;" colspan="4">暂无数据</td></tr>';
                                            }
                                            ?>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <?php if(! empty($page)){echo $page;}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>