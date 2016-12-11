<link href="<?=base_url()?>resources/assets/libs/bootstrap/css/bootstrap-combined.min.css" rel="stylesheet">
<div class="m-width ui-draggable">
    <span style="margin-left:35px;" class="layui-breadcrumb">
        <a href="<?=base_url()?>">首页</a>
        <a href="<?=base_url('articles/index')?>">最近咨询</a>
        <a><cite><?=$data['title']?></cite></a>
    </span>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span10" style="margin:20px 10px;width:100%;">
                <h3 class="text-center"><?=$data['title']?></h3>
                <p class="text-center">
                    作者：<?=$data['author']?>
                    时间：<?=date('Y年m月d日 H:i',strtotime($data['created_at']))?>
                    来源：<?=$data['source']?>
                </p>
            </div>
            <hr style="color: #ffffff;">
            <div class="span12" style="padding-right: 50px;">
                <?=$data['content']?>
            </div>
        </div>
    </div>
</div>