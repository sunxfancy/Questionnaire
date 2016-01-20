<script type='text/javascript' src='/js/demand.js'></script>
<div class="Leo_question_v2" id="Leo_question_v2">       
    <div class="Leo_question_l" style="height:400px;" id="Leo_question_panel">
        <div style='width:95%;height:400px;margin:0 auto;'>
            <!--只需在代码中，对这一部分进行解析，替换，实现题目切换-->
            <div id="title_div" class="Leo_title_text" =''><span></span></div>
            <div id='ans_div' style="overflow:auto;font-family:'微软雅黑';">
                <div></div>
            </div>
        </div>
    </div>
        
    <div id="Leo_control" style="width:600px;height:60px;text-align:center;">
        <table style="width:30%;height:60px;margin:0 auto;">
            <tr style="width:100%;height:100%;"><td style="width:20%;">
                <img style="height:40px;display:none;" src="../images/left.png" id="Leo_pageup"/>
            </td><td style="width:20%;">
                <img style="height: 40px;" id="Leo_pagedown" src="../images/right.png" />
            </td><td style="width:20%;">
                <img style="height: 40px;" id="Leo_checkup" src="../images/signin.png"  />
            </td> <td style="width:20%;">
                <button style="height: 40px;;" id="Leo_All" value="全选A" />
            </td></tr>            
        </table>
    </div>
</div>  
       
<div class="Leo_question_t_v2" style="height:500px;margin-top:0px;">
    <div style="overflow:auto;height:500px;">
        <table style="width:92%;text-align:center;vertical-align:middle;table-layout:fixed;margin:0 auto;" id="Leo_question_table" cellspacing="0"></table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">提示信息</h4>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
    var spinner = null;
    var target = document.getElementById('Leo_question_v2');
    var questions=new Array();
    var url="/examinee/getInquery";
    var Leo_now_index=0;
