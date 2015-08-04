<div class="Leo_userlist">
    <div class="Leo_users_manage">
        <div style="height:5px;"></div>
        <table style="width:100%;">
            <tr style="width:100%;">
                <td style="text-align:left;width:50%;">
                    <input type="button" value="新增" onclick="Leo_newLeader()" />
                    <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="fileSelect" style="color:silver;height:25px;width:150px;">
                    <input type="button" value="导入" onclick="alert('导入成功');" />
                    <input type="button" value="导出" onclick="Leo_import()" />
                    <input type="checkbox" id="editable_2" /><span style="font-size:16px;">编辑</span>
                </td>
                <td style="width:50%;">
                    <input type="text" style="width:200px;height:25px;" />
                    <input type="button" value="搜索" style="width:50px;height:25px;" />
                </td>
            </tr>
        </table>
    </div>

    <div class="Leo_project_head">
        <table style="width:100%;font-size:15px;text-align:center;height:100%;" cellspacing="0" border="0">
            <tr style="height: 100%; vertical-align: middle;"><td style="width:5%"></td><td style="width:15%;">领导编号</td><td style="width:15%;">姓名</td><td style="width:15%;">性别</td><td style="width:25%;">最后登录时间</td><td style="width:25%;">密码</td></tr>
        </table>

    </div>
    <div class="Leo_project_body" id="Leo_leaders_body"></div>

</div>
