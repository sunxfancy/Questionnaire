{#
    本页面用于学生用户答题前的显示的身份信息确认页面
#}

<link rel="stylesheet" href="/public/css/buttons.css">
<link rel="stylesheet" href="/public/css/ace.min.css">

<style>
    {#desktop#}
    @media screen and (min-width: 768px) {
        .title {
            font-size: 26px;
            color: #333;
            font-family: "华文新魏";
            letter-spacing: 20px;
        }
    }

    @media screen and (max-width: 768px) {
        .title {
            font-size: 20px;
            color: #333;
            font-family: "华文新魏";
        }

        /*body {*/
        /*background-image: url("/css/images/meteorshower2.jpg");*/
        /*}*/
        /*#widget-box {*/
        /*border: 7px solid #394557;*/
        /*}*/
    }

    body {
        background-color: rgb(181, 219, 211);

    }

    #widget-box .widget-body {
        background-color: rgb(238, 247, 251);
    }

    .alert-div {
        text-align: center;
    }

    #start {
        position: fixed;
        bottom: 20px;
        right: 20px;
        cursor: pointer;
    }


</style>

<script>
    $(function () {
//        var result = window.matchMedia("(min-width: 480px)");
//        if(result.matches){
//            $("input[name=mobile]").val(2);
//        }else{
//            $("input[name=mobile]").val(1);
//        }
        $.cookie("id", "{{ stu_id }}", {expires: 1});
        $(".start-btn").click(function () {
            $("#start-form").submit();
        });
 
        $('#birthday').daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            format: 'YYYY-MM-DD'
        });
    });

</script>

<div class="welcome-page">
    <div class="title page-header">
        全国大学生心理健康测评系统
    </div>
    {#<div class="title col-sm-5 col-sm-offset-3">#}
    {#欢迎来到大学生心理调查问卷系统！#}
    {#</div>#}

    <div class="col-sm-6 col-sm-offset-4  col-md-5 col-lg-4">
        {% if isanswered==true %}
            <div class="alert-div alert alert-danger" role="alert">您已完成答题</div>
        {% elseif isintime==false %}
            <div class="alert-div alert alert-danger" role="alert">答题时间没有到，请耐心等候</div>
        {% elseif iscompleted==false %}
            <div class="alert-div alert alert-danger" role="alert">您的信息尚不完善，请完善信息之后开始答题！</div>
        {% else %}
            <div class="alert-div alert alert-success" role="alert">信息已保存，请确认</div>
        {% endif %}
    </div>

    {#性别 年龄 学校 院系 专业 年级 学号 姓名#}
    <div class=" col-sm-6 col-sm-offset-4 col-md-5 col-lg-4">
        <div id="widget-box" class="widget-box">
            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal " role="form" method="post" action="/student/saveinfo">
                        <div class="form-group">
                            <label for="school" class="col-sm-3 control-label">学校</label>

                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control" id="school" value="{{ school }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="college" class="col-sm-3 control-label">院系</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="college" name="college"
                                      required value="{{ college }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="major" class="col-sm-3 control-label">专业</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="major" name="major" required value="{{ major }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="col-sm-3 control-label">年级</label>

                            <div class="col-sm-8">
                                <input type="text" required pattern="^[0-9]+$" class="form-control" id="grade" name="grade"
                                       value="{{ grade }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="col-sm-3 control-label">班级</label>

                            <div class="col-sm-8">
                                <input type="text" required class="form-control" id="class" name="class"
                                       value="{{ class }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stu_no" class="col-sm-3 control-label">学号</label>

                            <div class="col-sm-8">
                                <input type="text" required class="form-control" id="stu_no" name="stu_no" value="{{ stu_no }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">姓名</label>

                            <div class="col-sm-8">
                                <input type="text" required class="form-control" id="name" name="name" value="{{ name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">性别</label>

                            <div class="radio col-sm-3">
                                <label>
                                    <input type="radio" name="sex" value="1" 
                                            {% if sex==1 %}
                                    checked
                                            {% endif %}>
                                    男
                                </label>
                            </div>
                            <div class="radio col-sm-3">
                                <label>
                                    <input type="radio" name="sex" value="0" 
                                            {% if sex==0 %}
                                    checked
                                            {% endif %}>
                                    女
                                </label>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="age" class="col-sm-3 control-label">年龄</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="age" name="age" value="{{ age }}">
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="age" class="col-sm-3 control-label">出生日期</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" required id="birthday" name="birthday" value=<?php 
                                    if ($birthday && !is_null($birthday) && $birthday!="0000-00-00") {
                                        echo "$birthday";
                                    } else {
                                        echo "1990-01-01";
                                    }                      
                                ?> ></div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">民族</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nation" required name="nation" value="{{ nation }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="col-sm-3 control-label">生源地</label>

                            <div class="radio col-sm-3">
                                <label>
                                    <input type="radio" name="nativeplace" value="1" 
                                            {% if nativeplace==1 %}
                                    checked
                                            {% endif %}>
                                    城市
                                </label>
                            </div>
                            <div class="radio col-sm-3">
                                <label>
                                    <input type="radio" name="nativeplace" value="0" 
                                            {% if nativeplace==0 %}
                                    checked
                                            {% endif %}>
                                    农村
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="col-sm-3 control-label">是独生子女</label>

                            <div class="radio col-sm-3">
                                <label>
                                    <input type="radio" name="singleton" value="1"
                                            {% if singleton==1 %}
                                    checked
                                            {% endif %}>
                                    是
                                </label>
                            </div>
                            <div class="radio col-sm-3">
                                <label>
                                    <input type="radio" name="singleton" value="0"
                                            {% if singleton==0 %}
                                    checked
                                            {% endif %}>
                                    否
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-6 col-sm-5 col-xs-12">
                                <button type="submit"
                                        class="btn btn-primary col-sm-12 col-xs-12 {% if isanswered %}disabled{% endif %}">
                                    保存信息
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <form method="get" id="start-form" action="/student/survey">
        <input type="hidden" name="isfirst" value="1">
        {% if iscompleted and isintime and !isanswered %}
        <a class="button button-circle button-royal start-btn" href="javascript:void(0);" id="start">开始答题</a>
        {% else %}
            <a id="start" href="javascript:void(0);" class="button button-circle button-royal disabled">
                开始答题<span class="glyphicon glyphicon-hand-right"></span>
            </a>
        {% endif %}
    </form>
</div>
