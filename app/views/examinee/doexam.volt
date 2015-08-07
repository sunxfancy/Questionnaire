<div class="Leo_question_v2" id="Leo_question_v2">
        <div style="overflow:hidden;width:600px;height:440px;">
        <div style="width:95%;height:410px;margin:0 auto;display:none;font-size:25px;font-family:'微软雅黑'" id='announce_panel'><p></p></div><div id='do_announce' style="width:100%;height:30px;background-color:#eeed6a;text-align:center;font-size:20px;font-family:'Microsoft YaHei';overflow:hidden;"><table style="width:100%;height:100%;text-align:center;vertical-align:middle;cursor:pointer;"><tr style="width:100%;height:100%;"><td style="width:100%;height:100%;" id="classInfo"></td></tr></table></div>
        <div class="Leo_question_l" style="height:400px;" id="Leo_question_panel">
        <div style='width:95%;height:400px;margin:0 auto;'>
        <div id="title_div" style='width:100%;height:auto;font-weight:normal;font-size:28px;background-color:green;word-break:break-all;overflow:auto;'><span></span></div>
        <div id='ans_div' style="overflow:auto;"></div>
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
    <div class="Leo_question_t_v2">

        <table style="width:92%;text-align:center;vertical-align:middle;table-layout:fixed;margin:0 auto;" id="Leo_question_table" cellspacing="0"></table>
    </div>
    <div class="Leo_Timer_v2">
        <table style="width:145px;height:120px;text-align:center;vertical-align:middle;margin:0 auto;table-layout:fixed;" cellspacing="0"><tr style="width:245px;height:50px;"><td colspan="5">已用时</td></tr>
            <tr><td id="hour">00</td><td>:</td><td id="minute">00</td><td>:</td><td id="second">00</td></tr></table>
    </div>
   
    
</body>

<script type="text/javascript">

$(function(){

    $('#title_div').children('span').replaceWith('<span>本测验包括许多问题和选择，任何答案选择都无所谓对错，</span>');
        
    $("#ans_div").css('width','100%');
    var ans_div_height=$("#title_div").outerHeight();
    if(ans_div_height<150){
        alert('ok');
        $("#ans_div").css('height',400-ans_div_height);
    }else{
        $("#title_div").css('height',150);
        $("#ans_div").css('height',250);
    }
    
    $("#ans_div").css('background-color','pink');

    $('#announce_panel').children('p').replaceWith('<p>本测验包括许多问题和选择，任何答案选择都无所谓对错，对它们所描述的特征，你可能喜欢，也可能不喜欢，其方式你可能曾感觉到，也可能没有感觉到，请你从中选出最能表现或接近你当前特征或感觉的那一个，并将你的选择标记于相应的位置处。如果答案中都没有正确描述你的情况，那你应当选择你认为能比较正确反映你的情况的那一个。总之，对于每道题的选项你必须有所选择。</p>');

    

     $('#do_announce').click(function(){
        if($("#announce_panel").css('display')=='none'){
            $('#announce_panel').slideDown('fast', function() {});
        }else{
            $('#announce_panel').slideUp('fast', function() {});
        }
        
    });

})

   
</script>

</html>
