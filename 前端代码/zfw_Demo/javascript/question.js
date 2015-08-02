// JavaScript source code
function Leo_question(index_i,que,kind,ans) {
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
        question_panel.style.height = "400px";
       
      
        question_panel.style.margin = "0 auto";
        

        
        var newspan = document.createElement("span");
        newspan.style.width = "100%";
        newspan.style.height = "70px";
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
        var overdiv = document.createElement("div");
        overdiv.style.height = "330px";
			overdiv.style.overflow="auto";
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

        question_panel.appendChild(newUl);


    }
}

var Leo_total_seconds = 0;

function Leo_Timer() {
    this.Inter = 0;
    this.Start = function () {

        this.Inter= setInterval(function(){
            Leo_total_seconds++;
            Leo_refreshSpan();
        },1000);
    }

    this.Pause=function(Inter){
        clearInterval(this.Inter);
    }

    function Leo_refreshSpan() {
        var sec = Leo_total_seconds % 60;
        var min = ((Leo_total_seconds - sec) / 60) % 60;
        var hour = (Leo_total_seconds - sec - min * 60) / 3600;
        //$("Leo_timer").innerText = "已用时:" + hour + "时" + min + "分" + sec + "秒";
        if (hour < 10) {
            hour = "0" + hour;
        }
        if (min < 10) {
            min = "0" + min;
        }
        if (sec < 10) {
            sec = "0" + sec;
        }
        $("hour").innerText = hour + "";
        $("minute").innerText = min + "";
        $("second").innerText = sec + "";

    }
}

var Leo_t = new Leo_Timer();


function Leo_pagedown() {

    if (Leo_now_index == questions.length - 1) {
        Leo_checkcomplete();
    } else if (Leo_now_index < questions.length - 1) {
        
        changepage(Leo_now_index + 1);
    }

    for (var i = 0; i < classdetail.length; i++) {

        if (Leo_now_index == class1[i]) {

            $("Leo_hiden_td").innerText = classdetail[i];
            Leo_pauseDoques();
        }
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

    if (newpage != questions.length - 1) {
        //$("Leo_pagedown").style.display = "none";   //这个地方在返回上一题目时是否隐藏提交按钮，视需求而定
		
        if($("newdiv_" + newpage).style.backgroundColor=="green"){
			$("Leo_pagedown_next").style.display="";
		}else{
			$("Leo_pagedown_next").style.display="none";
		}
    } else {
        
		$("Leo_pagedown_next").style.display="none";
	}

	

    for (var i = 0; i < classdetail.length - 1; i++) {
        
        if (newpage < class1[i + 1]) {
            //$("classInfo").innerText = classdetail[i].substr(6, classdetail[i].length - 6);
            $("classInfo").innerText = classdetail[i];
            break;
        }
    }
    if (newpage >= class1[classdetail.length - 1]) {
        //$("classInfo").innerText = classdetail[classdetail.length - 1].substr(6, classdetail[classdetail.length - 1].length - 6);
        $("classInfo").innerText = classdetail[classdetail.length - 1];
    }
    
    $("newdiv_" + newpage).focus();
    

}



function Leo_pageup() {

    if (Leo_now_index > 0) {
        changepage(Leo_now_index - 1);
    }
}

//var nowTime=0;
function Leo_clickRadio(t) {
    
    changeColor(t);
    if (Leo_now_index != questions.length - 1) {
		
		//clearTimeout(nowTime);
        //nowTime=setTimeout("Leo_pagedown()",1000);
        Leo_pagedown();
    } else {
       
        $("Leo_pagedown").style.display = "";
        
    }
   
}

function changeColor(t) {
    $("newdiv_" + t.name).style.backgroundColor = "green";
    
    var f = parseInt(t.name);
    if ($("newdiv_" + (f+1))){
        $("newdiv_" + (f+1)).onclick = new Function("changepage(parseInt(this.innerText)-1)");
    }
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
        $("newdiv_" + name).style.backgroundColor = "green";
    }
}

function Leo_doques() {
    
    Leo_div_scroll(true);
    Leo_t.Start();
}

function Leo_div_scroll(dir) {

    $("Leo_hiden_ctrl").onclick = null;
    $("Leo_pause").onclick = null;

    var i = 30;
    var last_top = $("Leo_hiden").style.top;
    last_top=last_top.substr(0,last_top.length-2);
    last_top = parseInt(last_top);
    var new_top = last_top;

    doscroll(dir);
    
    
    function doscroll(ldir) {
        if (ldir) {
            if (new_top > last_top - 500) {
                setTimeout(function () {
                    new_top -= i;
                    doscroll(dir);
                    $("Leo_hiden").style.top = new_top + "px";
                    }, 20)
            } else {
                $("Leo_hiden").style.top = (last_top - 500) + "px";
                $("Leo_hiden_ctrl").onclick = new Function("Leo_doques()");
                $("Leo_pause").onclick = new Function("pause()");
            }
        } else {
            if (new_top < last_top + 500) {
                setTimeout(function () {
                    new_top += i;
                    doscroll(dir);
                    $("Leo_hiden").style.top = new_top + "px";
                }, 20)
            } else {
                $("Leo_hiden").style.top = (last_top + 500) + "px";
                $("Leo_hiden_ctrl").onclick = new Function("Leo_doques()");
                $("Leo_pause").onclick = new Function("pause()");
            }
        }
    }
}

function Leo_pauseDoques() {
    
    Leo_div_scroll(false);
    Leo_t.Pause();
   
}

function pause() {
    $("Leo_hiden_td").innerText = "单击继续答题";
    Leo_pauseDoques();
}
