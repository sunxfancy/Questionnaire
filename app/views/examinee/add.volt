<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>个人资料填写</title>
    <link rel="stylesheet" type="text/css" href="../css/Leo_global_css.css" />
    <script src="../javascript/Leo_global_script.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../css/Leo_normal_css.css" />
    <script language="javascript">
        var count1=1;
        var count2=2;
        function insertRow1(){
            count1++;
            var x=document.getElementById('myTable1').insertRow(count1+1);
            var a=x.insertCell(0);
            var b=x.insertCell(1);
            var c=x.insertCell(2);
            var d=x.insertCell(3);
            var e = x.insertCell(4);

            a.style.width = "145px";
            b.style.width = "145px";
            c.style.width = "145px";
            d.style.width = "145px";
            e.style.width = "35px";

            a.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:26px;font-family:"微软雅黑";">';
            b.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:26px;font-family:"微软雅黑";">';
            c.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:26px;font-family:"微软雅黑";">';
            d.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:26px;font-family:"微软雅黑";">';
            e.innerHTML='<img src="../images/del.jpg" value="删除" onclick="deleteRow1(this)">';
        }
        function deleteRow1(r){
           count1--;
           var i=r.parentNode.parentNode.rowIndex;
           document.getElementById('myTable1').deleteRow(i);
        }
        function insertRow2(){
            count2++;
            var x=document.getElementById('myTable2').insertRow(count2+1);
            var a=x.insertCell(0);
            var b=x.insertCell(1);
            var c=x.insertCell(2);
            var d=x.insertCell(3);
            var e = x.insertCell(4);

            a.style.width = "145px";
            b.style.width = "145px";
            c.style.width = "145px";
            d.style.width = "145px";
            e.style.width = "35px";

            a.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:26px;font-family:"微软雅黑";">';
            b.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:26px;font-family:"微软雅黑";">';
            c.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:26px;font-family:"微软雅黑";">';
            d.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:26px;font-family:"微软雅黑";">';
            e.innerHTML='<img src="../images/del.jpg" value="删除" onclick="deleteRow2(this)">';
        }
        function deleteRow2(r){
           count2--;
           var i=r.parentNode.parentNode.rowIndex;
           document.getElementById('myTable2').deleteRow(i);
        }
    </script>
</head>

