
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <!--<i class="ace-icon fa fa-leaf green"></i>-->
                            <span class="white" id="id-text2">大学生心理健康测评系统</span>
                        </h1>
                        <h4 class="light-blue" id="id-company-text" style="margin-top:20px;">&copy; 全国高等学校心理健康教育数据分析中心</h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="ace-icon fa fa-coffee green"></i>
                                        欢迎登录{% if type=="student" %}{{ school_name }}{% endif %}大学生心理健康测评系统
                                    </h4>

                                    <div class="space-6"></div>

                                    <form id="login-form" action="{{ target }}" method="post">
                                        <fieldset>
                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right
														 <?php if ($error==" username") echo "has-error"; ?>
                                                ">
                                                <input name="username" type="text" class="form-control"
                                                       placeholder="用户名"/>
                                                <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right <?php if ($error=='password') echo 'has-error'; ?>">
															<input id="login-password" name="password" type="password" class="form-control"
                                                                   placeholder="密码"/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
                                            </label>

                                            {% if !error %}
                                            <div class="space"></div>
                                            {% endif %}

                                            {% if error=="username" %}
                                                <p class="text-danger">
                                                    错误：您输入的用户名不存在
                                                </p>
                                            {% endif %}

                                            {% if error=="password" %}
                                                <p class="text-danger">
                                                    错误：您输入的密码有误
                                                </p>
                                            {% endif %}

                                            {% if error=="stuusername" %}
                                                <p class="text-danger">
                                                    错误：用户名或学校不存在
                                                </p>
                                            {% endif %}

                                            <div class="clearfix">
                                                <label class="inline">
                                                    <input type="checkbox" class="ace"/>
                                                    <span class="lbl"> 记住密码 </span>
                                                </label>

                                                <button id="login" type="button"
                                                        class="submit-btn width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">登录</span>
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>


                                </div>
                                <!-- /.widget-main -->
                                {% if type!="student" %}
                                    <div class="toolbar clearfix">
                                        <div>
                                            <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                忘记密码？
                                            </a>
                                        </div>

                                        <div>
                                            <a href="#" data-target="#signup-box" class="user-signup-link">
                                                点击注册
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                {% endif %}
                            </div>
                            <!-- /.widget-body -->
                        </div>

                        <!-- /.login-box -->
                        {% if type!="student" %}
                            {{ partial("shared/forget") }}
                        {% endif %}

                        <!-- /.forget-box -->
                        {% if type!="student" %}
                            {{ partial("shared/register") }}
                        {% endif %}
                        <!-- /.signup-box -->

                    </div>
                    <!-- /.position-relative -->


                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.main-content -->
</div>
<!-- /.main-container -->


<!-- inline scripts related to this page -->
<script type="text/javascript">
    function checkpwd() {
        var pwd1 = $(".regpwd").val();
        var pwd2 = $("input[name=re_password]").val();
        if (pwd1 != pwd2) {
            $("input[name=re_password]").get(0).setCustomValidity("两次输入的密码不一致噢，亲");
        } else {
            $("input[name=re_password]").get(0).setCustomValidity("");
        }
    }
    function checkName(obj) {
        if (obj.value == "")
            return;
        $.ajax('/managerlogin/checkuser', {
            data: {username: obj.value},
            type: "post",
            success: function (data) {
                if (data == "1") {
                    obj.setCustomValidity("用户名已存在");
                } else {
                    obj.setCustomValidity("");
                }
            },
            error: function () {

            }
        });
    }
    jQuery(function ($) {

        $(document).on('click', '.toolbar a[data-target]', function (e) {
            e.preventDefault();
            var target = $(this).data('target');
            $('.widget-box.visible').removeClass('visible');//hide others
            $(target).addClass('visible');//show target
        });

        $("#login").focus();

        $("#login").click(function () {
            $("#login-form").submit();
        });

        $("#register-btn").click(function () {
            $("#register").click();
        });


        // $("#register-form").submit(function (event) {
        //     //ajax等一系列操作
        //     event.preventDefault();
        // });

        $(document).keydown(function (event) {
            if (event.keyCode == 13) {
                if ($('#login-password').val() != "")
                    $(".position-relative .visible .submit-btn").click();
            }
        });

    });
</script>