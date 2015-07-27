{#桌面端#}
<div class="not-phone hidden-xs">
    <div class="row">
        <div class="title col-md-12">
            大学生心理健康调查问卷
        </div>
    </div>

    <div class="row">

        <div class="col-md-3 col-xs-12 question-description" id="question-description">
            {{ testinfo['description'] }}
        </div>

        <div class="col-md-offset-3 col-md-6 question-div hidden-sm">
            {% for index , question in testinfo['questions'] %}
                <div class="col-md-offset-1 col-md-11 question {% if (index+1)%5==0 %}page-end{% endif %}">
                    <div class="question-content">
                        <span class="label label-success">{{ index+1 }}</span>
                        <label>{{ question['topic'] }}</label>
                    </div>
                    <div class="question-option-box">
                        <?php $options = explode("|", $question['options']) ?>

                        {% for position , option  in options %}
                            <div class="question-option">
                                <label class="col-md-12">
                                    <input type="radio" name="{{ question['q_id'] }}"
                                           value="{{ position+1 }}"> {{ option }}
                                </label>
                            </div>
                        {% endfor %}
                        <div style="clear: both"></div>
                    </div>
                </div>
            {% endfor %}
            <a id="last" href="javascript:void(0);" class="button button-circle button-royal">上一页</a>
            <a id="next" href="javascript:void(0);" class="button button-circle button-royal">下一页</a>
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

    </div>
</div>

<div class="phone hidden-md hidden-sm hidden-lg">
    {% for i in 1..90 %}
        <div data-role="page" data-theme="b" index="{{ i }}" id="page{{ i }}">
            <div data-role="header">
                <h1 style="margin: 0">大学生心理健康调查问卷</h1>
            </div>

            <div data-role="content">
                <fieldset data-role="controlgroup">
                    <legend><span class="label label-success col-xs-1" style="margin-right: 5px">{{ i }}</span>
                        担任班级、学生会或社团的干部或干事
                    </legend>
                    {% for j in 1..4 %}
                        <label for="{{ i }}{{ j }}">{{ j }}alsldkjfls</label>
                        <input type="radio" name="gender" id="{{ i }}{{ j }}" value="{{ i }}{{ j }}">
                    {% endfor %}
                </fieldset>
            </div>
            <div data-role="footer" class="footer">
                <h1>滑动翻屏</h1>
            </div>
        </div>
    {% endfor %}
</div>