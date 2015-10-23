<div class="Leo_question">
    <div class="baseinfo" style="width:100%;height:100%;overflow:auto;">
        <div style="padding:10px;text-align:center;font-size:28px;">基本信息</div>
        <table border="1" style="line-height:33px; margin:0 auto; font-size:16px; font-family:'微软雅黑'">
            <tr>
                <td style="width:120px;font-size:14px;">&nbsp;姓名</td>
                <td style="width:180px;">&nbsp;{{ name }}</td>
                <td style="width:120px;font-size:14px;">&nbsp;性别</td>
                <td style="width:180px;">&nbsp;{{ sex }}</td></tr>
            <tr>
                <td style="width:120px;font-size:14px;">&nbsp;学历</td>
                <td style="width:180px;">&nbsp;{{ education }}</td>
                <td style="width:120px;font-size:14px;">&nbsp;学位</td>
                <td style="width:180px;">&nbsp;{{ degree }}</td></tr>
            <tr>
                <td style="width:120px;font-size:14px;">&nbsp;出生年月</td>
                <td style="width:180px;">&nbsp;{{ birthday }}</td>
                <td style="width:120px;font-size:14px;">&nbsp;籍贯</td>
                <td style="width:180px;">&nbsp;{{ native }}</td></tr>
            <tr>
                <td style="width:120px;font-size:14px;">&nbsp;政治面貌</td>
                <td style="width:180px;">&nbsp;{{ politics }}</td>
                <td style="width:120px;font-size:14px;">&nbsp;职称</td>
                <td style="width:180px;">&nbsp;{{ professional }}</td></tr>
            <tr><td style="width:120px;font-size:14px;">&nbsp;工作单位</td>
                <td colspan="3" style="width:180px;">&nbsp;{{ employer }}</td></tr>
            <tr><td style="width:120px;font-size:14px;">&nbsp;部门</td>
                <td colspan="3" style="width:180px;">&nbsp;{{ unit }}</td></tr>
            <tr><td style="width:120px;font-size:14px;">&nbsp;职务</td>
                <td colspan="3" style="width:180px;">&nbsp;{{ duty }}</td></tr>
            <tr><td style="width:120px;font-size:14px;">&nbsp;班子/系统</td>
                <td colspan="3" style="width:180px;">&nbsp;{{ team }}</td></tr>
        </table>

        <div style="padding:10px;text-align:center;font-size:28px;">教育经历</div>
        <table id="eduTable" border="1" style="width:600px;line-height:33px;margin:0 auto;font-size:16px; font-family:'微软雅黑'">
            <tr style="font-weight:bold;font-size:14px;"><td>&nbsp;毕业院校</td><td>&nbsp;专业</td><td>&nbsp;所获学位</td><td>&nbsp;时间</td></tr>
        </table>

        <div style="padding:10px;text-align:center;font-size:28px;">工作经历</div>
        <table id="workTable" border="1" style="width:600px; line-height:33px; margin:0 auto; font-size:16px; font-family:'微软雅黑'">
            <tr style="font-weight:bold;font-size:14px;"><td>&nbsp;就职单位</td><td>&nbsp;部门</td><td>&nbsp;岗位/职务</td><td>&nbsp;起止时间</td></tr>
        </table>

        <div style="width:80%;text-align:right;margin: 30px 0 50px 0;">
            <form class="form-inline">
                <!-- <div class="form-group">
                    <button class="btn btn-info" style="width:100px;">
                    <i class="glyphicon glyphicon-print"></i>&nbsp;打印</button>
                </div>&nbsp;&nbsp;
                <div class="form-group">
                    <a class="btn btn-primary" href="#" style="width:100px;">
                    <i class="glyphicon glyphicon-download"></i>&nbsp;导出</a>
                </div>&nbsp;&nbsp; -->
                <div class="form-group">
                    <a class="btn btn-success" href="/leader/index" style="width:100px;">
                    <i class="glyphicon glyphicon-home"></i>&nbsp;返回首页</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var education = {{other}}.education;
    var work = {{other}}.work;
    showEdu(education,eduTable);
    showWork(work,workTable);

    function showEdu(data){
        for (var i = 0; i < data.length; i++) {
            var data1 = document.getElementById('eduTable').insertRow(i+1);
            var td0 = data1.insertCell(0);
            var td1 = data1.insertCell(1);
            var td2 = data1.insertCell(2);
            var td3 = data1.insertCell(3);
            td0.innerHTML = "&nbsp;"+data[i].school;
            td1.innerHTML = "&nbsp;"+data[i].profession;
            td2.innerHTML = "&nbsp;"+data[i].degree;
            td3.innerHTML = "&nbsp;"+data[i].date;
        }
    }

    function showWork(data){
        for (var i = 0; i < data.length; i++) {
            var data1 = document.getElementById('workTable').insertRow(i+1);
            var td0 = data1.insertCell(0);
            var td1 = data1.insertCell(1);
            var td2 = data1.insertCell(2);
            var td3 = data1.insertCell(3);
            td0.innerHTML = "&nbsp;"+data[i].unit;
            td1.innerHTML = "&nbsp;"+data[i].employer;
            td2.innerHTML = "&nbsp;"+data[i].duty;
            td3.innerHTML = "&nbsp;"+data[i].date;
        }
    }
</script>