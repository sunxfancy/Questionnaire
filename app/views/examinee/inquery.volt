<script type='text/javascript' src='/js/demand.js'></script>

  <div class="Leo_question_v2" id="Leo_question_v2">
        <div class="Leo_question_l" id="Leo_question_panel" style="margin-top:30px;"><div></div></div>
        <div id="Leo_control" style="width:600px;height:60px;text-align:center;">
            <table style="width:30%;height:60px;margin:0 auto;">
                <tr style="width:100%;height:100%;">
                    <td style="width:30%;">
                        <img style="height:40px;display:none;" id="Leo_pageup" src="../images/left.png" onclick="Leo_pageup_f()" />
                    </td>
                    <td style="width:30%;">
                        <img style="height: 40px;" id="Leo_pagedown" src="../images/right.png" onclick="Leo_pagedown_f()" />
                    </td>
                    <td style="width:30%;">
                        <img style="height: 40px;" id="Leo_signin" src="../images/signin.png" onclick="Leo_checkcomplete()" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="Leo_question_t_v2" style="height:500px;">
        <table style="width:92%;text-align:center;vertical-align:middle;table-layout:fixed;margin:0 auto;" id="Leo_question_table" cellspacing="0"></table>
    </div>
<script type="text/javascript">
    var questionlength=0;
    var Leo_now_index = 0;
    var question=new Array();
    init();
    function init(){
        $.post('/Examinee/getques', {'index': 0}, function(data) {
            /*optional stuff to do after success */
             if(!data.title){
                 alert("服务器不理我们了 0_0!");
                 return;
               }
            questionlength=data.ques_length;
            Leo_initPanel(questionlength);
            initCookie(questionlength,'ans_cookie'+{{number}});
        }); 
    }
   
    //将cookie中储存的第index个答案更新为new_ans, index 从0开始
   
    //显示题目
    function initTitle(data){
        var ans=data.options.split('|');
        var q = new Leo_question(data.index, data.title, data.is_multi, ans);
        document.getElementById("Leo_question_panel").removeChild(document.getElementById("Leo_question_panel").childNodes[0]);
        document.getElementById("Leo_question_panel").appendChild(q);
        if(questionlength!=data.ques_length){
            questionlength=data.ques_length;
            Leo_initPanel(questionlength);
        }
    }


function initTitle(index,is_multi){

    var option_disp="<div>";
    var op_type='radio';

    if(is_multi){
        op_type="checkbox";
    }

    var  option1="<div class='Leo_ans_div'><div class='Leo_ans_checkdiv'><input name='ans_sel' type='"+op_type+"' id='123' style='cursor:pointer;'/></div><div class='Leo_ans_checktext'>";
    var option2="</div></div>";

    var title='<span>'+(questions[index].index+1)+"."+questions[index].title+'</span>';
    
    var options=questions[index].options.split("|");

    for (var i = 0; i <options.length; i++) {
        option_disp+=option1+options[i]+option2;
        //option_disp+=option1+"A1A1"+option2;
    }
    option_disp+="</div>";
    
    $('#ans_div').children('div').replaceWith(option_disp);
    $('#title_div').html(title);

    $('.Leo_ans_checktext').click(function(){
        var temp=$(this).parent().children('div').children(':radio')[0];
        temp.checked=true;
        doclick();
    });

    $('input').click(function(){
        var temp=$(this).prop('checked','checked');
        doclick();
    })


    function doclick(){
        
        $('#newdiv_'+index).css('background-color', '#48fffb');
        if(Leo_index_now==done_index&&Leo_index_now!=questions.length-1){
            done_index=Leo_index_now+1;
        }
        if(Leo_index_now==questions.length-1){
            $("#Leo_checkup").css('display','');
            $("#Leo_checkup").unbind("click");
            $("#Leo_checkup").click(function(){
                changepage(questions.length-1,true);
                if(confirm("您确定要提交吗?")){
                   Leo_check();
                }
            })
        } 
        changepage(Leo_index_now+1,true);
    }

    $("#ans_div").css('width','100%');
    var ans_div_height=$("#title_div").outerHeight();
    if(ans_div_height<150){
        $("#ans_div").css('height',400-ans_div_height);
    }else{
        $("#title_div").css('height',150);
        $("#ans_div").css('height',250);
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
        $("#newdiv_" + name).css('background-color',"gray");
    } else {
        $("#newdiv_" + name).css('background-color',"green");
    }
}

