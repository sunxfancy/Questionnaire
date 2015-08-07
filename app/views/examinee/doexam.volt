<div class="Leo_question_v2" id="Leo_question_v2">
        <div style="width:100%;height:30px;background-color:#eeed6a;text-align:center;font-size:20px;font-family:'Microsoft YaHei';overflow:hidden;"><table style="width:100%;height:100%;text-align:center;vertical-align:middle;cursor:pointer;" onclick="alert('本测验包括许多问题和选择，任何答案选择都无所谓对错，对它们所描述的特征，你可能喜欢，也可能不喜欢，其方式你可能曾感觉到，也可能没有感觉到，请你从中选出最能表现或接近你当前特征或感觉的那一个，并将你的选择标记于相应的位置处。如果答案中都没有正确描述你的情况，那你应当选择你认为能比较正确反映你的情况的那一个。总之，对于每道题的选项你必须有所选择。')"><tr style="width:100%;height:100%;"><td style="width:100%;height:100%;" id="classInfo"></td></tr></table></div>
        <div class="Leo_question_l" style="height:400px;" id="Leo_question_panel"></div>
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
    <!--<div class="Leo_question" style="overflow:hidden;">
        <table style="height:100%;width:100%;border:0px;table-layout:fixed;" cellspacing="0">
            <tr style="width:100%;">
                <td style="width:70%;height:100%;">

                    <table style="width:100%;height:100%;border:0px;" cellspacing="0">
                    <tr style="height:85%;"><td>
                        <div style="width:100%;height:30px;background-color:#eeed6a;text-align:center;font-size:20px;font-family:'Microsoft YaHei';" ><table style="width:100%;height:100%;text-align:center;vertical-align:middle;"><tr style="width:100%;height:100%;"><td style="width:100%;height:100%;" id="classInfo"></td></tr></table></div>
                        <div style="width:100%;height:7%;"></div>
                         <div class="Leo_question_l" id="Leo_question_panel"></div>
                        </td></tr>
                    <tr style="height:1%;"><td style="background-color: #b9e5d6;"></td></tr>
                    <tr style="height:15%"><td>
                            <div id="Leo_control" style="width:100%;height:100%;text-align:center;margin-top:15px;">
                                <img style="height:70px;" src="images/left.png" onclick="Leo_pageup()"/>
                                <img style="height: 70px; display: none;" id="Leo_pagedown" src="images/signin.png" onclick="Leo_pagedown()" />
                                
                            </div>
                        </td></tr>
                    </table>
                    
                </td>
                <td style="width: 0.5%; height: 100%; background-color: #b9e5d6;" ></td>
                <td style="width:29.5%;height:100%;" >
                   <table style="width:100%;height:100%;border:0px;table-layout:fixed;margin:0 auto;" cellspacing="0">
                        <tr style="height:200px;width:100%;">
                             <td style="overflow:auto;white-space:nowrap;">
                               <div id="Leo_question_t" class="Leo_question_t" ><table style="width:92%;text-align:center;vertical-align:middle;table-layout:fixed;" id="Leo_question_table" cellspacing="0"></table></div>
                            </td>
                        </tr>
                        <tr style="height:1%;"><td style="background-color: #b9e5d6;"></td></tr>
                        <tr style="height:25%;width:100%">
                            <td style="width:100%;">
                                <div id="Leo_timer" style="width:100%;height:20px;text-align:center;">
                                    <table style="width:100%;height:100%;border:1px solid black;" cellspacing="0">
                                        <tr style="width:100%;height:100%;"><td rowspan="2"></td><td colspan="6">已用时</td></tr>
                                        <tr style="width:100%;height:100%;"><td></td><td>时</td><td></td><td>分</td><td></td><td>秒</td></tr>
                                    </table>

                                </div>
                                
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr>

            

        </table>
        <div id="Leo_hiden" class="Leo_hiden" style="top:-500px;display:none;" onclick="Leo_doques()"><table style="height:100%;width:100%;text-align:center;vertical-align:middle;"><tr><td id="Leo_hiden_td"><br /></td></tr></table></div>
       
        
    </div>-->
    <footer>
        <div class="Leo_foot">
            Leonardo&S
        </div>

    </footer>
</body>

</html>
