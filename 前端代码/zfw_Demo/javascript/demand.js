// JavaScript source code
function Leo_question(index_i, que, kind, ans) {
    this.index = index_i;
    this.ques = que;
    this.Items;
    var question_panel;
    init();


    return question_panel;


    function init() {

        question_panel = document.createElement("div");
        //question_panel.style.backgroundColor = "green";
        question_panel.style.width = "90%";
        question_panel.style.height = "95%";

        question_panel.style.margin = "0 auto";



        var newspan = document.createElement("span");
        newspan.style.width = "100%";
        newspan.style.height = "80px";
        newspan.innerText = (index_i + 1) + "." + que;
        newspan.style.fontWeight = "normal";
        newspan.style.fontSize = "28px";
        newspan.style.display = "block";


        question_panel.appendChild(newspan);

        if (kind) {
            initRadio();
        } else {
            initCheckBox();
        }

    }


    function initRadio() {
        /*这一套用ul 包li的方法，用起来不是很方便，定位也有问题
        var newUl = document.createElement("ul");
        newUl.style.listStyle = "none";
        newUl.style.width = "100%";
        newUl.style.marginLeft = "0px";
        for (var i = 0; i < ans.length ; i++) {
            var newli = document.createElement("li");


            var newbaodiv = document.createElement("div");//做一个div把选项包起来
                var newRadio = document.createElement("input");
                newRadio.type = "radio";
                newRadio.name = index_i + "";
               newRadio.onclick = new Function("Leo_clickRadio(this);");
               var newspan = document.createElement("span");
               newbaodiv.style.width = "100%";
               newbaodiv.style.backgroundColor = "red";
               newbaodiv.style.height = "30px";

           
            newspan.innerText = ans[i];
            newbaodiv.appendChild(newRadio);
            newbaodiv.appendChild(newspan);
            newli.appendChild(newbaodiv);
            newUl.appendChild(newli);
            */
			var overdiv=document.createElement("div");
			overdiv.style.overflow="auto";
			overdiv.style.height="330px";
        for (var i = 0; i < ans.length ; i++) {
            var answersdiv = document.createElement("div");
            var newRadio = document.createElement("input");
            newRadio.type = "radio";
            newRadio.name = index_i + "";

            var newspan = document.createElement("span");
            answersdiv.style.width = "100%";
            newspan.style.fontSize = "22px";
            answersdiv.style.height = "30px";
            newspan.innerText = ans[i];
            answersdiv.appendChild(newRadio);
            answersdiv.appendChild(newspan);
            answersdiv.style.cursor = "pointer";
            answersdiv.style.marginTop = "15px";
            answersdiv.onclick = new Function("this.childNodes[0].checked=true;Leo_clickRadio(this.childNodes[0]);");
            answersdiv.onmouseover = new Function("this.style.backgroundColor='silver'");
            answersdiv.onmouseout = new Function("this.style.backgroundColor='white'");
            overdiv.appendChild(answersdiv);
        }

		question_panel.appendChild(overdiv);


    }
    function initCheckBox() {
        /*
        var newUl = document.createElement("ul");
        newUl.style.listStyle = "none";
        for (var i = 0; i < ans.length ; i++) {
            var newli = document.createElement("li");
            var newRadio = document.createElement("input");
            newRadio.type = "checkbox";
            newRadio.name = index_i + "";
            newRadio.onclick = new Function("changeColor(this);checkcheckbox(this.name)");
            var newspan = document.createElement("span");


            newspan.innerText = ans[i];
            newli.appendChild(newRadio);
            newli.appendChild(newspan);
            newUl.appendChild(newli);



        }

        question_panel.appendChild(newUl);*/

			var overdiv=document.createElement("div");
			overdiv.style.overflow="auto";
			overdiv.style.height="330px";
        for (var i = 0; i < ans.length ; i++) {
            var answersdiv = document.createElement("div");
            var newRadio = document.createElement("input");
            newRadio.type = "checkbox";
            newRadio.name = index_i + "";

            var newspan = document.createElement("span");
            answersdiv.style.width = "100%";
            newspan.style.fontSize = "22px";
            answersdiv.style.height = "auto";
            newspan.innerText = ans[i];
            answersdiv.appendChild(newRadio);
            answersdiv.appendChild(newspan);
            answersdiv.style.cursor = "pointer";
            answersdiv.style.marginTop = "15px";
            //answersdiv.onclick = new Function("this.childNodes[0].checked=!this.childNodes[0].checked;checkcheckbox(this.childNodes[0].name)");
            answersdiv.onclick = new Function("clickCheckBox(this)");
            answersdiv.onmouseover = new Function("this.style.backgroundColor='silver'");
            answersdiv.onmouseout = new Function("this.style.backgroundColor='white'");
            overdiv.appendChild(answersdiv);
        }
question_panel.appendChild(overdiv);

    }
}








function Leo_pagedown() {

    if (Leo_now_index == questions.length - 1) {
        Leo_checkcomplete();
    } else if (Leo_now_index < questions.length - 1) {

        changepage(Leo_now_index + 1);
    }

   
    //这里答题希望一套一套来答，还是提示只出现一次


}

function changepage(newpage) {
    //newpage为从0开始的计数方式
    $("Leo_question_panel").removeChild($("Leo_question_panel").childNodes[0]);
    Leo_now_index = newpage;
    $("Leo_question_panel").appendChild(questions[Leo_now_index]);

    if (newpage == 0) {
        $("Leo_pageup").style.display = "none";
    } else {
        $("Leo_pageup").style.display = "";
    }

    if (newpage == questions.length - 1) {
       
        $("Leo_pagedown").style.display = "none";
    } else {
        $("Leo_pagedown").style.display = "";
    }

    $("newdiv_" + newpage).focus();


}



function Leo_pageup() {

    if (Leo_now_index > 0) {
        changepage(Leo_now_index - 1);
    }
}
function Leo_clickRadio(t) {

    changeColor(t);
    if (Leo_now_index != questions.length - 1) {
        Leo_pagedown();

    } else {

        $("Leo_pagedown").style.display = "";

    }

}

function changeColor(t) {
    $("newdiv_" + t.name).style.backgroundColor = "green";

    var f = parseInt(t.name);
   
}

function checkcheckbox(name) {
    var b = false;
    var e = document.getElementsByName(name);
    for (var i = 0; i < e.length; i++) {
        if (e[i].checked) {
            b = true;
        }
    }


    if (!b) {
        $("newdiv_" + name).style.backgroundColor = "gray";
    } else {
        $("newdiv_" + name).style.backgroundColor = "green";
    }
}

function checkOver3(name) {
    var b = 0;
    var e = document.getElementsByName(name);
    for (var i = 0; i < e.length; i++) {
        if (e[i].checked) {
            b ++;
        }
    }

    if (b >= 3) {
        return false;
    } else {
        return true;
    }
}

function clickCheckBox(t) {
    if (t.childNodes[0].checked) {
        t.childNodes[0].checked = !t.childNodes[0].checked;
        checkcheckbox(t.childNodes[0].name);
    }else if (checkOver3(t.childNodes[0].name)) {
        t.childNodes[0].checked = !t.childNodes[0].checked;
        checkcheckbox(t.childNodes[0].name);
    } else {
        alert("您的选择已超过三项！请确认您的选择！");
    }

    

}







