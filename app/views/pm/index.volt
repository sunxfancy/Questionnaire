<div class="Leo_question" style="overflow:hidden;background-color:white;" >
    <div style="width:100%;height:50px;background-color:blue;">
        <table id="labels" style="text-align: center;width:100%; height: 100%;cursor:pointer;background-color:white; " cellspacing="0" cellpadding="0" border="0">
            <tr style="width:100%;height:inherit;margin:0px;">
                <td id="label_detail" style=" width: 20%; height: 100%; background-image: url(../images/label5.png);font-size:20px; " onclick="Leo_switch(0)">项目详情</td>
                <td id="label_users" style="width: 20%; height: 100%; background-image: url(../images/label1.png); font-size:20px;" onclick="Leo_switch(1)">被试人员</td>
                <td id="label_experts" style="width: 20%; height: 100%; background-image: url(../images/label1.png); font-size:20px;" onclick="Leo_switch(2)">面询专家</td>
				<td id="label_leaders" style="width: 20%; height: 100%; background-image: url(../images/label1.png);font-size:20px;" onclick="Leo_switch(3)">领导列表</td>
                <td id="label_results" style="width: 20%; height: 100%; background-image: url(../images/label1.png); font-size:20px;" onclick="Leo_switch(4)">查看结果</td>
            </tr>
        </table>
    </div>       
    <div class="Leo_scroll_panel" style="margin:0 auto;top:0px;" id="Leo_manager_home">	
    </div>
</div>

<script type='text/javascript'> 
$(function(){
    Leo_switch(<?php if(isset($page)){ echo $page; }else { echo 0; }?>);
})
    
    function Leo_switch(t) {                 
        switch (t) {
            case 0: sw(0); 
                //to first page
                $.post('/pm/detail', function(data) {
                    /*optional stuff to do after success */
                    $("#Leo_manager_home").html(data);
                });
                break;
            case 1: sw(1);
                $.post('/pm/examinee', function(data) {
                    /*optional stuff to do after success */
                    $("#Leo_manager_home").html(data);
                });
                break;                 
            case 2: sw(2);
                $.post('/pm/interviewer', function(data) {
                    /*optional stuff to do after success */
                    $("#Leo_manager_home").html(data);
                });
                break;
            case 3: sw(3); 
                $.post('/pm/leader', function(data) {
                    /*optional stuff to do after success */
                    $("#Leo_manager_home").html(data);
                });
                break;
            case 4: sw(4);
                $.post('/pm/result', function(data) {
                    /*optional stuff to do after success */
                    $("#Leo_manager_home").html(data);
                });
                break;
            default: sw(0);
        }
        function sw(n) {                 
            var s1 = document.getElementById("labels").rows[0].cells;               
            for (var i = 0; i < s1.length; i++) {
                s1[i].style.backgroundImage ="url(../images/label1.png)";
                }
            s1[n].style.backgroundImage = "url(../images/label5.png)";
        }
    }
</script>