<body>
    <div class="Leo_title">
       <div class="Leo_title_l">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人 才 测 评 系 统</div>
    </div>

    <div class="Leo_info">
        <div style="width:100%;height:50px;"></div>
        <div class="Leo_info_user">
            <img src="../images/user2.png" />
        </div>
        <div class="Leo_info_l">
            <table cellspacing="0">
                <tr><td>姓名</td><td>张晓强</td></tr>
                <tr><td>编号</td><td>us001</td></tr>
                <tr><td>权限</td><td>被试人员</td></tr>


            </table>
        </div>


    </div>

    <div class="Leo_question">
        <div class="baseinfo" style="width:100%;height:100%;">
            <div style="height:10px;"></div>
            <div style="width:100%;height:47px;font-size:36px;text-align:center;">输入个人信息</div>
            <div style="width:100%;height:3px;background-color:red;"></div>
            <div style="overflow:auto;height:440px;">
                <div style="height:30px;text-align:center;">基本信息</div>
                <table border="1" cellspacing="0" cellpadding="0" style="margin: 0 auto;">

                    <tr>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">姓名</td>
                        <td style="width:180px;font-size:16px;text-align:center; font-family:'微软雅黑'" onclick="Leo_toEdit(this)">张晓强</td>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">性别</td>
                        <td style="width: 180px; font-size: 16px; text-align: center; font-family: '微软雅黑'" onclick="Leo_toEdit(this)">男</td>
                    </tr>

                    <tr>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">学历</td>
                        <td style="width:180px;">
                            <select style="border:0px;width:150px;font-size:16px; float:center;line-height:28px; text-align:center; font-family:'微软雅黑'">
                                <option value="空">请选择</option>
                                <option value="函授大专">函授大专</option>
                                <option value="在职大专">在职大专</option>
                                <option value="全日制大专">全日制大专</option>
                                <option value="函授本科">函授本科</option>
                                <option value="在职本科">在职本科</option>
                                <option value="全日制本科">全日制本科</option>
                                <option value="在职硕士">在职硕士</option>
                                <option value="全日制硕士">全日制硕士</option>
                                <option value="博士">博士</option>
                                <option value="其他">其他</option>
                            </select>
                        </td>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">学位</td>
                        <td style="width:180px;">
                            <select style="border:0px;width:145px;font-size:16px; float:center;line-height:28px; text-align:center; font-family:'微软雅黑'">
                                <option value="空">请选择</option>
                                <option value="工科学士学位">工科学士学位</option>
                                <option value="理科学士学位">理科学士学位</option>
                                <option value="文科学士学位">文科学士学位</option>
                                <option value="普通硕士学位">普通硕士学位</option>
                                <option value="专业硕士学位">专业硕士学位</option>
                                <option value="博士学位">博士学位</option>
                                <option value="其他">其他</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">出生年月</td>
                        <td style="width:180px;">
                            <table>
                                <tr>
                                    <td>
                                        <select id="year" onchange="changeday()" name="year"><option value="">年</option></select>
                                        <select id="month" name="month" onchange="changeday()"><option value="">月</option> </select>
                                        <select id="day" name="day"><option value="">日</option> </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">籍贯</td>
                        <td style="width:180px;">
                            <input id="addtxt" style="width:116px;margin-top:3px;font-size:16px;line-height:28px;font-family:'微软雅黑'">
                            <span class="span">
                                <select id="addselect" onblur="return Item_onBlur(this,addtxt)" onmouseover="return Item_onMouseOver(this)" onchange="return Input_onchange(this)" style="width:20px;height:26px;font-size:16px;line-height:28px; font-family:'微软雅黑'">
                                    <option value="请选择">请选择</option>
                                    <option value="北京市">北京市</option>
                                    <option value="安徽省">安徽省</option>
                                    <option value="重庆市">重庆市</option>
                                    <option value="福建省">福建省</option>
                                    <option value="甘肃省">甘肃省</option>
                                    <option value="广东省">广东省</option>
                                    <option value="广西壮族自治区">广西壮族自治区</option>
                                    <option value="贵州省">贵州省</option>
                                    <option value="海南省">海南省</option>
                                    <option value="河北省">河北省</option>
                                    <option value="河南省">河南省</option>
                                    <option value="黑龙江省">黑龙江省</option>
                                    <option value="湖北省">湖北省</option>
                                    <option value="湖南省">湖南省</option>
                                    <option value="吉林省">吉林省</option>
                                    <option value="江苏省">江苏省</option>
                                    <option value="江西省">江西省</option>
                                    <option value="辽宁省">辽宁省</option>
                                    <option value="内蒙古自治区">内蒙古自治区</option>
                                    <option value="宁夏回族自治区">宁夏回族自治区</option>
                                    <option value="青海省">青海省</option>
                                    <option value="山东省">山东省</option>
                                    <option value="山西省">山西省</option>
                                    <option value="陕西省">陕西省</option>
                                    <option value="上海市">上海市</option>
                                    <option value="四川省">四川省</option>
                                    <option value="天津市">天津市</option>
                                    <option value="西藏自治区">西藏自治区</option>
                                    <option value="新疆维吾尔族自治区">新疆维吾尔族自治区</option>
                                    <option value="云南省">云南省</option>
                                    <option value="浙江省">浙江省</option>
                                    <option value="台湾省">台湾省</option>
                                    <option value="香港">香港</option>
                                    <option value="澳门">澳门</option>
                                </select>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">政治面貌</td>
                        <td style="width:180px;">
                            <select style="border:0px;width:150px;font-size:16px; float:center;line-height:28px; text-align:center; font-family:'微软雅黑'">
                                <option value="空">请选择</option>
                                <option value="无">无党派</option>
                                <option value="团员">团员</option>
                                <option value="党员">党员</option>
                                <option value="群众">群众</option>
                                <option value="民主党派">民主党派</option>
                            </select>
                        </td>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">职称</td>
                        <td style="width:180px;">
                            <select style="border:0px;width:145px;font-size:16px; float:center;line-height:28px; text-align:center; font-family:'微软雅黑'">
                                <option value="空">请选择</option>
                                <option value="无职称">无职称</option>
                                <option value="初级">初级</option>
                                <option value="中级">中级</option>
                                <option value="副高职">副高职</option>
                                <option value="正高职">正高职</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">工作单位</td>
                        <td colspan="3" style=" width:180px;font-size:16px; font-family: '微软雅黑'" onclick="Leo_toEdit(this)">北京市政法委宣传处</td>
                    </tr>

                    <tr>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">部门</td>
                        <td colspan="3" style="width: 180px; font-size: 16px; font-family: '微软雅黑'" onclick="Leo_toEdit(this)">宣传处</td>
                    </tr>

                    <tr>
                        <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">岗位/职务</td>
                        <td colspan="3" style="width: 180px; font-size: 16px; font-family: '微软雅黑'" onclick="Leo_toEdit(this)">副处长</td>
                    </tr>
                </table>
                <div style="height:10px;"></div>
                <div style="height:30px;text-align:center;">教育经历</div>
                <table id="myTable1" style="margin: 0 auto;" border="1" cellspacing="0" cellpadding="1" >

                    <tr>
                        <th style=" width:145px;font-size:16px;line-height:26px; text-align:center; font-family:'微软雅黑'">毕业院校</th>
                        <th style=" width:145px;font-size:16px;line-height:26px; text-align:center; font-family:'微软雅黑'">专业</th>
                        <th style=" width:145px;font-size:16px;line-height:26px; text-align:center; font-family:'微软雅黑'">所获学位</th>
                        <th style=" width:145px;font-size:16px;line-height:26px; text-align:center; font-family:'微软雅黑'">时间</th>
                    </tr>
                    <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                        <td style="width:145px;" onclick="Leo_toEdit(this)">市委党校</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">工商管理</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">硕士</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">2001.9-2003.12</td>
                    </tr>
                    <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                        <td style="width:145px;" onclick="Leo_toEdit(this)">北京交通大学</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">计算机应用</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">学士</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">1997.9-2001.7</td>
                    </tr>
                </table>
                <!--<div id="Leo_add" style="width:86.5%;height:50px;text-align:right;"><img src="../images/add.jpg" onclick="insertRow1()" value="增加一行"></div>-->
				<div id="Leo_add" style="width:86.5%;height:50px;margin:0 auto;;text-align:center;"><input type='button' value='增加一行' onclick="insertRow1()" ></div>

                <div style="height:10px;"></div>
                <div style="height:30px;text-align:center;">工作经历</div>
                <table id="myTable2" border="1"cellspacing="0" cellpadding="0" style="margin: 0 auto;">

                    <tr>
                        <th style=" width:145px;font-size:16px;line-height:32px; text-align:center; font-family:'微软雅黑'">就职单位</th>
                        <th style=" width:145px;font-size:16px;line-height:32px; text-align:center; font-family:'微软雅黑'">部门</th>
                        <th style=" width:145px;font-size:16px;line-height:32px; text-align:center; font-family:'微软雅黑'">岗位/职务</th>
                        <th style=" width:145px;font-size:16px;line-height:32px; text-align:center; font-family:'微软雅黑'">起止时间</th>
                    </tr>
                    <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                        <td style="width:145px;" onclick="Leo_toEdit(this)">北京市政法委</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">宣传处</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">副处</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">2012.4-今</td>
                    </tr>
                    <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                        <td style="width:145px;" onclick="Leo_toEdit(this)">北京市政法委</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">宣传处</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">科长</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">2008.4-2012.4</td>
                    </tr>
                    <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                        <td style="width:145px;" onclick="Leo_toEdit(this)">北京市政法委</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">宣传处</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">科员</td>
                        <td style="width:145px;" onclick="Leo_toEdit(this)">2004.1-2008.4</td>
                    </tr>
                </table>
               <!-- <div id="Leo_add" style="width:86.5%;height:50px;text-align:right;"><img src="../images/add.jpg" onclick="insertRow2()" value="增加一行"></div>-->

			   	<div id="Leo_add" style="width:86.5%;height:50px;margin:0 auto;;text-align:center;"><input type='button' value='增加一行' onclick="insertRow2()" ></div>

                <div class="submit" style="display:block;text-align:center;margin-top:15px;">
                    <img src="../images/submit.jpg" type="submit" onclick="window.location.href='Leo_examination.html'" />
                </div>
                <!--
                <table style="height:100%;width:440px;border:0px;" cellspacing="0">

                    <tr style="height:2.5px;"><td style="background-color:red;"></td></tr>
                    <tr style="height:342.5px;"><td>
                        <table border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                            <caption style="font-size:20px;font-family:'微软雅黑';">基本信息</caption>
                            <tr>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">姓名</td>
                                <td style="font-size:16px;text-align:center; font-family:'微软雅黑'" onclick ="Leo_toEdit(this)">刘向东</td>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">性别</td>
                                <td style="font-size:16px;text-align:center; font-family:'微软雅黑'" onclick ="Leo_toEdit(this)">男</td>
                            </tr>

                            <tr>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">学历</td>
                                <td><select style="border:0px;width:150px;font-size:16px; float:center;line-height:28px; text-align:center; font-family:'微软雅黑'">
                                    <option value="空">请选择</option>
                                    <option value="函授大专">函授大专</option>
                                    <option value="在职大专">在职大专</option>
                                    <option value="全日制大专">全日制大专</option>
                                    <option value="函授本科">函授本科</option>
                                    <option value="在职本科">在职本科</option>
                                    <option value="全日制本科">全日制本科</option>
                                    <option value="在职硕士">在职硕士</option>
                                    <option value="全日制硕士">全日制硕士</option>
                                    <option value="博士">博士</option>
                                    <option value="其他">其他</option>
                                </select></td>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">学位</td>
                                <td><select style="border:0px;width:145px;font-size:16px; float:center;line-height:28px; text-align:center; font-family:'微软雅黑'">
                                    <option value="空">请选择</option>
                                    <option value="工科学士学位">工科学士学位</option>
                                    <option value="理科学士学位">理科学士学位</option>
                                    <option value="文科学士学位">文科学士学位</option>
                                    <option value="普通硕士学位">普通硕士学位</option>
                                    <option value="专业硕士学位">专业硕士学位</option>
                                    <option value="博士学位">博士学位</option>
                                    <option value="其他">其他</option>
                                </select></td>
                            </tr>

                            <tr>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">出生年月</td>
                                <td>
                                    <table>
                                    <tr>
                                        <td>
                                        <select id="year" onchange="changeday()" name="year"> <option value="">年</option></select>
                                        <select id="month" name="month"  onchange="changeday()"><option value="">月</option> </select>
                                        <select id="day" name="day" ><option value="">日</option> </select>
                                       </td>
                                </tr>
                                </table>
                                </td>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">籍贯</td>
                                <td>
                                    <input id="addtxt" style="width:116px;margin-top:3px;font-size:16px;line-height:28px;font-family:'微软雅黑'">
                                    <span class="span">
                                    <select id="addselect" onBlur="return Item_onBlur(this,addtxt)" onMouseOver="return Item_onMouseOver(this)" onchange="return Input_onchange(this)" style="width:20px;height:26px;font-size:16px;line-height:28px; font-family:'微软雅黑'">
                                        <option value="请选择">请选择</option>
                                        <option value="北京市">北京市</option>
                                        <option value="安徽省">安徽省</option>
                                        <option value="重庆市">重庆市</option>
                                        <option value="福建省">福建省</option>
                                        <option value="甘肃省">甘肃省</option>
                                        <option value="广东省">广东省</option>
                                        <option value="广西壮族自治区">广西壮族自治区</option>
                                        <option value="贵州省">贵州省</option>
                                        <option value="海南省">海南省</option>
                                        <option value="河北省">河北省</option>
                                        <option value="河南省">河南省</option>
                                        <option value="黑龙江省">黑龙江省</option>
                                        <option value="湖北省">湖北省</option>
                                        <option value="湖南省">湖南省</option>
                                        <option value="吉林省">吉林省</option>
                                        <option value="江苏省">江苏省</option>
                                        <option value="江西省">江西省</option>
                                        <option value="辽宁省">辽宁省</option>
                                        <option value="内蒙古自治区">内蒙古自治区</option>
                                        <option value="宁夏回族自治区">宁夏回族自治区</option>
                                        <option value="青海省">青海省</option>
                                        <option value="山东省">山东省</option>
                                        <option value="山西省">山西省</option>
                                        <option value="陕西省">陕西省</option>
                                        <option value="上海市">上海市</option>
                                        <option value="四川省">四川省</option>
                                        <option value="天津市">天津市</option>
                                        <option value="西藏自治区">西藏自治区</option>
                                        <option value="新疆维吾尔族自治区">新疆维吾尔族自治区</option>
                                        <option value="云南省">云南省</option>
                                        <option value="浙江省">浙江省</option>
                                        <option value="台湾省">台湾省</option>
                                        <option value="香港">香港</option>
                                        <option value="澳门">澳门</option>
                                    </select></span></td>
                            </tr>

                            <tr>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">政治面貌</td>
                                <td><select style="border:0px;width:150px;font-size:16px; float:center;line-height:28px; text-align:center; font-family:'微软雅黑'">
                                    <option value="空">请选择</option>
                                    <option value="无">无党派</option>
                                    <option value="团员">团员</option>
                                    <option value="党员">党员</option>
                                    <option value="群众">群众</option>
                                    <option value="民主党派">民主党派</option>
                                </select></td>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">职称</td>
                                <td><select style="border:0px;width:145px;font-size:16px; float:center;line-height:28px; text-align:center; font-family:'微软雅黑'">
                                    <option value="空">请选择</option>
                                    <option value="无职称">无职称</option>
                                    <option value="初级">初级</option>
                                    <option value="中级">中级</option>
                                    <option value="副高职">副高职</option>
                                    <option value="正高职">正高职</option>
                                </select></td>
                            </tr>

                            <tr>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">工作单位</td>
                                <td colspan="3" style="font-size:16px;font-family:'微软雅黑'" onclick ="Leo_toEdit(this)">北京航空航天大学</td>
                            </tr>

                            <tr>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">部门</td>
                                <td colspan="3" style="font-size:16px;font-family:'微软雅黑'" onclick ="Leo_toEdit(this)">网络中心</td>
                            </tr>

                            <tr>
                                <td style=" width:120px;font-size:16px;line-height:33px; text-align:center; font-family:'微软雅黑'">岗位/职务</td>
                                <td colspan="3" style="font-size:16px;font-family:'微软雅黑'" onclick ="Leo_toEdit(this)">调研员</td>
                            </tr>
                        </table></td>
                    </tr>
                </table>
            </div>

            <div class="learninfo">
                <table id="myTable1" bgcolor="yellow" border="1" bordercolor="#000000" cellspacing="0" cellpadding="1" style="margin: 0 auto;">
                <caption style="font-size:20px;font-family:'微软雅黑';">教育经历</caption>
                <tr>
                    <th style=" width:145px;font-size:16px;line-height:26px; text-align:center; font-family:'微软雅黑'">毕业院校</th>
                    <th style=" width:145px;font-size:16px;line-height:26px; text-align:center; font-family:'微软雅黑'">专业</th>
                    <th style=" width:145px;font-size:16px;line-height:26px; text-align:center; font-family:'微软雅黑'">所获学位</th>
                    <th style=" width:145px;font-size:16px;line-height:26px; text-align:center; font-family:'微软雅黑'">时间</th>
                </tr>
                <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'" >
                    <td onclick ="Leo_toEdit(this)">北京航空航天大学</td>
                    <td onclick ="Leo_toEdit(this)">计算机科学与技术</td>
                    <td onclick ="Leo_toEdit(this)">学士</td>
                    <td onclick ="Leo_toEdit(this)">1994/9-1998/6</td></tr>
                <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                    <td onclick ="Leo_toEdit(this)">北京航空航天大学</td>
                    <td onclick ="Leo_toEdit(this)">计算机科学与技术</td>
                    <td onclick ="Leo_toEdit(this)">硕士</td>
                    <td onclick ="Leo_toEdit(this)">1998/9-2001/6</td></tr>
                <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                    <td onclick ="Leo_toEdit(this)">北京航空航天大学</td>
                    <td onclick ="Leo_toEdit(this)">计算机科学与技术</td>
                    <td onclick ="Leo_toEdit(this)">博士</td>
                    <td onclick ="Leo_toEdit(this)">2001/9-2004/6</td></tr>
                </table>
                <div id="Leo_add" style="width:86.5%;height:100%;text-align:right;"><img src="images/add.jpg" onclick="insertRow1()" value="增加一行" ></div>
            </div>

            <div class="jobinfo">
                <table id="myTable2" bgcolor="yellow" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                <caption style="font-size:20px;font-family:'微软雅黑';">工作经历</caption>
                <tr>
                    <th style=" width:145px;font-size:16px;line-height:32px; text-align:center; font-family:'微软雅黑'">就职单位</th>
                    <th style=" width:145px;font-size:16px;line-height:32px; text-align:center; font-family:'微软雅黑'">部门</th>
                    <th style=" width:145px;font-size:16px;line-height:32px; text-align:center; font-family:'微软雅黑'">岗位/职务</th>
                    <th style=" width:145px;font-size:16px;line-height:32px; text-align:center; font-family:'微软雅黑'">起止时间</th>
                </tr>
                <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                    <td onclick ="Leo_toEdit(this)">北京航空航天大学</td>
                    <td onclick ="Leo_toEdit(this)">计算机学院</td>
                    <td onclick ="Leo_toEdit(this)">教师</td>
                    <td onclick ="Leo_toEdit(this)">1994/9-1998/6</td></tr>
                <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                    <td onclick ="Leo_toEdit(this)">北京航空航天大学</td>
                    <td onclick ="Leo_toEdit(this)">计算机学院</td>
                    <td onclick ="Leo_toEdit(this)">讲师</td>
                    <td onclick ="Leo_toEdit(this)">1998/9-2001/6</td></tr>
                <tr style="font-size:16px;text-align:center;line-height:26px;font-family:'微软雅黑'">
                    <td onclick ="Leo_toEdit(this)">北京航空航天大学</td>
                    <td onclick ="Leo_toEdit(this)">计算机学院</td>
                    <td onclick ="Leo_toEdit(this)">教授</td>
                    <td onclick ="Leo_toEdit(this)">2001/9-2004/6</td></tr>
                </table>
                <div id="Leo_add" style="width:86.5%;height:100%;text-align:right;"><img src="images/add.jpg" onclick="insertRow2()" value="增加一行"></div>
            </div>-->

        </div>
    </div>
  </div>
