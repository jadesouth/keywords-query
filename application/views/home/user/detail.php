<div class="m-width clearfix">
    <div class="m-center clearfix">
        <div class="fl">
            <dl>
                <dt class="hover"><a href="/user/detail">账号设置</a></dt>
                <dt><a href="/user/change_password">修改密码</a></dt>
            </dl>
        </div>
        <div class="fr m-home">
            <form class="layui-form" action="" id="user-detail">
                <div style="margin-top: 80px;">
                    <div class="layui-form-item">
                        <label class="layui-form-label">真实姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="real_name" lay-verify="title" autocomplete="off" placeholder="请输入您的真实姓名" class="layui-input" value="<?=$real_name?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">性别</label>
                        <div class="layui-input-inline">
                            <input type="radio" name="sex" value="1" title="男" <?php if(1 == $sex){echo 'checked';}?>>
                            <input type="radio" name="sex" value="2" title="女" <?php if(2 == $sex){echo 'checked';}?>>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">手机</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="phone" lay-verify="phone" autocomplete="off" class="layui-input" placeholder="请输入您的手机" value="<?=$phone?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">邮箱</label>
                        <div class="layui-input-inline">
                            <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input" placeholder="请输入您的邮箱" value="<?=$email?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">QQ</label>
                        <div class="layui-input-inline">
                            <input type="text" name="qq" lay-verify="number" autocomplete="off" class="layui-input" placeholder="请输入您的QQ" value="<?=$qq?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">身份证</label>
                        <div class="layui-input-inline">
                            <input type="text" name="idcard" lay-verify="identity" autocomplete="off" class="layui-input" placeholder="请输入您的身份证号码" value="<?=$idcard?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <a class="layui-btn btn-edit-user">保存</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>