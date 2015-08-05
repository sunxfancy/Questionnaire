<div style="margin:0 auto;width:100%;height:45px;text-align:center;"><span style="font-size:30px;font-family:'Microsoft YaHei UI'">项目详情</span></div>
<table style="width:100%;height:220px;margin:0 auto;text-align:center;"><tr style="width:100%;margin:0 auto;"><td style="width:50%;">
<div id="project-completeness" style="height:200px;"></div>
</td><td>
<div id="interviewer-completeness" style="height:200px;"></div>
</td></tr></table>
<div style="width:100%;height:100px;">
   <span style="margin-left:40px;font-size:26px;color:red;"> 项目时间计划</span><br />
    <table style="width: 100%; font-size: 18px;text-align:center;">
        <tr style="width:100%;height:25px"><td style="width:20%;height:25px">2014-03-14</td><td style="width:20%;height:25px"></td><td style="width:20%;height:25px"></td><td id="now" style="width:20%;height:25px">当前</td><td style="width:20%;height:25px">2014-07-28</td></tr>
        <tr style="width:100%;height:25px"><td colspan="5" style="text-align:center;vertical-align:middle;">
            <div style="width:85%;height:20px;margin:0 auto;">
                     <table cellspacing="0" style="width:100%;height:100%;">
                <tr><td style="width:74%;height:100%;background-color:gray;"></td><td style="width:26%;height:100%;background-color:green;"></td></tr>
                     </table>
            </div></td></tr>
        <tr style="width:100%;height:25px"><td style="width:20%;height:25px">起始时间</td><td style="width:20%;height:25px"></td><td style="width:20%;height:25px"></td><td style="width:20%;height:25px">当前</td><td style="width:20%;height:25px">截止时间</td></tr>       
    </table>
    <div  style="width:100%;height:40px;text-align:center;margin: 5px 10px;">
        <form class="form-inline">
            <div class="form-group">
                <input type="file" name="file" input enctype="multipart/form-data" maxlength="100" style="height:30px;cursor:pointer;">
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit" >上传需求量表</button>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="/pm/selectmodule">配置测试题目模块</a>
            </div>
        </form>
    </div>
</div>

<!--[if IE]>
    <script type="text/javascript" src="/lib/flotr2.ie.min.js"></script>
<![endif]-->
<script type="text/javascript" src="/lib/flotr2.min.js"></script>

<script type="text/javascript">
(function project_pie(container) {
    var graph = Flotr.draw(container, [{
        data: [[0,15]],
        label: '已完成'
    }, {
        data: [[0,45]],
        label: '未完成'
    }], {
        title: '项目完成度',
        resolution: 1,
        HtmlText: true,
        grid: {
            verticalLines: false,
            horizontalLines: false
        },
        xaxis: {
            showLabels: false
        },
        yaxis: {
            showLabels: false
        },
        pie: {
            show: true,
            explode: 6
        },
        mouse: {
            track: true
        },
        legend: {
            position: 'se',
            backgroundColor: '#D2E8FF' 
        } 
    });
})(document.getElementById("project-completeness"));

(function interviewer_pie(container) {
    var graph = Flotr.draw(container, [{
        data: [[0, 0]],
        label: '已完成'
    }, {
        data: [[0,100]],
        label: '未完成'
    }], {
        title: '面询完成度',
        HtmlText: true,
        grid: {
            verticalLines: false,
            horizontalLines: false
        },
        xaxis: {
            showLabels: false
        },
        yaxis: {
            showLabels: false
        },
        pie: {
            show: true,
            explode: 6
        },
        mouse: {
            track: true
        },
        legend: {
            position: 'se',
            backgroundColor: '#D2E8FF'
        }
    });
})(document.getElementById("interviewer-completeness"));
</script>