<div id="forgot-box" class="forgot-box widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header red lighter bigger">
                <i class="ace-icon fa fa-key"></i>
                找回密码
            </h4>

            <div class="space-6"></div>
            <p>
                输入你的邮箱以找回密码
            </p>

            <form action="/managerlogin/findpass" method="post">
                <fieldset>
                    <label class="block clearfix">
						<span class="block input-icon input-icon-right">
							<input name="email" type="email" class="form-control"
                                   placeholder="邮箱"/>
							<i class="ace-icon fa fa-envelope"></i>
						</span>
                    </label>

                    <div class="clearfix">
                        <button type="submit" class="submit-btn width-35 pull-right btn btn-sm btn-danger">
                            <i class="ace-icon fa fa-lightbulb-o"></i>
                            <span class="bigger-110">发送</span>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- /.widget-main -->

        <div class="toolbar center">
            <a href="#" data-target="#login-box" class="back-to-login-link">
                返回登录
                <i class="ace-icon fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <!-- /.widget-body -->
</div>
<!-- /.forgot-box -->