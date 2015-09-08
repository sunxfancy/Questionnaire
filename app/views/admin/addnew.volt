    <!--添加datepicker支持-->  
    <script src="js/jquery.ui.core.js" src="js/jquery.ui.core.js" type="text/javascript"></script>  
    <script src="js/jquery.ui.datepicker.js" src="js/jquery.ui.datepicker.js" type="text/javascript"></script>  
    <!--引入样式css-->  
    <link type="text/css" rel="stylesheet" href="css/jquery-ui-1.7.3.custom.css" href="css/jquery-ui-1.7.3.custom.css" />  
    <!-- 添加中文支持-->  
    <script src="js/jquery.ui.datepicker-zh-CN.js" src="js/jquery.ui.datepicker-zh-CN.js" type="text/javascript"></script>  

<div class="Leo_question">
    <center><p style="margin-top:15px;font-size:28px;font-family:'Microsoft YaHei';">评测项目信息填写</p></center>
    <hr size="2" color="#FF0000" />

    <table style="margin:0 auto;">
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目名称：</td>
            <td colspan="3"><input id="project_name" type="text" style="width:200px;height:26px;"></td>
        </tr>
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目开始时间：</td>
            <td><div class="input-append date form_datetime">
                <input id="begintime" type="text" value="" readonly style="width:200px;height:26px;">
                <span class="add-on"><i class="icon-th"></i></span>
                </div>
            </td>
        </tr>
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目结束时间：</td>
            <td><div class="input-append date form_datetime">
                <input id="endtime" type="text" value="" readonly style="width:200px;height:26px;">
                <span class="add-on"><i class="icon-th"></i></span>
                </div></td>
        </tr>
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目经理姓名：</td>
            <td><input id="pm_name" type="text" style="height: 26px;width: 200px;"></td> 
        </tr>
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目经理账号：</td>
            <td><input id="pm_username" type="text" style="height: 26px;width: 200px;font-family:'Microsoft YaHei';"></td>
        </tr>
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目经理密码：</td>
            <td><input id="pm_password" type="password" style="height:26px;width:200px;"></td>
        </tr>
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">确认项目经理密码：</td>
            <td><input id="re_pm_password" type="password" style="height: 26px;width: 200px;" onblur="check()"></td>
        </tr>
    </table>

    <div style="margin-top:15px;"></div>
    <table style="margin:0 auto;">
    <tr><td>
        <textarea type="text" id="description" style=" line-height: 28px;outline: none;height: 100px;width: 600px;font-size:16px;">更详细的信息描述...</textarea>
    </td></tr>
    </table>

    <div style="width:100%;height:40px;text-align:center;margin: 10px 10px;">
        <div class="form-group">
            <a class="btn btn-success" href="/admin/index">返回</a>
            <a id="submit" class="btn btn-primary">提交</a>
        </div>
    </div>

</div>

<script type='text/javascript'>
    $(document).ready(function() {
        $("#submit").click(function(){
                var project_info ={
                    "project_name" :$("#project_name").val(),
                    "description" :$("#description").val(),
                    "begintime" :$("#begintime").val(),
                    "endtime" :$("#endtime").val(),
                    "pm_name" :$("#pm_name").val(),
                    "pm_username" :$("#pm_username").val(),
                    "pm_password" :$("#pm_password").val()
                }
                $.post('/admin/newproject', project_info,callbk);
        }); 
        function callbk(){
            window.location.href = "/admin/index";
        }
    });

    function check(){ 
        with(document.all){
        if(pm_password.value!=re_pm_password.value){
                alert("两次密码输入不一致！请重新输入...")
                pm_password.value = "";
                re_pm_password.value = "";
            }
        }
    }

    var date = new Date();
    var now = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
    $('#begintime').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        todayBtn: true,
        startDate: now,
        pickerPosition: "bottom-left"
    });
    $('#endtime').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        todayBtn: true,
        startDate: $("#begintime").val(),
        pickerPosition: "bottom-left"
    });

</script>