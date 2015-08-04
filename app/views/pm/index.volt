
<div class="Leo_question" style="overflow:hidden;background-color:white;" >
       <div style="width:100%;height:50px;background-color:blue;">
           <table id="labels" style="text-align: center;width:100%; height: 100%;cursor:pointer;background-color:white; " cellspacing="0" cellpadding="0" border="0">
           <tr style="width:100%;height:inherit;margin:0px;">
               <td id="label_detail" style=" width: 20%; height: 100%; background-image: url(../images/label5.png); " onclick="Leo_switch(this)">项目详情</td>
               <td id="label_users" style="width: 20%; height: 100%; background-image: url(../images/label1.png); " onclick="Leo_switch(this)">被试人员</td>
               <td id="label_experts" style="width: 20%; height: 100%; background-image: url(../images/label1.png); " onclick="Leo_switch(this)">面询专家</td>
				        <td id="label_leaders" style="width: 20%; height: 100%; background-image: url(../images/label1.png);" onclick="Leo_switch(this)">领导列表</td>
               <td id="label_results" style="width: 20%; height: 100%; background-image: url(../images/label1.png); " onclick="Leo_switch(this)">查看结果</td>

               </tr></table>

       </div>
        
        <div class="Leo_scroll_panel" style="margin:0 auto;top:0px;" id="Leo_manager_home">
           

        </div>
</div>

<script type='text/javascript'>

     Leo_switch(document.getElementById("label_detail"));



        function Leo_switch(t) {
                 
              switch (t.id) {
                  case "label_detail": sw(0); 

                                          //to first page

                                     $.get('/pm/detail', function(data) {
                                        /*optional stuff to do after success */

                                        $("#Leo_manager_home").html(data);
                                      });

                                      break;
                  case "label_users": sw(1);

                                        $.get('/pm/examinee', function(data) {
                                        /*optional stuff to do after success */

                                        $("#Leo_manager_home").html(data);
                                      });


                                       break;
                 
                  case "label_experts": sw(2);

                                        $.get('/pm/interviewer', function(data) {
                                        /*optional stuff to do after success */

                                        $("#Leo_manager_home").html(data);
                                      });


                                        break;
                  case "label_leaders": sw(3); 

                                        $.get('/pm/leader', function(data) {
                                        /*optional stuff to do after success */

                                        $("#Leo_manager_home").html(data);
                                      });


                                       break;
                  case "label_results": sw(4);
                                        $.get('/pm/result', function(data) {
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