<footer></footer>
</body>
</html>

 <script type="text/javascript" language="javascript">
var curdate = new Date();
var year = document.getElementById("year");
var month = document.getElementById("month");
var day = document.getElementById("day");
//绑定年份月分的默认
function add() {
    var minyear = 1940;
    var maxyear = 2015;
    for (maxyear; maxyear >= minyear; maxyear = maxyear - 1) {
        year.options.add(new Option(maxyear, maxyear));
    }
    for (var mindex = 1; mindex <= 12; mindex++) {
        month.options.add(new Option(mindex, mindex));
    }
}
//判断是否是闰年
function leapyear(intyear) {
    var result = false;
    if (((intyear % 400 == 0) && (intyear % 100 != 0)) || (intyear % 4 == 0)) {
        result = true;
    }
    else {
        result = false;
    }
    return result;
}
//绑定天数
function addday(maxday) {
    day.options.length = 1;
    for (var dindex = 1; dindex <= maxday; dindex++) {
        day.options.add(new Option(dindex, dindex));
    }
}
function changeday() {
    if (year.value == null || year.value == "") {
        alert("请先选择年份！");
        return false;
    }
    else {
        if (month.value == 1 || month.value == 3 || month.value == 5 || month.value == 7 || month.value == 8 || month.value == 10 || month.value == 12) {
            addday(31);
        }
        else {
            if (month.value == 4 || month.value == 6 || month.value == 9 || month.value == 11) {
                addday(30);
            }
            else {
                if (leapyear(year.value)) {
                    addday(29);
                }
                else {
                    addday(28);
                }
            }
        }
    }
}
window.onload = add;


