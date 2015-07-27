{#桌面端#}
<div style="display: none" id="qnum" qnum="{{ testinfo.nextpart|length }}"></div>
<div class="not-phone hidden-xs">
    <div class="row">
        <div class="title col-md-12">
            大学生心理健康调查问卷
        </div>
    </div>

    <div class="row">

        <div class="col-md-3 col-xs-12 question-description" id="question-description" style="margin-left:30px;">
            {{ testinfo.description }}
        </div>

        <div class="col-md-offset-3 col-md-6 question-div hidden-sm">
            {% for index , question in testinfo.nextpart %}
                <div class="col-md-offset-1 col-md-11 question {% if (index+1)%5==0 %}page-end{% endif %}">
                    <div class="question-content" index="{{ index+1 }}">
                        <span class="label label-success">{{ index+1 }}</span>
                        <label>{{ question['topic'] }}</label>
                    </div>
                    <div class="question-option-box">
                        <?php $options = explode("|", $question['options']) ?>

                        {% for position , option  in options %}
                            <div class="question-option">
                                <label class="col-md-12">
                                    <input type="radio" name="{{ index+1 }}"
                                           value="{{ position+1 }}"> {{ option }}
                                </label>
                            </div>
                        {% endfor %}
                        <div style="clear: both"></div>
                    </div>
                </div>
            {% endfor %}

        </div>

    </div>
</div>

