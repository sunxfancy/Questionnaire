<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/scripts/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>

<div style="margin:0 auto;width:100%;height:45px;text-align:center;"><span style="font-size:30px;font-family:'Microsoft YaHei UI'">项目详情</span></div>

<table style="width:90%;height:220px;margin:0 auto;text-align:center;">
    <tr style="width:100%;margin:0 auto;">
        <td style="width:47.5%;">
            <div id="project-completeness" style="height:200px;"></div>
        </td>
        <td style="5%"><div></div></td>
        <td style="width:47.5%;">
            <div id="interviewer-completeness" style="height:200px;"></div>
        </td>
    </tr>
</table>

<div style="width:100%;height:100px;">
    <div style="margin-left:40px;font-size:26px;color:red;"> 项目时间计划</div>

    <div style="width:90%; margin:0 auto;">
        <table style="width:100%"><tr><td id="begintime" style="width:20%;text-align:left;">{{ begintime }}</td><td id="now" style="width:60%; text-align:center;">{{ now }}</td><td id="endtime" style="width:20%;text-align:right;">{{ endtime }}</td></tr></table>
    </div> 
    <div class="progress" style="width:90%; margin:0 auto;">
        <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
        </div>
    </div>
    <div style="width:90%; margin:0 auto;">
        <table style="width:100%"><tr><td style="width:20%;text-align:left;">开始时间</td><td style="width:60%; text-align:center;">现在时间</td><td style="width:20%;text-align:right;">截止时间</td></tr></table>
    </div> 

    <div  style="width:100%;height:40px;text-align:center;margin: 20px 10px;">
        <form class="form-inline" method="POST" action="/pm/uploadInquery" enctype='multipart/form-data'  >
            <div class="form-group">
                <input type="file" name="file" input enctype="multipart/form-data" maxlength="100" style="height:30px;cursor:pointer;">
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">上传需求量表</button>
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

    $.post('/pm/getWidth',function(data){
        var width = data.width;
        $("[id=progress]").css("width",width);
    });

    $.post('/pm/getDetail',function(data){
        details = data.detail;  
        project_pie(document.getElementById("project-completeness"),details);
        interviewer_pie(document.getElementById("interviewer-completeness"),details);      
    });

    function project_pie(container,details) {
        var graph = Flotr.draw(container, [{
            data: [[0,details.examinee_percent]],
            label: '已完成'
        }, {
            data: [[0,1-details.examinee_percent]],
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
    }

    function interviewer_pie(container) {
        var graph = Flotr.draw(container, [{
            data: [[0, details.interview_percent]],
            label: '已完成'
        }, {
            data: [[0,1-details.interview_percent]],
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
    }

</script>