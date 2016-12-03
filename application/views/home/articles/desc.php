<link href="<?=base_url()?>resources/assets/libs/bootstrap/css/bootstrap-combined.min.css" rel="stylesheet">
<div class="m-width ui-draggable">
    <div class="container-fluid" style=" background-color: #c7dec6;border: 1px solid #000;border-top-left-radius: 10px;border-top-right-radius: 10px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
        <div class="row-fluid">
            <div class="span10" style="padding: 20px;">
                <h3 class="text-info text-left">
                    <?=$data['title']?>
                </h3>
                <p>
                    作者：<?=$data['author']?>
                </p>
                <p>
                    时间：<?=date('Y年m月d日 H:i',strtotime($data['created_at']))?>
                </p>
                <p>
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