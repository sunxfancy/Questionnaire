﻿// JavaScript source code
// JavaScript source code
// JavaScript source code
function users(Num, Name, sex, result) {
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


    var tdNum = document.createElement("td");
    //tdNum.onclick = new Function("Leo_toEdit(this)");
    tdNum.style.width = "20%";
    tdNum.innerText = Num;
    tdNum.style.textAlign = "center";

    var tdName = document.createElement("td");
   // tdName.onclick = new Function("Leo_toEdit(this)");
    tdName.style.width = "20%";
    tdName.innerText = Name;

    var tdsex = document.createElement("td");
    //tdsex.onclick = new Function("Leo_toEdit(this)");
    tdsex.style.width = "10%";
    tdsex.innerText = sex;

    var tdisCom = document.createElement("td");
    tdisCom.style.width = "20%";
    if (parseInt(result)) {
        tdisCom.innerText = "是";
    } else {
        tdisCom.innerText = "否";
    }
    

   


    var tdResult = document.createElement("td");
    tdResult.style.width = "15%";

 /*   var newspan = document.createElement("span");



    if (parseInt(result)) {
        newspan.innerText = "Y";
        newspan.style.color = "green";

    } else {
        newspan.innerText = "N";
        newspan.style.color = "red";
    }
    tdResult.appendChild(newspan);*/
    
    if (parseInt(result)) {
        var newa = document.createElement("input");
        newa.type = "button";
        newa.onclick = new Function("window.open('../result.pdf');");
        newa.value = ">>";
        tdResult.appendChild(newa);

    } else {
        tdResult.innerText = '无结果';
        tdResult.style.color = 'gray';
    }
    
    var tdAdvice = document.createElement("td");
    tdAdvice.style.width = "15%";
    if (parseInt(result)) {
        var newa = document.createElement("input");
        newa.type = "button";
        newa.onclick = new Function("window.open('point.html');");
        newa.value = ">>";
        tdAdvice.appendChild(newa);

    } else {
        tdAdvice.innerText = '无结果';
        tdAdvice.style.color = 'gray';
    }


    tr.appendChild(tdNum);
    tr.appendChild(tdName);
    tr.appendChild(tdsex);
    tr.appendChild(tdisCom);
    
    tr.appendChild(tdResult);
    tr.appendChild(tdAdvice);

    table.appendChild(tr);
    div.appendChild(table);



    return div;
}





function Leo_toEdit(t) {
    t.onclick = null;
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

}

function Leo_exitEdit(t) {
    var content = t.value;
    var s = t.parentNode;
    s.removeChild(t);
    s.innerText = content;
    s.onclick = new Function("Leo_toEdit(this)");

}