$('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question_v2').css('width','600px')
});
$('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question_v2').css('width','600px')
});
$(function(){
	getpaper(url); //先从服务器取得全部的需求量表的题目
	$('.Leo_question_v2').css('width','600px');
	 $("#Leo_All").click(function(){
         var ans=new Array();
         for(var i=0;i<questions.length;i++){
             ans[i]="a";
         }
         $.cookie("ans_cookie"+<?php echo $number; ?>, ans.join("|"), {experies:7});
         initCookie(questions.length,"ans_cookie"+<?php echo $number; ?> );
     });
  

     $("#Leo_pagedown").click(function(){
        changepage(Leo_now_index+1,true);
     });

     $("#Leo_pageup").click(function(){
         changepage(Leo_now_index-1,true);
     });

     $("#Leo_checkup").click(function(){
                changepage(questions.length-1,true);
                Leo_checkcomplete();
            });
});
    
   
function initTitle(index){

    var option_disp="<div>";
    var op_type='radio';
    if(questions[index].is_multi){
        op_type="checkbox";
    }

    var  option1="<div class='Leo_ans_div'><div class='Leo_ans_checkdiv'><input name='ans_sel' type='"+op_type+"' id='123' style='cursor:pointer;'/></div><div class='Leo_ans_checktext'>";
    var option2="</div></div>";

    var title='<span>'+(questions[index].index)+"."+questions[index].title+'</span>';
    
    var options=questions[index].options.split("|");

    for (var i = 0; i <options.length; i++) {
        option_disp+=option1+options[i]+option2;
        //option_disp+=option1+"A1A1"+option2;
    }
    option_disp+="</div>";
    
    $('#ans_div').children('div').replaceWith(option_disp);
    $('#title_div').html(title);

    $('.Leo_ans_checktext').click(function(){

        var temp=$(this).parent().children('div').children(':checkbox')[0];
        if(temp){

            //这里处理是否可以选择，以及让input响应选择
            if(temp.checked||checkOver3()){
                temp.checked=!temp.checked;
                doclick();
            }else{
                $(this).prop('checked', '');
                $('.Leo_question_v2').css('width','573px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+ "您的选择已经超过三项，请确认你的选择。"+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">继续答题</button>"
                    );
                 
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 }); 
                //alert("您的选择已经超过三项，请确认你的选择。666"); 
            }
        }else{
            temp=$(this).parent().children('div').children(':radio')[0];
            temp.checked=true;
            $("#newdiv_"+Leo_now_index).css('background-color', '#48fffb');
            changepage(Leo_now_index+1,true);
        }
        
    });

    $('input').click(function(){
       if($(this).attr('type')=="checkbox"){
            if($(this).attr('checked')=="checked"||checkOver3()){
                doclick();
            }else{
                $(this).prop('checked', '');
                 $('.Leo_question_v2').css('width','573px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+ "您的选择已经超过三项，请确认你的选择。"+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">继续答题</button>"
                    );
                 
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 }); 
               // alert("您的选择已经超过三项，请确认你的选择。");
            }
       }else{
            $(this).prop('checked', 'checked');
            $("#newdiv_"+Leo_now_index).css('background-color', '#48fffb');
            changepage(Leo_now_index+1,true);
        }
    });


    function doclick(){
        checkcheckbox();
        var now_ans=get_ans_str();
        refreshCookie(Leo_now_index,now_ans,'ans_cookie'+<?php echo $number; ?>);
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

function checkcheckbox() {
    var b = false;
    var e = $(":checkbox");
    for (var i = 0; i < e.length; i++) {
        if (e[i].checked) {
            b = true;
        }
    }
    if (!b) {
        $("#newdiv_" + Leo_now_index).css('background-color',"gray");
    } else {
        $("#newdiv_" + Leo_now_index).css('background-color',"#48fffb");
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
/*本方法读取学前页面上的checkbox,返回取选择出的选项所对应的罗马字母*/
function get_ans_str(){
    var ans_ori=document.getElementsByTagName("input");
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
/*the End of function*/
/*本方法从cookie中读取记录，返回一个数组，是被选中的选项的索引，从0开始*/
function get_ans_array_from_cookie(index){
    var ans_cookie=$.cookie('ans_cookie'+<?php echo $number; ?>);
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
                     $("#newdiv_" + i).css('background-color',"#48fffb");
                }
            }
            if(flag){
                changepage(ans_array.length-1,false);
            }
}
 
function changepage(newpage,isCookie) {
    //newpage为从0开始的计数方式
    //这里可以改变为每进行一次点击就更新一次cookie
       if(isCookie){
            var now_ans=get_ans_str();
            refreshCookie(Leo_now_index,now_ans,'ans_cookie'+<?php echo $number; ?>);
        }
        Leo_now_index = newpage;
        initTitle(newpage);
        var ans=get_ans_array_from_cookie(newpage);
        var ans_ori=$("input");
        for(var i=0;i<ans.length;i++){
             ans_ori[ans[i]].checked=true;
        }
        if (newpage == 0) {
            $("#Leo_pageup").css('display',"none");
        } else {
            $("#Leo_pageup").css('display',"");
        }
        if (newpage == questions.length - 1) {
            $("#Leo_pagedown").css('display',"none");
        } else {
            $("#Leo_pagedown").css('display',"");
        }
        $("#newdiv_" + newpage).focus();
    
}
function Leo_checkcomplete() {
        var now_ans=get_ans_str(Leo_now_index);
        refreshCookie(Leo_now_index,now_ans,"ans_cookie"+<?php echo $number; ?>);
        var badques = new Array();
        for (var i = 0; i < questions.length; i++) {
            if (document.getElementById("newdiv_" + i).style.backgroundColor=='gray') {
                badques.push((i + 1));
            }
        }
        if (badques.length != 0) {
        	$('.Leo_question_v2').css('width','573px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+"您的答题是不完整的，其中第" + badques + "题缺少必要的答案！请继续答题！"+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">继续答题</button>"
                    );
                 
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
            //alert("您的答题是不完整的，其中第" + badques + "题缺少必要的答案！请继续答题！");
                changepage(badques[0] - 1,true);
            
        } else {
        	     $('.Leo_question_v2').css('width','573px')
        	     $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+"您确定要提交吗?"+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-info\" data-dismiss=\"modal\">返回修改</button>"
                    +"<button type=\"button\" class=\"btn btn-primary\"  onclick=\"Leo_check();\">确认提交</button>"
                    );
                 
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
        }
    }


function getpaper(url){
	     spinner = new Spinner().spin(target);
         $.post(url, {'paper_name':"inquery"}, function(data) {
         	if(data.error){
         		 if(spinner){ spinner.stop(); }
         		 $('.Leo_question_v2').css('width','573px')
         		 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                 	"<a href='/examinee/inquery'><button type=\"button\" class=\"btn btn-primary\">刷新</button></a>"+
                 	"&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-primary\" onclick=\"w_last();\">退出</button>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
         	}else{
         		 if(spinner){ spinner.stop(); }
         		 $('.Leo_question_v2').css('width','600px');
         		 questions=data.question;
                 Leo_initPanel(questions.length);
                 initCookie(questions.length,"ans_cookie"+<?php echo $number; ?>);
         	}
           
        });
}

function Leo_check(){
	spinner = new Spinner().spin(target);
    $.post('/examinee/getInqueryAns',{"answer":$.cookie("ans_cookie"+<?php echo $number; ?>)}, function(data) {
            if(data.error){
            	 if(spinner){ spinner.stop(); }
                 $('.Leo_question_v2').css('width','573px');
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+ data.error + "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" click='Lea_check();'>重新提交</button>"
                    // +"&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-primary\" onclick=\"w_last();\">退出</button>"
                  );
                 
                 $('#myModal').modal({
                        keyboard:true,
                        backdrop:'static'
                 })
            }else{
            	if(spinner){ spinner.stop(); }
            	$('.Leo_question_v2').css('width','573px');
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-success\" style='padding:20px;'>"+ "提交成功！点击确定跳转到用户信息填写页面！"+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-success\" onclick='wang_click();'>确定</button>"
                    );
                 
                 $('#myModal').modal({
                        keyboard:true,
                        backdrop:'static'
                 });
            }
        });
}
function w_last(){
	 $.cookie("ans_cookie"+<?php echo $number; ?>,"",{expires:-1});
     window.location.href='/';
}
function wang_click(){
	   $.cookie("ans_cookie"+<?php echo $number; ?>,"",{expires:-1});
	   window.location.href='/examinee/editinfo';
}
</script>