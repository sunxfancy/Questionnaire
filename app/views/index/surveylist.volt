<style>
    #table td {
        text-align: center;
        vertical-align: middle;
    }
    body{
        overflow: hidden;
    }
    .surveylist{
        overflow: auto;
        max-height: 400px;

    }
    
    .little-btn :hover {
        cursor: pointer;
    }
</style>
<script>
    $(function () {
        function getpage(path) {
            $.ajax({
                type: "get",
                url: path,
                dataType: "html",
                success: function (data) {
                    $(".content-div").html(data);
                    // $(".content-div").html($(data));
                },
                error: function () {
                    alert("error");
                }
            });
        }
        $(".view-btn").click(function () {
            var index = $(this).attr("index");
            var path = "/index/view/" + index;
            getpage(path);
        });
        $(".edit-btn").click(function () {
            var index = $(this).attr("index");
            var path = "/index/modifytest/" + index;
            getpage(path);
        });
        $(".import-btn").click(function () {
            var index = $(this).attr("index");
            var path = "/index/import/" + index;
            getpage(path);
        });
    });
</script>
<ol class="breadcrumb">
    <li><a href="#">编辑测评</a></li>
    <li class="active">测评列表</li>
</ol>
<div class="panel panel-primary surveylist">
    <!-- Default panel contents -->
    <div class="panel-heading">测评列表</div>

    <!-- Table -->

    <table id="table" class="table">
        <tr>
            <td>序号</td>
            <td>描述</td>
            <td>时间</td>
            <td>状态</td>
            <td>现有人数</td>
            <td>查看</td>
            <td>编辑</td>
            <td>导入</td>
            <td>导出</td>
        </tr>

        {% for test in tests %}
            <tr>
                <td>{{ loop.index }}</td>
                <td>{{ test['description'] }}</td>
                <td>{{ test['begin'] }} - {{ test['end'] }}</td>
                <td>{{ test['status'] }}</td>
                <td>{{ test['import'] }}</td>
                <td><a class="view-btn little-btn" index="{{ test['test_id'] }}">
                <span class="glyphicon glyphicon-eye-open"></span>
                </a></td>
                <td><a class="edit-btn little-btn" index="{{ test['test_id'] }}"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a class="import-btn little-btn" index="{{ test['test_id'] }}"><span class="glyphicon glyphicon-import"></span></a></td>
                <td><a class="export-btn little-btn" index="{{ test['test_id'] }}" href="/index/export?test_id={{ test['test_id'] }}"><span class="glyphicon glyphicon-export"></span></a></td>
            </tr>
        {% endfor %}
    </table>

</div>
<div class="text-center">
    {{ partial('/shared/urllabel') }}
</div>


<script>
    $(function(){
        $(".view-btn").tooltip({placement:'top',title:"查看测试",trigger:"hover focus"});
        $(".edit-btn").tooltip({placement:'top',title:"编辑测试",trigger:"hover focus"});
        $(".import-btn").tooltip({placement:'top',title:"导入学生数据",trigger:"hover focus"});
        $(".export-btn").tooltip({placement:'top',title:"导出成绩",trigger:"hover focus"});
    });
</script>