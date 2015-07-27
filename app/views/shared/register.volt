<div id="signup-box" class="signup-box widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header green lighter bigger">
                <i class="ace-icon fa fa-users blue"></i>
                新用户注册
            </h4>

            <div class="space-2"></div>

            <form id="register-form" action="/managerlogin/signup" method="post">
                <fieldset>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input name="username" type="text" onchange="checkName(this)" pattern="^[0-9a-zA-Z]{4,12}$" title="用户名应为4-12个字母、数字" class="form-control" placeholder="用户名"
                                   required="required"/>
                            <i class="ace-icon fa fa-user"></i>
                        </span>
                    </label>

                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input name="email" type="email" class="form-control" placeholder="邮箱" required="required"/>
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </label>

                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input name="name" type="text" class="form-control" pattern="^[\u4e00-\u9fa5]{2,9}$" title="姓名应为2-9个字符" placeholder="真实姓名" required="required"/>
                            <i class="ace-icon fa fa-male"></i>
                        </span>
                    </label>


                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input name="phone" type="tel" pattern="^[0-9-+]{8,16}$" title="请输入8-16为手机号码" class="form-control" placeholder="联系方式" required="required"/>
                            <i class="ace-icon fa fa-phone"></i>
                        </span>
                    </label>

                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input name="id_num" type="text" class="form-control" placeholder="身份证号" title="请输入15或18位身份证号码" pattern="^([0-9]{17}[0-9X]{1})|([0-9]{15})$"
                                   required="required"/>
                            <i class="ace-icon fa fa-credit-card"></i>
                        </span>
                    </label>


                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input name="password" type="password" pattern="^[\w]{6,16}$" title="请输入6-16为密码" class="form-control regpwd" placeholder="密码"
                                   required="required"/>
                            <i class="ace-icon fa fa-lock"></i>
                        </span>
                    </label>

                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input name="re_password" type="password" onchange="checkpwd()" class="form-control" placeholder="重复密码"
                                   required="required"/>
                            <i class="ace-icon fa fa-retweet"></i>
                        </span>
                    </label>

                    {#
                    <label class="block">#} {#
                        <input type="checkbox" class="ace" />#} {#
                        <span class="lbl">#} {#我已阅读并同意#} {#
                            <a href="#">用户使用协议</a>#} {#
                        </span>#} {#
                    </label>#}


                    <div class="clearfix">
                        <button type="reset" class="width-30 pull-left btn btn-sm">
                            <i class="ace-icon fa fa-refresh"></i>
                            <span class="bigger-110">重置</span>
                        </button>

                        <button id="register-btn" type="button"
                                class="submit-btn width-65 pull-right btn btn-sm btn-success">
                            <span class="bigger-110">注册</span>

                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                        </button>
                        <input type="submit" hidden="hidden" id="register">
                    </div>
                </fieldset>
            </form>
        </div>

        <div class="toolbar center">
            <a href="#" data-target="#login-box" class="back-to-login-link">
                <i class="ace-icon fa fa-arrow-left"></i>
                返回登录
            </a>
        </div>
    </div>
    <!-- /.widget-body -->
</div>