function Leo_initPanel(questionlength) {
        $("#Leo_question_table").replaceWith("<table style='width:92%;text-align:center;vertical-align:middle;table-layout:fixed;margin:0 auto;' id='Leo_question_table' cellspacing='0'></table>");

        // $("#Leo_question_table").html("");

        var rows_count = Math.ceil(questionlength/ 5);
            for (var k = 0; k < rows_count; k++) {
                var row_now = document.getElementById("Leo_question_table").insertRow(k);
                if (k < rows_count - 1) {
                    for (var i = 0; i < 5; i++) {
                       set_td(i,k,row_now);
                    }
                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");
                } else {
                    for (var i = 0; i < questionlength- (rows_count - 1) * 5 ; i++) {
                        set_td(i,k,row_now);
                    }
                    for (var i = questionlength - (rows_count - 1) * 5; i < 5; i++) {
                        var cell_now = row_now.insertCell(i);
                    }
                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");
                }
            }
        function set_td(i,k,row_now){
            var cell_now = row_now.insertCell(i);
            var newdiv = document.createElement("div");
            newdiv.style.float = "left";
            newdiv.style.margin = "5px";
            newdiv.style.width = "40px";
            newdiv.style.height = "40px";
            newdiv.id = "newdiv_" + ( 5 * k + i);
            newdiv.name="ques_panel";
            newdiv.style.textAlign = "center";
            newdiv.style.cursor = "pointer";
            newdiv.style.backgroundColor = "gray";
            newdiv.textContent= ( 5 * k + i) + 1 + "";
            newdiv.innerText= ( 5 * k + i) + 1 + "";
            newdiv.style.fontSize = "21px";
            newdiv.tabIndex = "0";
            cell_now.appendChild(newdiv);
            newdiv.onclick=new Function("changepage(parseInt(this.innerText)-1,true);");
        }


    }
function get_ans_str(index){
    var ans_ori=document.getElementsByName(index);
        var ans_str="";
        for(var i=0;i<ans_ori.length;i++){
            if(ans_ori[i].checked){
                ans_str+=String.fromCharCode(i+97);
            }
        }
        if(ans_str==""){
            ans_str="0";
        }
        return ans_str;
}
function initCookie_title(ans_cookie){
        var ans_array=ans_cookie.split("|");
            var flag=true;
            for(var i=0;i<ans_array.length;i++){
                if(ans_array[i]=='0'){
                    if(flag){
                        changepage(i,false);
                        flag=false;
                    }
                }else{
                     $("#newdiv_" + i).css('background-color',"green");
                }
            }
            if(flag){
                changepage(ans_array.length-1,false);
            }
}
function get_ans_array_from_cookie(index){
    var ans_cookie=$.cookie('ans_cookie'+{{ number }});
    var ans_array=ans_cookie.split("|");
    var ans_ori=ans_array[index].split("");
    var ans_ori_array=new Array();
    if(ans_ori[0]!="0"){
        for(var i=0;i<ans_ori.length;i++){
            ans_ori_array[i]=ans_ori[i].charCodeAt()-97;
        }
    }
    return ans_ori_array;
}  
function changepage(newpage,isCookie) {
    //newpage为从0开始的计数方式

    var newpagejson={'index':newpage};
    $.post('/Examinee/getques',newpagejson,function(data) {
        /*optional stuff to do after success */
       if(!data.title){
        alert("服务器不理我们了 0_0!");
       }
       if(isCookie){
            var now_ans=get_ans_str(Leo_now_index);
            refreshCookie(Leo_now_index,now_ans,'ans_cookie'+{{number}});
        }
        Leo_now_index = newpage;
        initTitle(data);
        var ans=get_ans_array_from_cookie(newpage);
        var ans_ori=document.getElementsByName(newpage);
        for(var i=0;i<ans.length;i++){
             ans_ori[ans[i]].checked=true;
        }
        if (newpage == 0) {
            $("#Leo_pageup").css('display',"none");
        } else {
            $("#Leo_pageup").css('display',"");
        }
        if (newpage == questionlength - 1) {
            $("#Leo_pagedown").css('display',"none");
        } else {
            $("#Leo_pagedown").css('display',"");
        }
        $("#newdiv_" + newpage).focus();
    });
}


function getpaper(paper_index,url){

         $.post(url, {'paper_name':paper_id_name[paper_index]}, function(data) {
            if(data.no_ques){
                if(paper_id_now<5){
                    paper_id_now++;
                    $.cookie("paper_id"+{{number}},paper_id_now,{experies:7});
                    getpaper(paper_id_now);
                    return;
                }else{
                   ans_complete();
                   return;
                }
            }
         // $("#Leo_hiden_td").html("点击进行"+paper_name[paper_id_now]+"的答题");
         // $('#Leo_hiden').slideDown('fast', function() {});    //默认设定是题目间的跳转不暂停计时，这个过程被认为是正常的答题过程！！！
         questions=data.question;
         // description=data.description;
         // ques_order=data.order;
         Leo_initPanel(questions.length);
        initCookie(questions.length,"exam_ans"+{{number}});
        $('#announce_panel').children('p').replaceWith("<p>"+description+"</p>");
     });
}
</script>