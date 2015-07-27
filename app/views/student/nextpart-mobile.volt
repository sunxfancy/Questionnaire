{# 手机端 #}
<script>
    $(function () {
        //向左滑动滚动条
        $(document).on("swipeleft", function () {
            var nextpage = $(".ui-page-active").next('div[data-role="page"]');
            if (nextpage.length > 0) {
                $.mobile.changePage(nextpage, {
                    transition: "slide",
                    reverse: false
                }, false, true);
            }
        });

        $(document).on("swiperight", function () {
            var prevpage = $(".ui-page-active").prev('div[data-role="page"]');
            if (prevpage.length > 0) {
                $.mobile.changePage(prevpage, {
                    transition: "slide",
                    reverse: true
                }, false, true);
            }
        });
//        alert("123");
    });
</script>

<div style="display: none" id="qnum" qnum="{{ testinfo.nextpart|length }}"></div>
<script type="text/javascript" src="/public/lib/jquery.mobile-1.4.4.min.js"></script>

<div class="phone hidden-md hidden-sm hidden-lg">
    {% for index , question in testinfo.nextpart %}
        <div data-role="page" data-theme="b" index="{{ index+1 }}" id="page{{ index+1 }}">
            <div data-role="header">
                <h1 style="margin: 0">大学生心理健康调查问卷</h1>
            </div>

            <div data-role="content">
                <fieldset data-role="controlgroup">
                    <legend><span class="label label-success">{{ index+1 }}</span>
                        {{ question['topic'] }}
                    </legend>
                    <?php $options = explode("|", $question['options']) ?>
                    {% for position , option  in options %}
                        <label for="{{ (index+1) }}:{{ (position+1) }}">{{ option }}</label>
                        <input type="radio" name="{{ index+1 }}" id="{{ (index+1) }}:{{ (position+1) }}"
                               value="{{ position+1 }}">
                    {% endfor %}
                </fieldset>
            </div>
            <div data-role="footer" class="footer">
                {% if index+1!= testinfo.nextpart|length %}
                    <h1>滑动翻页</h1>
                {% else %}
                    <button>下一套题</button>
                {% endif %}
            </div>
        </div>
    {% endfor %}
</div>

{#<div class="col-xs-12 hidden-sm hidden-lg hidden-md xs-question-div">#}
        {#{% for i in 1..90 %}#}
        {#<div class="col-md-12 xs-question" style="display: none">#}
        {#<div class="xs-question-content">#}
        {#<span class="label label-success col-xs-1" style="margin-right: 5px">{{ i }}</span>#}
        {#担任班级、学生会或社团的干部或干事#}
        {#</div>#}
        {#<div class="xs-question-option-box">#}
        {#{% for j in 1..4 %}#}
        {#<div class="xs-question-option">#}
        {#<label class="col-xs-12">#}
        {#<input type="radio" name="{{ i }}"> {{ j }}dasfls#}
        {#</label>#}
        {#<div style="clear: both"></div>#}
        {#</div>#}
        {#{% endfor %}#}
        {#</div>#}
        {#</div>#}
        {#{% endfor %}#}
        {#</div>#}