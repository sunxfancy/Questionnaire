{#
    本页面用于显示学生用户答题界面
#}
{{ assets.outputCss("survey-style") }}
<link rel="stylesheet" href="/public/lib/jquery.mobile-1.4.4.min.css" media="only screen and (max-width: 480px)">
{{ assets.outputJs("survey-script") }}
{#<script type="text/javascript" src="/public/lib/jquery.cookie.js"></script>#}
{#<link rel="stylesheet" href="/public/css/survey.css">#}
{#<link rel="stylesheet" href="/public/css/buttons.css">#}

<script>
    Array.prototype.in_array = function (e) {
        for (i = 0; i < this.length && this[i] != e; i++);
        return !(i == this.length);
    }

    var currentpart = $.cookie("part") != undefined ? $.cookie("part") : 0;
    //处理cookie

    if ($.cookie("part") != undefined && $.cookie("part") != 0) {
        //ajax
        $.ajax("/student/nextpart", {
            data: {cur: -1, next: currentpart},
            type: "get",
            success: function (data) {
                $("#content-div").html(data);
                //初始化参数
                currentpart = $.cookie("part");
                //问题个数
                q_num = $("#qnum").attr("qnum");
                //问题答案数组
                options = new Array(parseInt(q_num) + 1);
                for (var i = 1; i < options.length; i++) {
                    options[i] = 0;
                }
                //监听选择
                $(":radio").click(function () {
                    options[$(this).attr("name")] = String.fromCharCode('a'.charCodeAt() + parseInt($(this).val()) - 1);
                    $.cookie(pIds[currentpart], options.join(""), {expires: 10});
                    var index = $(this).attr("name");
                    $(".question-content[index=" + index + "]").css("background-color", "#6CC86C");
                    //console.log("part:"+currentpart)
                    console.log(options.join(""));
                    if (!options.in_array("0") && $.cookie("part") == currentpart) {
                        $.cookie("part", parseInt(currentpart) + 1, {expires: 10});
                    }
                    console.log(options.join(""));
                });
            },
            error: function () {

            }
        });
    }


    $(function () {
        {#
            part_num -> 总共的part数目，表示有多少次ajax请求
            test_id ->  本次测试的id，无用
            questions-> 题目
                options
                topictt
            parts   ->   partId列表
        #}

        //初始化参数
        //记录当前页面,存放cookie
        $.cookie("part", currentpart, {expires: 10});
        //问题个数
        var q_num = $("#qnum").attr("qnum");
        //问题答案数组
        var options = new Array(parseInt(q_num) + 1);
        for (var i = 1; i < options.length; i++) {
            options[i] = 0;
        }
        //当前页面索引
        var pIds = new Array();
        {% for j ,test in testinfo.parts  %}
        pIds[{{ j }}] ={{ testinfo.parts[j] }};
        {% endfor %}
        //根据当前part的cookie填充数据
        var clicks = $.cookie("" + pIds[currentpart]);
        if (clicks != undefined) {
            for (var i = 0; i < clicks.length; i++) {
                if (clicks[i] != '0') {
                    var value = clicks[i].charCodeAt() - 96;
                    var index = i + 1;
                    options[i + 1] = clicks[i];
                    $(":radio[name=" + index + "][value=" + value + "]").attr("checked", "checked");
                    $(".question-content[index=" + index + "]").css("background-color", "#6CC86C");
                }
            }
        }

        //console.log("clicks:"+clicks);
        //一共有多少个part
        var part_num = {{ testinfo.part_num }};


        //监听选择
        $(":radio").click(function () {
            options[$(this).attr("name")] = String.fromCharCode('a'.charCodeAt() + parseInt($(this).val()) - 1);
            $.cookie(pIds[currentpart], options.join(""), {expires: 10});
            var index = $(this).attr("name");
            $(".question-content[index=" + index + "]").css("background-color", "#6CC86C");
            //console.log("part:"+currentpart)
            if (!options.in_array("0") && $.cookie("part") == currentpart) {
                $.cookie("part", parseInt(currentpart) + 1, {expires: 10});
                console.log("昨晚一夜啦");
            }
            console.log(options.join(""));
        });

        //监听提交
        $("#next").click(function () {
            console.log("part num: " + part_num);
            if ($(":radio:checked").length == q_num) {
                if (part_num == $.cookie("part")) {
                    $.ajax('/student/nextpart', {
                        data: {cur: currentpart, next: -1},
                        type: "get",
                        success: function () {
                            $.removeCookie("part");
//                            for remove cookies
                            for (var p = 0; p < pIds.length; p++) {
                                $.removeCookie(pIds[p]);
                            }
                        },
                        error: function () {
                        }
                    });
                    alert("恭喜您已经答完题啦！！！");
                    window.location = "/stulogin/index/0/done";
                    return;
                }
                //ajax
                $.ajax("/student/nextpart", {
                    data: {cur: currentpart, next: $.cookie("part")},
                    type: "get",
                    async: false,
                    success: function (data) {
                        $("#content-div").html(data);
                        //初始化参数
                        currentpart = $.cookie("part");
                        //问题个数
                        q_num = $("#qnum").attr("qnum");
                        //问题答案数组
                        options = new Array(parseInt(q_num) + 1);
                        for (var i = 1; i < options.length; i++) {
                            options[i] = 0;
                        }
                        //监听选择
                        $(":radio").click(function () {
                            options[$(this).attr("name")] = String.fromCharCode('a'.charCodeAt() + parseInt($(this).val()) - 1);
                            $.cookie(pIds[currentpart], options.join(""), {expires: 10});
                            var index = $(this).attr("name");
                            $(".question-content[index=" + index + "]").css("background-color", "#6CC86C");
                            //console.log("part:"+currentpart)
                            console.log(options.join(""));
                            if (!options.in_array("0") && $.cookie("part") == currentpart) {
                                $.cookie("part", parseInt(currentpart) + 1, {expires: 1});
                            }
                            console.log(options.join(""));
                        });

                    },
                    error: function () {
                        alert("error");
                    }
                });

            } else {
                alert("回答完本页所有题目才能进入下一页！");
            }
        });
    });
</script>


{% if testinfo.mobile==2 %}
    <div id="content-div">
        {{ partial('/student/nextpart',['testinfo',testinfo]) }}
    </div>

    <a id="next" href="javascript:void(0);" class="button button-circle button-royal">下一页</a>

{% else %}
    <div id="content-div">
        {{ partial('/student/nextpart-mobile',['testinfo',testinfo]) }}
    </div>
{% endif %}


{#<a id="last" href="javascript:void(0);" class="button button-circle button-royal">上一页</a>#}
