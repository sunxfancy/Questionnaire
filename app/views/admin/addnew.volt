<div class="Leo_question">
    <center><p style="margin-top:15px;font-size:28px;font-family:'Microsoft YaHei';">评测项目信息填写</p></center>
    <hr size="2" color="#FF0000" />
    <div style="width:46px; height:100px; float:left;"></div>
    <table style="margin:0 auto;">
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目名称：</td>
            <td colspan="3"><input id="project_name" type="text" style="width:200px;height:26px;font-"></td>
        </tr>
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目开始时间：</td>
            <td><input id="begintime" type="text" readonly class="form_datetime" style="height: 26px;width: 200px;"></td>
        </tr>
        <tr>
            <td style=" width:150px;font-size:16px;line-height:28px; text-align:right;font-family:'Microsoft YaHei';">项目结束时间：</td>
            <td><input id="endtime" type="text" readonly class="form_datetime" style="height: 26px;width: 200px;"></td>
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
    <!-- <tr><td style="text-align:center; line-height:28px;">备注：</td></tr> -->
    <tr><td><textarea type="text" id="description" style=" line-height: 28px;outline: none;height: 100px;width: 600px;font-size:16px;">更详细的信息描述...</textarea></td></tr>
    </table>
    <div id='submit' class="submitpro" style="display:block;text-align:center;margin-top:15px;">
        <img src="../images/submit.jpg" type="submit" style="cursor:pointer;"/>
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

        function check()
        { 
            with(document.all){
            if(pm_password.value!=re_pm_password.value)
                {
                    alert("两次密码输入不一致！请重新输入...")
                    pm_password.value = "";
                    re_pm_password.value = "";
                }
            }
        }

    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

</script>