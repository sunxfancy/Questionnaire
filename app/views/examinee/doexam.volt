
<div class="Leo_question_v2" id="Leo_question_v2">
        <div style="overflow:hidden;width:600px;height:440px;">
        <div style="width:95%;height:410px;margin:0 auto;display:none;font-size:25px;font-family:'微软雅黑'" id='announce_panel'><p></p></div>
        <div id='do_announce' style="width:100%;height:30px;background-color:#eeed6a;cursor:pointer;"></div>
        <div class="Leo_question_l" style="height:400px;" id="Leo_question_panel">
        <div style='width:95%;height:400px;margin:0 auto;'>
        <div id="title_div" class="Leo_title_text" =''><span></span></div>

            <!--只需在代码中，对这一部分进行解析，替换，实现题目切换-->
        <div id='ans_div' style="overflow:auto;font-family:'微软雅黑';">
        <div><div class='Leo_ans_div'><div class='Leo_ans_checkdiv'><input name='ans_sel' type='radio' id='123' style='cursor:pointer;'/></div><div class='Leo_ans_checktext'>测验包括许多问题和选择，任何答案选择都无所谓对错，对测验包括许多问题和选择，任何答案选择都无所谓对错，对测验包括许多问题和选择，任何答案选择都无所谓对错，对</div></div>
               <div class='Leo_ans_div'><div class='Leo_ans_checkdiv'><input name='ans_sel' type='radio' id='123' style='cursor:pointer;'' /></div><div class='Leo_ans_checktext'>测验包括许多问题和选择，任何答案选择都无所谓对错，对</div></div>
                <div class='Leo_ans_div'><div class='Leo_ans_checkdiv'><input name='ans_sel' type='radio' id='123' style='cursor:pointer;'' /></div><div class='Leo_ans_checktext'>测验包括许多问题和选择，任何答案选择都无所谓对错，对</div></div>
                 <div class='Leo_ans_div'><div class='Leo_ans_checkdiv'><input name='ans_sel' type='radio' id='123' style='cursor:pointer;'' /></div><div class='Leo_ans_checktext'>测验包括许多问题和选择，任何答案选择都无所谓对错，对</div></div>
                  <div class='Leo_ans_div'><div class='Leo_ans_checkdiv'><input name='ans_sel' type='radio' id='123' style='cursor:pointer;'' /></div><div class='Leo_ans_checktext'>测验包括许多问题和选择，任何答案选择都无所谓对错，对</div></div>
               </div>
        </div>
        </div>
        </div>
        </div>
        
        <div id="Leo_control" style="width:600px;height:60px;text-align:center;">
            <table style="width:30%;height:60px;margin:0 auto;"><tr style="width:100%;height:100%;"><td style="width:25%;">
                           <img style="height:40px;display:none;" src="../images/left.png" id="Leo_pageup" onclick="Leo_pageup()" />

                </td><td style="width:25%;">
                            <img style="height:40px" src="../images/pause.png" onclick="pause()" id="Leo_pause" />

                </td><td style="width:25%;">
                            <img style="height: 40px;display:none" id="Leo_pagedown_next" src="../images/right.png" onclick="Leo_pagedown()" />

                </td><td style="width:25%;">
                            <img style="height: 40px; display: none;" id="Leo_pagedown" src="../images/signin.png" onclick="changepage(questions.length - 1); Leo_pagedown();" />

                </td></tr>
            
            </table>

        </div>

        <div id="Leo_hiden" class="Leo_hiden" style="top:-500px;" >
		<table style="height:100%;width:100%;text-align:center;vertical-align:middle;">
		<tr><td id="Leo_hiden_td" style="font-size:18px;text-align:left;"></td></tr>
		<tr><td id="Leo_hiden_td2"><div id="Leo_hiden_ctrl" style="cursor:pointer;margin-left:45%;width:0;height:0;border-top: 30px solid transparent;border-bottom:30px solid transparent;border-left:50px solid green;" onclick="Leo_doques()"></div><br /></td></tr></table></div>
    </div>
    <div class="Leo_Timer_v2">
    <div style="width:100%;height:30px;background-color:#eeed6a;"></div>

    <div class="clock">
    <ul><li style="font-size:25px;">已用时</li></ul>
    <ul>
    <li id="hours">00</li>
        <li id="point">:</li>
        <li id="min">00</li>
        <li id="point">:</li>
        <li id="sec">00</li>
    </ul>
    </div>
    
    </div>
    <div class="Leo_question_t_v2">
        
        <div style="overflow:auto;height:340px;">
            <table style="width:92%;text-align:center;vertical-align:middle;table-layout:fixed;margin:0 auto;" id="Leo_question_table" cellspacing="0"></table>
        </div>
    </div>
    
   
    
