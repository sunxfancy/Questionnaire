// JavaScript source code
// JavaScript source code
function users(Num, Name, sex,  EdTime,pwd,result,FTF) {
    var div = document.createElement("div");
    
    if ($("Leo_project_body").lastChild) {
        if ($("Leo_project_body").lastChild.style.backgroundColor == "silver") {
            div.style.backgroundColor = "white";
           
        } else {
            div.style.backgroundColor = "silver";
        }
    }

    div.style.width = "99.5%";
    div.style.borderLeft = "2px solid silver";
    div.style.borderRight = "2px solid silver";

    div.id = Num;
    div.style.cursor = "pointer";

    var table = document.createElement("table");
    table.cellSpacing = "0";

    table.style.height = "30px";
    table.style.width = "100%";
    table.style.fontSize = "15px";
    table.style.textAlign = "center";
    table.style.margin = "0 auto";


    var tr = document.createElement("tr");
    tr.style.height = "100%";
    tr.style.verticalAlign = "middle";

    var tdDel = document.createElement("td");

    tdDel.style.width = "5%";
    var imgdel = document.createElement("img");
    imgdel.src = "../images/del.png";
	imgdel.style.width="20px";
    imgdel.style.height = "20px";
    tdDel.appendChild(imgdel);
    tdDel.onmouseover = new Function("this.style.color = 'red'");
    tdDel.onmouseout = new Function("this.style.color = 'black'");
    tdDel.onclick = new Function("Leo_deleteTduser(this)");

    var tdNum = document.createElement("td");
    tdNum.style.width = "10%";
    tdNum.innerText = Num;
    tdNum.style.textAlign = "center";
    tdNum.onclick = new Function("Leo_toEdit(this)");

    var tdName = document.createElement("td");
    tdName.style.width = "10%";
    tdName.innerText = Name;
    
    tdName.onclick = new Function("Leo_toEdit(this)");

    var tdsex = document.createElement("td");
    tdsex.style.width = "10%";
    tdsex.innerText = sex;
    tdsex.onclick = new Function("Leo_toEdit(this)");

    var tdisCom = document.createElement("td");
    tdisCom.style.width = "10%";
    if (parseInt(result)) {

        tdisCom.innerText = "是";
        tdisCom.style.color = "green";
    } else {
        tdisCom.innerText = "否";
        tdisCom.style.color = "red";

    }

    var tdEdtime = document.createElement("td");
    tdEdtime.style.width = "15%";
    tdEdtime.innerText = EdTime;
    
var tdPwd = document.createElement("td");
    tdPwd.style.width = "10%";
    tdPwd.innerText = pwd;
    tdPwd.onclick = new Function("Leo_toEdit(this)");

    var tdResult = document.createElement("td");
    tdResult.style.width = "10%";
    var newa;
    if (parseInt(result)) {
        newa= document.createElement("input");
        newa.type = "button";
        newa.onclick = new Function("window.open('../result.pdf')");
        newa.value = ">>";
        
    } else {
        newa = document.createElement("span");
        newa.innerText = "无结果";
        newa.style.color = "gray";

    }
    
   
    tdResult.appendChild(newa);
   
    var tdisComFTF = document.createElement("td");
    tdisComFTF.style.width = "10%";
    if (parseInt(FTF)) {

        tdisComFTF.innerText = "是";
        tdisComFTF.style.color = "green";
    } else {
        tdisComFTF.innerText = "否";
        tdisComFTF.style.color = "red";

    }

    var tdResultFTF = document.createElement("td");
    tdResultFTF.style.width = "10%";
    var newa;
    if (parseInt(FTF)) {
        newa = document.createElement("input");
        newa.type = "button";
        newa.onclick = new Function("window.open('Leo_personalResult.html')");
        newa.value = ">>";

    } else {
        newa = document.createElement("span");
        newa.innerText = "无结果";
        newa.style.color = "gray";

    }

    tdResultFTF.appendChild(newa);


    tr.appendChild(tdDel);
    tr.appendChild(tdNum);
    tr.appendChild(tdName);
    tr.appendChild(tdsex);
    tr.appendChild(tdisCom);
	tr.appendChild(tdResult);
    tr.appendChild(tdEdtime);
    tr.appendChild(tdPwd);
    tr.appendChild(tdisComFTF);
    tr.appendChild(tdResultFTF);
    

    table.appendChild(tr);
    div.appendChild(table);

    

    return div;
}

