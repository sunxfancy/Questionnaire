{#
    本文件是用于学校管理员用户注册之后，申请学校成功之前显示的页面
#}

{#第一次申请#}
{% if statue==-1 %}
    <div id="page-title" class="page-header">
        <h1>请申请您要管理的学校</h1>
    </div>
    {{ partial("shared/requestForm") }}
{% endif %}

{#申请失败#}
{% if statue==0 %}
    <div id="content-div" class="jumbotron">
        <h1>您的申请失败啦...</h1>
    </div>
    {{ partial("shared/requestForm") }}
{% endif %}

{#申请中...#}
{% if statue==2 %}
    <div id="content-div" class="jumbotron">
        <h1>您的申请正在审核中,请耐心等候...</h1>
    </div>
{% endif %}