</body>

<script type="text/javascript">

$(function(){

    $('#title_div').children('span').replaceWith('<span>1.本测验包括许多问题和选择，任何答案选择都无所谓对错，</span>');
    $('.Leo_ans_checktext').click(function(){
        var temp=$(this).parent().children('div').children(':radio')[0];
        temp.checked=!temp.checked;
    });
        
    $("#ans_div").css('width','100%');
    var ans_div_height=$("#title_div").outerHeight();
    if(ans_div_height<150){
        $("#ans_div").css('height',400-ans_div_height);
    }else{
        $("#title_div").css('height',150);
        $("#ans_div").css('height',250);
    }
    

   

    $('#announce_panel').children('p').replaceWith('<p>本测验包括许多问题和选择，任何答案选择都无所谓对错，对它们所描述的特征，你可能喜欢，也可能不喜欢，其方式你可能曾感觉到，也可能没有感觉到，请你从中选出最能表现或接近你当前特征或感觉的那一个，并将你的选择标记于相应的位置处。如果答案中都没有正确描述你的情况，那你应当选择你认为能比较正确反映你的情况的那一个。总之，对于每道题的选项你必须有所选择。</p>');

    

     $('#do_announce').click(function(){
        if($("#announce_panel").css('display')=='none'){
            $('#announce_panel').slideDown('fast', function() {});
        }else{
            $('#announce_panel').slideUp('fast', function() {});
        }
        
    });

})

Leo_initPanel(34);
 function Leo_initPanel(questionlength) {
        var rows_count = Math.ceil(questionlength/ 5);
            for (var k = 0; k < rows_count; k++) {
                var row_now = document.getElementById("Leo_question_table").insertRow(k);
                if (k < rows_count - 1) {
                    for (var i = 0; i < 5; i++) {
                        var cell_now = row_now.insertCell(i);
                        var newdiv = document.createElement("div");
                        newdiv.style.float = "left";
                        newdiv.style.margin = "5px";
                        newdiv.style.width = "40px";
                        newdiv.style.height = "40px";
                        newdiv.id = "newdiv_" + (5 * k + i);
                        newdiv.style.textAlign = "center";
                        newdiv.style.cursor = "pointer";
                        newdiv.style.backgroundColor = "gray";
                        newdiv.innerText = ( 5 * k + i) + 1 + "";
                        newdiv.style.fontSize = "21px";
                        newdiv.tabIndex = "0";
                        cell_now.appendChild(newdiv);
                        //newdiv.onclick = new Function("changepage(parseInt(this.innerText)-1,true)");
                    }
                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");
                } else {
                    for (var i = 0; i < questionlength- (rows_count - 1) * 5 ; i++) {
                        var cell_now = row_now.insertCell(i);
                        var newdiv = document.createElement("div");
                        newdiv.style.float = "left";
                        newdiv.style.margin = "5px";
                        newdiv.style.width = "40px";
                        newdiv.style.height = "40px";
                        newdiv.id = "newdiv_" + ( 5 * k + i);
                        newdiv.style.textAlign = "center";
                        newdiv.style.cursor = "pointer";
                        newdiv.style.backgroundColor = "gray";
                        newdiv.innerText = ( 5 * k + i) + 1 + "";
                        newdiv.style.fontSize = "21px";
                        newdiv.tabIndex = "0";
                        cell_now.appendChild(newdiv);
                        //newdiv.onclick = new Function("changepage(parseInt(this.innerText)-1,true)");
                    }
                    for (var i = questionlength - (rows_count - 1) * 5; i < 5; i++) {
                        var cell_now = row_now.insertCell(i);
                    }
                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");
                }
            }
    }

Leo_timer_start();

function Leo_timer_start(){
    var total_time=0;
    time_play();
    function time_play(){

        setTimeout(function(){
            total_time++;
            seconds=total_time%60;
            minutes=(total_time-seconds)/60%60;
            hour=(total_time-seconds-minutes*60)/60/60;
            $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
            $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
            $("#hours").html(( hour < 10 ? "0" : "" ) + hour);
            time_play();
        },1000)
    }

}
changepage();
function changepage(){
    var s={
        "ss":"ss"
    }
    $.post('/test/index', function(data){
        /*optional stuff to do after success */
        alert(data.eee);
    });
}

</script>

</html>
