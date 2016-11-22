<div class="m-width clearfix">
    <div class="m-center clearfix">
        <div class="fl">
            <dl>
                <dt><a href="/user/detail">账号设置</a></dt>
                <dt class="hover"><a href="/user/change_password">修改密码</a></dt>
            </dl>
        </div>
        <div class="fr m-home">
            <form class="layui-form" action="" id="user-change-password">
                <div style="margin-top: 80px;">
                    <div class="layui-form-item">
                        <label class="layui-form-label">请输入您的密码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="old_password" lay-verify="title" autocomplete="off" placeholder="请输入您的密码" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">请输入您的新密码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="new_password" lay-verify="title" autocomplete="off" placeholder="请输入您的新密码" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">请再次输入您的新密码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="con_new_password" lay-verify="title" autocomplete="off" placeholder="请再次输入您的新密码" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn btn-change-password" lay-submit="">修改密码</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>