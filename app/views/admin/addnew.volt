<div class="Leo_question">
    <center><p style="margin-top:15px;font-size:28px;">评测项目信息填写</p></center>
    <hr size="2" color="#FF0000" />
    <div style="width:46px; height:100px; float:left;"></div>
    <table cellspacing="10">
        <tr>
            <td style=" width:160px;font-size:16px;line-height:28px; text-align:right;">项目名称：</td>
            <td style="width:530px;"colspan="3"><input id="name" type="text" style="height: 26px;width: 530px;"></td>
        </tr>
        <tr>
            <td style=" width:160px;font-size:16px;line-height:28px; text-align:right;">项目开始时间：</td>
            <td style="width:200px;"><input id="begintime" name="txtDate_3" type="date" class="inputtxt" style="height: 26px;width: 150px;"></td>
            <td style=" width:160px;font-size:16px;line-height:28px; text-align:right;">项目经理姓名：</td>
            <td style="width:200px;"><input id="manager_name" type="text" style="height: 26px;width: 150px;"></td>
            
        </tr>
        <tr>
            <td style=" width:160px;font-size:16px;line-height:28px; text-align:right;">项目结束时间：</td>
            <td style="width:200px;"><input id="endtime" name="txtDate_3" type="date" class="inputtxt" style="height: 26px;width: 150px;"></td>
            <td style=" width:160px;font-size:16px;line-height:28px; text-align:right;">项目经理账号：</td>
            <td style="width:200px;"><input id="manager_username" type="text" id="magname" style="height: 26px;width: 150px;"></td>
        </tr>
        <tr>
            <td style=" width:160px;font-size:16px;line-height:28px; text-align:right;">项目经理密码：</td>
            <td style="width:200px;"><input id="manager_password" type="password" style="height:26px;width:150px;"></td>
            <td style=" width:160px;font-size:16px;line-height:28px; text-align:right;">确认项目经理密码：</td>
            <td style="width:200px;"><input id="re_manager_password" type="password" style="height: 26px;width: 150px;" onblur="check()"></td>
        </tr>
    </table>
    <div style=" width:150px;font-size:16px; float:left; line-height:28px; text-align:right;">备注：</div>
    <textarea type="text" id="description" style=" line-height: 28px;outline: none;height: 100px;width: 605px;font-size:14px;"></textarea>
    <div id='submit' class="submitpro" style="display:block;text-align:center;margin-top:15px;">
        <img src="../images/submit.jpg" type="submit" onclick="window.location.href='/admin/index'" />
    </div>
</div>

<script type='text/javascript'>
$(document).ready(function() {

    $("#submit").click(function(){
            var project_info ={
                "name" :$("#name").val(),
                "begintime" :$("#begintime").val(),
                "endtime" :$("#endtime").val(),
                "manager_name" :$("#manager_name").val(),
                "manager_username" :$("#manager_username").val(),
                "manager_password" :$("#manager_password").val()
            }

            $.post('/admin/addnew', project_info);

    }); 

});


function check()
{ 
    with(document.all){
    if(manager_password.value!=re_manager_password.value)
        {
            alert("两次密码输入不一致！请重新输入...")
            manager_password.value = "";
            re_manager_password.value = "";
        }
    }
}
</script>