<link href="<?=base_url()?>resources/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="<?=base_url()?>resources/assets/libs/bootstrap/js/bootstrap.min.js"></script>
<div style="height:60px;"></div>
<div class="m-width">
    <div class="container mp30">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-list-alt"></span><b>咨詢列表</b>
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
                                                    echo '<td><img src="http://newtab.firefoxchina.cn/img/sitenav/logo.png" width="60" height="60" class="img-circle" /></td>';
                                                    echo "<td class='col-xs-2' style='text-align:center'><h4>{$tr['title']}</h4></td>";
                                                    echo "<td class='col-xs-4' style='text-align:center'><h5>{$tr['title']}</h5></td>";
                                                    echo "<td class='col-xs-5' style='text-align:center'>{$tr['title']}</td>";

                                                    echo "<td class='col-xs-1' style='text-align:center'><a class='btn btn-info btn-xs' href='" . base_url('index.php/articles/desc/'.$tr['id']) ."'>Read more...</a></td></tr>";
                                                }
                                            } else {
                                                echo '<tr><td style="text-align:center;font-size:16px;padding:30px 0px;" colspan="5">暂无数据</td></tr>';
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