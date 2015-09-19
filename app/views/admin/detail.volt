<div class="Leo_question">
    <div style="margin:0 auto;width:100%;padding:10px 10px 0 10px;text-align:center;"><span style="font-size:30px;font-family:'Microsoft YaHei UI'">{{project_name}}</span></div>
    <hr size="2" color="#FF0000" />
    <table style="width:90%;margin:0 auto;text-align:center;">
        <tr style="width:100%;margin:0 auto;">
            <td style="width:47.5%;">
                <div id="project-completeness" style="height:200px;"></div>
            </td>
            <td style="width:5%;"></td>
            <td style="width:47.5%">
                <div id="interviewer-completeness" style="height:200px;"></div>
            </td>
        </tr>
    </table>
    <div style="width:100%;padding:10px;">
        <div style="margin-left:30px;padding:10px;font-size:26px;color:red;">项目时间计划</div>       
        <div style="width:90%; margin:0 auto;">
            <table style="width:100%"><tr><td id="begintime" style="width:20%;text-align:left;">{{ begintime }}</td><td id="now" style="width:60%; text-align:center;">{{ now }}</td><td id="endtime" style="width:20%;text-align:right;">{{ endtime }}</td></tr></table>
        </div> 
        <div class="progress" style="width:90%; margin:0 auto;">
            <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:{{ width }};">
            </div>
        </div>
        <div style="width:90%; margin:0 auto;">
            <table style="width:100%"><tr><td style="width:20%;text-align:left;">开始时间</td><td style="width:60%; text-align:center;">现在时间</td><td style="width:20%;text-align:right;">截止时间</td></tr></table>
        </div> 
    </div>
    <div style="width:100%;padding:0 60px;text-align:right; ">
        <div class="form-group">
            <button class="btn btn-primary" onclick='history.go(-1);'>返回首页</button>
        </div>
    </div>
</div>

<script type="text/javascript" src="/lib/flotr2.min.js"></script>
<script type="text/javascript">
    var examinee = {{detail}}.examinee_percent;
    var interview = {{detail}}.interview_percent;
    project_pie(document.getElementById("project-completeness"),examinee,'测评');
    project_pie(document.getElementById("interviewer-completeness"),interview,'面询');      

    function project_pie(container,data,name) {
        var graph = Flotr.draw(container, [{
            data: [[0,data]],
            label: '已完成'
        }, {
            data: [[0,1-data]],
            label: '未完成'
        }], {
            title: name + '完成度',
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
                track: false
            },
            legend: {
                position: 'se',
                backgroundColor: '#D2E8FF' 
            } 
        });
    }
</script>