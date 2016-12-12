<link href="<?=base_url()?>resources/assets/libs/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<!--提示弹出-->
<div id="main-warning" class="alert alert-danger alert-dismissible col-sm-11" style="display:none" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <p class="lead label label-danger">Warning!</p><br/><br/>
    <div></div>
</div>
<form id="main-form" class="form-horizontal">
    <input type="hidden" name="id" value="<?=$data['id']?>" placeholder="id">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">标题</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="title" id="title" value="<?=$data['title']?>" placeholder="标题">
        </div>
    </div>
    <div class="form-group">
        <label for="subtitle" class="col-sm-2 control-label">短标题</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="短标题" value="<?=$data['subtitle']?>">
        </div>
    </div>
    <div class="form-group">
        <label for="source" class="col-sm-2 control-label">来源</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="source" id="source" placeholder="来源" value="<?=$data['source']?>">
        </div>
    </div>
    <div class="form-group">
        <label for="author" class="col-sm-2 control-label">作者</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="author" id="author" placeholder="作者" value="<?=$data['author']?>">
        </div>
    </div>
    <div class="form-group">
        <label for="resume" class="col-sm-2 control-label">摘要</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="resume" id="resume" placeholder="摘要" value="<?=$data['resume']?>">
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-2 control-label">文章内容</label>
        <div class="col-sm-9">
            <textarea class="" rows="12" placeholder="文章内容" name="content" id="content" style=""><?=$data['content']?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-sm-2 control-label">是否开放</label>
        <div class="col-sm-9">
            <label class="radio-inline">
                <input type="radio" name="status" id="status" value="0" <?=0 == $data['status'] ? 'checked' : ''?>> 开放
            </label>
            <label class="radio-inline">
                <input type="radio" name="status" id="status" value="1" <?=1 == $data['status'] ? 'checked' : ''?>> 隐藏
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-9">
            <button id="main-submit" type="button" class="btn btn-primary btn-lg btn-block">提交修改</button>
        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">成功</h4>
            </div>
            <div id="success-msg" class="modal-body text-success">操作成功</div>
            <div class="modal-footer">
                <a href="<?=base_url('admin/articles/index')?>" type="button" class="btn btn-default">返回列表</a>
                <a href="<?=base_url('admin/articles/edit/'.$data['id'])?>" type="button" class="btn btn-primary">继续修改</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8" src="<?=base_url()?>resources/assets/libs/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=base_url()?>resources/assets/libs/bootstrap/js/bootstrap-datetimepicker.fr.js"></script>
<!--<script type="application/javascript">-->
<!--$('#pub_date').datetimepicker();-->
<!--</script>-->
<script type="text/javascript" charset="utf-8" src="<?=base_url()?>resources/assets/libs/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=base_url()?>resources/assets/libs/ueditor/ueditor.all.min.js"> </script>
<script type="application/javascript">
    $('#main-submit').click(function(){
        $.ajax({
            type: "POST",
            url: "<?=base_url('admin/articles/edit')?>",
            data: $("#main-form").serialize(),
            dataType: "json",
            success: function(response){
                if(0 == response.status) {
                    if("" !== response.msg) {
                        $("#success-msg").html(response.msg);
                    }
                    $('#main-modal').modal({backdrop: 'static', keyboard: false});
                } else {
                    $("#main-warning").slideDown(200);
                    $("#main-warning > div").html(response.msg);
                }
            }
        });
    });
    var ue = UE.getEditor('content').setHeight(300);

</script>