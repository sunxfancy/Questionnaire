{#
    本文件用于学校管理员用户添加一次测评
#}

<div class="col-lg-12 test-form">
    <ol class="breadcrumb">
        <li><a href="#">添加测评</a></li>
        <li class="active">
            {% if info.type==0 %}
                试卷模式
            {% else %}
                模块模式
            {% endif %}
        </li>
    </ol>
    {{ partial('/shared/addtest',['info',info]) }}
</div>
