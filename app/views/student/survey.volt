{#桌面端#}
<script>
    $(function () {
        var $root = $('html, body');
	var q_num = {{ testinfo.nextpart|length }};
	try {
		var result = matchMedia("(max-width:768px)");
		$(".question-topic label").css("display","inline");
		
		if (result.matches) {

		    $(":radio").click(function () {
			var id = parseInt($(this).attr("name")) + 1;
			if(id!=q_num+1){
			    $root.animate({
				scrollTop: $("#question-" + id).offset().top - $("#instruction").get(0).offsetHeight -$("#instruction").get(0).offsetTop-10
			    }, 300);
			}
		    });
		} else {
		    $(":radio").click(function () {
			if (parseInt($(this).attr("name")) % 10 != 0) {
			    return;
			}
			var id = parseInt($(this).attr("name")) + 1;
			if(id!=q_num+1){
			    $root.animate({
				scrollTop: $("#question-" + id).offset().top - $("#instruction").get(0).offsetHeight-$("#instruction").get(0).offsetTop-10
			    }, 500);
			}
		    });
		}
	} catch(e) {
		console.log("ie9-sb");
	}
        //计时器
        function format(num){
            if(num.length==1){
                return "0"+num;
            }
            return num;
        }
        function setTime(times){
            var date = new Date(parseInt(times));
            var hour = format(date.getHours()-8+"");
            var min = format(date.getMinutes()+"");
            var sec = format(date.getSeconds()+"");
            $("#hour").text(hour);
            $("#minute").text(min);
            $("#second").text(sec);
        }
        var start = new Date().getTime();
        setTime(0);
        setInterval(function(){
            var end = new Date().getTime();
            setTime(end-start);
        },800);
        //手机指导语特效
        $(".instruction-short").click(function () {
            $(".instruction").slideToggle();
            if ($(this).hasClass("noexpand")) {
                $(".instruction-short .glyphicon").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
            } else {
                $(".instruction-short .glyphicon").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
            }
            $(this).toggleClass("noexpand");
        });
        //监听选择
        //问题答案数组
        var options = new Array(q_num + 1);
        for (var i = 1; i < options.length; i++) {
            options[i] = 0;
        }
        var clicks = $.cookie($.cookie("id") + "-{{ testinfo.cur }}");
        if (clicks == undefined || clicks == null)
            $.cookie($.cookie("id") + "-{{ testinfo.cur }}", options.join(""));
        //根据当前part的cookie填充数据
        else
            for (var i = 0; i < clicks.length; i++) {
                if (clicks[i] != '0') {
                    var value = clicks[i].charCodeAt() - 96;
                    var index = i + 1;
                    options[i + 1] = clicks[i];
                    $(":radio[name=" + index + "][value=" + value + "]").attr("checked", "checked");
                } else if (clicks[i] == 0) {
//                    $(".question-topic[index=" + (i + 1) + "]").addClass("unchecked");
                }
            }
        $(":radio").click(function () {
            {#{{ test }} {{ testinfo.cur }}#}
            var key = $.cookie("id") + "-{{ testinfo.cur }}";
            options[$(this).attr("name")] = String.fromCharCode('a'.charCodeAt() + parseInt($(this).val()) - 1);
            $.cookie(key, options.join(""), {expires: 1});
            var index = $(this).attr("name");
            $(".question-topic[index=" + index + "]").removeClass("unchecked");
            console.log("desktop");
        });
        $(".btn-next").click(function () {
            gotoNext();
        });
        var tx = false;

        function gotoNext() {
            if ($(":radio:checked").length == q_num) {
//                alert("进入");
                if (confirm("是否确认提交？")) {
                    tx = true;
                    console.log(tx);
                    $("#nextPage").submit();
                }
            } else {
                alert("本套题目您还未答完");
                var id;
                for (var i = 1; i <= options.length; i++) {
                    if (options[i] == "0") {
                        id = i;
                        $(".question-topic[index=" + i + "]").addClass("unchecked");
                        break;
                    }
                }
//                $("html,body").animate({scrollTop:top},1000);
                $root.animate({
                    scrollTop: $("#question-" + id).offset().top - $("#instruction").get(0).offsetHeight-$("#instruction").get(0).offsetTop-10
                }, 500);
            }
        }

        $(document).ready(function () {
            $('#instruction').stickUp();
        });
        $('#return-up').click(function () {
            $('body,html').animate({scrollTop: 0}, 300);
            return false;
        });

        var UnloadConfirm = {};
        UnloadConfirm.MSG_UNLOAD = "数据尚未保存，离开后可能会导致数据丢失\n\n您确定要离开吗？";
        UnloadConfirm.set = function (a) {
            window.onbeforeunload = function (b) {
                b = b || window.event;
                console.log(tx);
                if (!tx) {
                    b.returnValue = a;
                    return a;
                }
            }
        };
        UnloadConfirm.clear = function () {
            fckDraft.delDraftById();
            window.onbeforeunload = function () {
            }
        };
        UnloadConfirm.set(UnloadConfirm.MSG_UNLOAD);
    });


</script>


<body class="container-fluid" id="top">
<div class="row title">
    <div class="col-sm-8 col-sm-offset-2">大学生心理健康测评系统</div>
</div>
<div class="timer">
    <ul>
        <li id="hour"></li>
        <li class="mh">:</li>
        <li id="minute"></li>
        <li class="mh">:</li>
        <li id="second"></li>
    </ul>
</div>
<div id="instruction">
    <div class="instruction">
        {{ testinfo.description }}
    </div>
    <div class="instruction-short noexpand">
        <div style="width:80%;display: inline-block;">指导语</div>
        <div style="width: 10%;display:inline-block ;" class="glyphicon glyphicon-chevron-down"></div>
    </div>
</div>

{% for index , question in testinfo.nextpart %}
    {% if index%10==0 %}
        <div class="question-div col-sm-8 col-sm-offset-2">
    {% endif %}
    <div class="question ">
        <div class="question-topic" index="{{ index+1 }}" id="question-{{ index+1 }}">
           <span class="label label-primary">{{ index+1 }}</span>
               <label> {{ question['topic'] }}</label>
        </div>
        <div class="question-option-box">
            <?php $options = explode("|", $question['options']) ?>
            {% for position , option  in options %}
                <div class="question-option">
                    <label>
                        <input type="radio" name="{{ index+1 }}"
                               value="{{ position+1 }}"> {{ option }}
                    </label>
                </div>
            {% endfor %}
            <div style="clear: both"></div>
        </div>
    </div>
    <hr/>
    {% if (index+1)%10==0 %}
        <p class="pageNum">第<?php echo floor($index/10)+1?>页</p>
        </div>
    {% elseif loop.index==loop.length %}
        <p class="pageNum">第<?php echo floor($index/10)+1?>页</p>
        </div>
    {% endif %}
{% endfor %}

<div id="xqx">
    <img src="/image/xqx.jpg"/>
</div>
<a id="return-up" href="javascript:;" class="btn-up button glow button-rounded button-flat">回顶端</a>
<br>
{% if testinfo.next==-1 %}
    <a href="javascript:void(0);" class="btn-next button glow button-rounded button-flat" style="word-spacing: 11px;">完 成</a>
{% else %}
    <a href="javascript:void(0);" class="btn-next button glow button-rounded button-flat">下一页</a>
{% endif %}
<form id="nextPage" method="get" action="/student/survey">
    <input type="hidden" name="isfirst" value="2">
    <input type="hidden" name="cur" value="{{ testinfo.cur }}">
</form>
</body>