function Item_onBlur(Object,TxtObject){
    Object.style.width=20;
    Object.style.left=0;
    }

function Item_onMouseOver(Object){
    Object.style.width=140;
    Object.style.left=-120;
}

function Input_onchange(ObjSelect) {
    if( ObjSelect.id == "addselect" ) {
        addtxt.value = ObjSelect.value;
    }
    else if( ObjSelect.id == "addtxt" ) {
        addtxt.value = Rtrim(ObjSelect.value);
    }
    if( ObjSelect.options[ObjSelect.length-1].text == "没有找到！" ) {
        ObjSelect.options[ObjSelect.length-1] = null;
    }
}

function Leo_toEdit(t) {
    t.onclick = null;
    var content = t.innerText;
    t.innerText = "";
    var edit = document.createElement("input");
    edit.style.width = "90%";
    edit.type = "text";
    edit.value = content;
    edit.style.textAlign = "center";
    edit.onblur = new Function("Leo_exitEdit(this)");
    t.appendChild(edit);
    edit.focus();
    edit.select();

}

function Leo_exitEdit(t) {
    var content = t.value;
    var s = t.parentNode;
    s.removeChild(t);
    s.innerText = content;
    s.onclick = new Function("Leo_toEdit(this)");
    if (s.name == "td2") {
        checkEdtime(s, s.innerText);
    }
}

</script>