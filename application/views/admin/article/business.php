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
        <label for="resume" class="col-sm-2 control-label">首页摘要</label>
        <div class="col-sm-9">
            <textarea class="form-control" rows="3" name="resume" id="resume"><?=$data['resume']?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-2 control-label">介绍内容</label>
        <div class="col-sm-9">
            <textarea class="" rows="12" placeholder="文章内容" name="content" id="content" style=""><?=$data['content']?></textarea>
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
                <a href="<?=base_url('admin/article/'.$method_name)?>" type="button" class="btn btn-primary">继续修改</a>
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
            url: "<?=base_url('admin/article/'.$method_name)?>",
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