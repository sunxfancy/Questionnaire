<div class="Leo_userlist">
                <div class="Leo_users_manage">
                    <div style="height:5px;"></div>
                    <table style="width:100%;">
                        <tr style="width:100%;">
                            <td style="text-align:left;width:60%;">
                                <input type="button" value="新增" onclick="Leo_newUser(0)" />
								<input type="button" value="绿色通道" onclick="Leo_newUser(1)" />
                                <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="fileSelect" style="color:silver;height:25px;width:150px;">
                                <input type="button" value="导入" onclick="alert('导入成功');" />
                                <input type="button" value="导出" onclick="Leo_import()" />
                                <input type="checkbox" id="editable_0" /><span style="font-size:16px;">编辑</span>

                            </td>
                            <td style="width: 40%;">
                                <input type="text" style="width:200px;height:25px;" />
                                <input type="button" value="搜索" style="width:50px;height:25px;" />
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="Leo_project_head">
                    <table style="width:98%;font-size:15px;text-align:center;height:100%;" cellspacing="0">
                        <tr style="height: 100%; vertical-align: middle;"><td style="width:5%;"></td><td style="width:10%;">用户编号</td><td style="width:10%;">姓名</td><td style="width:10%;">性别</td><td style="width:10%;">是否答题<br/>完毕</td><td style="width:10%;">查看结果</td><td style="width:15%;text-align:center">最后登录<br/>时间</td><td style="width:10%;">密码</td><td style="width:10%">是否测试<br/>结束</td><td style="width:10%">查看报告</td></tr>
                    </table>

                </div>
                <div class="Leo_project_body" id="Leo_project_body"></div>

            </div>
        </div>