function leaders(Num, Name, sex, isComplete, EdTime, pwd) {
    var div = document.createElement("div");

    if ($("Leo_leaders_body").lastChild) {
        if ($("Leo_leaders_body").lastChild.style.backgroundColor == "silver") {
            div.style.backgroundColor = "white";

        } else {
            div.style.backgroundColor = "silver";
        }
    }

    div.style.width = "99.5%";
    div.style.borderLeft = "2px solid silver";
    div.style.borderRight = "2px solid silver";

    div.id = Num;
    div.style.cursor = "pointer";

    var table = document.createElement("table");
    table.cellSpacing = "0";

    table.style.height = "30px";
    table.style.width = "100%";
    table.style.fontSize = "15px";
    table.style.textAlign = "center";
    table.style.margin = "0 auto";


    var tr = document.createElement("tr");
    tr.style.height = "100%";
    tr.style.verticalAlign = "middle";

    var tdDel = document.createElement("td");
  
    tdDel.style.width = "5%";
    var imgdel = document.createElement("img");
    imgdel.src = "../images/del.png";
	imgdel.style.width="20px";
    imgdel.style.height = "20px";
    tdDel.appendChild(imgdel);
    tdDel.onmouseover = new Function("this.style.color = 'red'");
    tdDel.onmouseout = new Function("this.style.color = 'black'");
    tdDel.onclick = new Function("Leo_deleteTdleader(this)");
    
    tdDel.style.textAlign = "center";

    var tdNum = document.createElement("td");
    tdNum.onclick = new Function("Leo_toEdit(this)");
    tdNum.style.width = "15%";
    tdNum.innerText = Num;
    tdNum.style.textAlign = "center";

    var tdName = document.createElement("td");
    tdName.onclick = new Function("Leo_toEdit(this)");
    tdName.style.width = "15%";
    tdName.innerText = Name;

    var tdsex = document.createElement("td");
    tdsex.onclick = new Function("Leo_toEdit(this)");
    tdsex.style.width = "15%";
    tdsex.innerText = sex;

    

    var tdEdtime = document.createElement("td");
    tdEdtime.style.width = "25%";
    tdEdtime.innerText = EdTime;


    var tdPwd = document.createElement("td");
    tdPwd.onclick = new Function("Leo_toEdit(this)");
    tdPwd.style.width = "25%";
    tdPwd.innerText = pwd;

    



    tr.appendChild(tdDel);
    tr.appendChild(tdNum);
    tr.appendChild(tdName);
    tr.appendChild(tdsex);
   
    tr.appendChild(tdEdtime);
    tr.appendChild(tdPwd);

    table.appendChild(tr);
    div.appendChild(table);



    return div;
}

function zhuanjia(Num, Name, sex, EdTime, pwd,result) {
    var div = document.createElement("div");

    if ($("Leo_zhuanjia_body").lastChild) {
        if ($("Leo_zhuanjia_body").lastChild.style.backgroundColor == "silver") {
            div.style.backgroundColor = "white";

        } else {
            div.style.backgroundColor = "silver";
        }
    } else {
        div.style.backgroundColor = "white";
    }

    div.style.width = "99.5%";
    div.style.borderLeft = "2px solid silver";
    div.style.borderRight = "2px solid silver";

    div.id = Num;
    div.style.cursor = "pointer";

    var table = document.createElement("table");
    table.cellSpacing = "0";

    table.style.height = "30px";
    table.style.width = "100%";
    table.style.fontSize = "15px";
    table.style.textAlign = "center";
    table.style.margin = "0 auto";


    var tr = document.createElement("tr");
    tr.style.height = "100%";
    tr.style.verticalAlign = "middle";

    var tdDel = document.createElement("td");

    tdDel.style.width = "5%";
    var imgdel = document.createElement("img");
    imgdel.src = "../images/del.png";
	imgdel.style.width="20px";
    imgdel.style.height = "20px";
    tdDel.appendChild(imgdel);
    tdDel.onmouseover = new Function("this.style.color = 'red'");
    tdDel.onmouseout = new Function("this.style.color = 'black'");
    tdDel.onclick = new Function("Leo_deleteTdexpert(this)");

    var tdNum = document.createElement("td");
    tdNum.style.width = "10%";
    tdNum.innerText = Num;
    tdNum.style.textAlign = "center";
    tdNum.onclick = new Function("Leo_toEdit(this)");

    var tdName = document.createElement("td");
    tdName.style.width = "10%";
    tdName.innerText = Name;
    tdName.onclick = new Function("Leo_toEdit(this)");

    var tdsex = document.createElement("td");
    tdsex.style.width = "10%";
    tdsex.style.textAlign = "center";
    tdsex.innerText = sex;
    tdsex.onclick = new Function("Leo_toEdit(this)");

    

    var tdEdtime = document.createElement("td");
    tdEdtime.style.width = "20%";
    tdEdtime.innerText = EdTime;


    var tdPwd = document.createElement("td");
    tdPwd.style.width = "15%";
    tdPwd.innerText = pwd;
    tdPwd.onclick = new Function("Leo_toEdit(this)");

    var tdResult = document.createElement("td");
    tdResult.style.width = "15%";

    var tdisCom = document.createElement("td");
    tdisCom.style.width = "15%";
    if (parseInt(result)) {

        tdisCom.innerText = "完成";
    } else {
        tdisCom.innerText = "7/10";

    }


    var newa = document.createElement("input");
    newa.type = "button";
    newa.onclick = new Function("window.open('Leo_dividePeo.html')");
    newa.value = ">>";
    tdResult.appendChild(newa);
    
    

    tr.appendChild(tdDel);
    tr.appendChild(tdNum);
    tr.appendChild(tdName);
    tr.appendChild(tdsex);
   
    tr.appendChild(tdEdtime);
    tr.appendChild(tdPwd);
    tr.appendChild(tdisCom);
    tr.appendChild(tdResult);

    table.appendChild(tr);
    div.appendChild(table);



    return div;
}


