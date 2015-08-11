<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>

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

            a.style.width = "150px";
            b.style.width = "150px";
            c.style.width = "150px";
            d.style.width = "150px";
            e.style.width = "35px";

            a.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:33px;font-family:"微软雅黑";">';
            b.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:33px;font-family:"微软雅黑";">';
            c.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:33px;font-family:"微软雅黑";">';
            d.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:33px;font-family:"微软雅黑";">';
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

            a.style.width = "150px";
            b.style.width = "150px";
            c.style.width = "150px";
            d.style.width = "150px";
            e.style.width = "35px";

            a.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:33px;font-family:"微软雅黑";">';
            b.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:33px;font-family:"微软雅黑";">';
            c.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:33px;font-family:"微软雅黑";">';
            d.innerHTML='<input name="text" type="name" class="inputtxt" style="border:0px;height:33px;font-family:"微软雅黑";">';
            e.innerHTML='<img src="../images/del.jpg" value="删除" onclick="deleteRow2(this)">';
        }
        function deleteRow2(r){
           count2--;
           var i=r.parentNode.parentNode.rowIndex;
           document.getElementById('myTable2').deleteRow(i);
        }
</script>

<div class="Leo_question">
    <div class="baseinfo" style="width:100%;height:100%;">
        <div style="overflow:auto;height:440px;">
            <div style="height:40px;text-align:center;font-size:28px;">基本信息</div>
            <table border="1" cellspacing="0" cellpadding="0" style="margin:0 auto;font-size:16px; font-family:'微软雅黑'">
                <tr>
                    <td style="width:120px;line-height:33px;">姓名</td>
                    <td style="width:180px;" onclick="Leo_toEdit(this)">{{ name }}</td>
                    <td style="width:120px;line-height:33px;">性别</td>
                    <td style="width: 180px;" onclick="Leo_toEdit(this)">{{ sex }}</td>
                </tr>
                <tr>
                    <td style="width:120px;line-height:33px;">学历</td>
                    <td style="width:180px;">
                        <select style="width:178px;font-size:16px;line-height:28px;font-family:'微软雅黑'">
                            <option value="">{{ education }}</option>
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
                    <td style=" width:120px;line-height:33px;">学位</td>
                    <td id="degree" style="width:180px;">
                        <select style="width:178px;font-size:16px;line-height:28px; font-family:'微软雅黑'">
                            <option value="">{{ degree }}</option>
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
                    <td style=" width:120px;line-height:33px;">出生年月</td>
                    <td style="width:180px;">
                        <div class="input-append date form_datetime">
                            <input id="birthday" type="text" value="" readonly style="width:178px;height:31px;">
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </td>
                    <td style=" width:120px;line-height:33px;">籍贯</td>
                    <td style="width:180px;">
                        <select style="width:178px;font-size:16px;line-height:28px; font-family:'微软雅黑'">
                            <option value="">{{ native }}</option>
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
                    </td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">政治面貌</td>
                    <td style="width:180px;">
                        <select style="width:178px;font-size:16px;line-height:28px;font-family:'微软雅黑'">
                            <option value="">{{ politics }}</option>
                            <option value="无">无党派</option>
                            <option value="团员">团员</option>
                            <option value="党员">党员</option>
                            <option value="群众">群众</option>
                            <option value="民主党派">民主党派</option>
                        </select>
                    </td>
                    <td style=" width:120px;line-height:33px;">职称</td>
                    <td style="width:180px;">
                        <select style="width:178px;font-size:16px;line-height:28px;font-family:'微软雅黑'">
                            <option value="空">{{ professional }}</option>
                            <option value="无职称">无职称</option>
                            <option value="初级">初级</option>
                            <option value="中级">中级</option>
                            <option value="副高职">副高职</option>
                            <option value="正高职">正高职</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">工作单位</td>
                    <td colspan="3" style=" width:180px;font-size:16px;" onclick="Leo_toEdit(this)">{{ employer }}</td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">部门</td>
                    <td colspan="3" style="width: 180px; font-size: 16px;" onclick="Leo_toEdit(this)">{{ unit }}</td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">岗位/职务</td>
                    <td colspan="3" style="width: 180px; font-size: 16px;" onclick="Leo_toEdit(this)">{{ duty }}</td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">班子/系统成员</td>
                    <td colspan="3" style="width: 180px; font-size: 16px;" onclick="Leo_toEdit(this)">{{ team }}</td>
                </tr>
            </table>
            <div style="height:40px;text-align:center;font-size:28px;">教育经历</div>
            <table id="myTable1" style="margin: 0 auto;text-align:center; font-family:'微软雅黑'" border="1" cellspacing="0" cellpadding="1" >
                <tr>
                    <td style=" width:150px;line-height:33px;">毕业院校</td>
                    <td style=" width:150px;line-height:33px;">专业</td>
                    <td style=" width:150px;line-height:33px;">所获学位</td>
                    <td style=" width:150px;line-height:33px;">时间</td>
                </tr>
                <tr style="font-size:16px;text-align:center;line-height:33px;font-family:'微软雅黑'">
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                </tr>
                <tr style="font-size:16px;text-align:center;line-height:33px;font-family:'微软雅黑'">
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                </tr>
            </table>
			<div id="Leo_add" style="width:86.5%;height:50px;margin:0 auto;;text-align:center;">
                <input type='button' value='增加一行' onclick="insertRow1()" >
            </div>
            <div style="height:40px;text-align:center;font-size:28px;">工作经历</div>
            <table id="myTable2" border="1"cellspacing="0" cellpadding="0" style="margin: 0 auto;text-align:center;font-family:'微软雅黑' ">
                <tr>
                    <td style=" width:150px;line-height:32px;">就职单位</td>
                    <td style=" width:150px;line-height:32px;">部门</td>
                    <td style=" width:150px;line-height:32px;">岗位/职务</td>
                    <td style=" width:150px;line-height:32px;">起止时间</td>
                </tr>
                <tr style="font-size:16px;text-align:center;line-height:33px;font-family:'微软雅黑'">
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                </tr>
                <tr style="font-size:16px;text-align:center;line-height:33px;font-family:'微软雅黑'">
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                </tr>
                <tr style="font-size:16px;text-align:center;line-height:33px;font-family:'微软雅黑'">
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                    <td style="width:150px;" onclick="Leo_toEdit(this)"></td>
                </tr>
            </table>

			<div id="Leo_add" style="width:86.5%;height:50px;margin:0 auto;;text-align:center;">
                <input type='button' value='增加一行' onclick="insertRow2()" >
            </div>
            <div class="submit" style="display:block;text-align:center;margin-top:15px;">
                <img src="../images/submit.jpg" type="submit" onclick="window.location.href='Leo_examination.html'" />
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    $(".form_datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

window.onload = add;

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