function Leo_toEdit(t) {
    var boe=false;
    for (var i = 0; i < 3; i++) {
        if ($("editable_" + i).checked == true) {
            boe = true;
            break;
        }
    }

    if (boe) {

        
        t.onclick=null;
        var content = t.innerText;
        t.innerText = "";
        var edit = document.createElement("input");
        edit.style.width = "70%";
        edit.type = "text";
        edit.value = content;
        edit.style.textAlign = "center";
        edit.onblur = new Function("Leo_exitEdit(this)");
        t.appendChild(edit);
        edit.focus();
        edit.select();
    } else {
       
        if (t.parentNode.childNodes[1].innerText.substr(0, 2) == "us"&&t.parentNode.childNodes[2]==t) {
            window.open("test_info.html");
        }
    }

}

function Leo_exitEdit(t) {
    var content = t.value;
    var s = t.parentNode;
    s.removeChild(t);
    s.innerText = content;
    s.onclick = new Function("Leo_toEdit(this)");
    
}

function Leo_deleteTdleader(t) {
    var boe=false;
    for (var i = 0; i < 3; i++) {
        if ($("editable_" + i).checked == true) {
            boe = true;
            break;
        }
    }

    if (boe) {
        var boolt = confirm("确定删除" + t.parentNode.childNodes[2].innerText + "?");
        if (boolt) {
            var tem = new Array();
            var b = false;
            var l = Leaders_name.length;
            for (var i = 0; i < l; i++) {

                if (!b && Leaders_name[i].substr(0, 5) == t.parentNode.childNodes[1].innerText) {
                    b = true;
                }
                if (b) {
                    if (i != l - 1) { tem.push(Leaders_name[Leaders_name.length - 1]); }

                    Leaders_name.pop();
                }
            }

            if (!b) { alert("wrong"); }

            for (var i = 0; i < tem.length; i++) {
                Leaders_name.push(tem[tem.length - i - 1]);
            }

            initLeaders();
        }
    }

}

//这里的删除其实是存在问题的，按编号去进行删除，这个问题只能通过建立用户的查重机制来解决
function Leo_deleteTduser(t) {
    var boe=false;
    for (var i = 0; i < 3; i++) {
        if ($("editable_" + i).checked == true) {
            boe = true;
            break;
        }
    }

    if (boe) {
        var boolt = confirm("确定删除" + t.parentNode.childNodes[2].innerText + "?");
        if (boolt) {
            var tem = new Array();
            var b = false;
            var l = Users_name.length;
            for (var i = 0; i < l; i++) {

                if (!b && Users_name[i].substr(0, 5) == t.parentNode.childNodes[1].innerText) {
                    b = true;
                }
                if (b) {
                    if (i != l - 1) { tem.push(Users_name[Users_name.length - 1]); }

                    Users_name.pop();
                }
            }

            if (!b) { alert("wrong"); return; }

            for (var i = 0; i < tem.length; i++) {
                Users_name.push(tem[tem.length - i - 1]);
            }

            initusers();
        }
    }
	

}
function Leo_deleteTdexpert(t) {
    var boe=false;
    for (var i = 0; i < 3; i++) {
        if ($("editable_" + i).checked == true) {
            boe = true;
            break;
        }
    }

    if (boe) {
        var boolt = confirm("确定删除" + t.parentNode.childNodes[2].innerText + "?");
        if (boolt) {
            var tem = new Array();
            var b = false;
            var l = Experts_name.length;
            for (var i = 0; i < l; i++) {

                if (!b && Experts_name[i].substr(0, 5) == t.parentNode.childNodes[1].innerText) {
                    b = true;
                }
                if (b) {
                    if (i != l - 1) { tem.push(Experts_name[Experts_name.length - 1]); }

                    Experts_name.pop();
                }
            }

            if (!b) { alert("wrong"); }

            for (var i = 0; i < tem.length; i++) {
                Experts_name.push(tem[tem.length - i - 1]);
            }

            initexperts();
        }
    }

}