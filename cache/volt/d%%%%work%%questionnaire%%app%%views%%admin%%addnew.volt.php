<!--引入时间控件样式表-->
<link rel="stylesheet" href="/datetimepicker/bootstrap-datetimepicker.min.css" />
<link rel='stylesheet' type='text/css' href='/bootstrap/css/bootstrap.min.css' />
<!--引入时间控件js-->
<script type='text/javascript' src='/datetimepicker/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src= '/datetimepicker/bootstrap.min.js'></script>
<script type="text/javascript" src="/datetimepicker/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>

<div class="Leo_question">
    <center>
    	<p style="margin:15px;font-size:30px;font-family:'Microsoft YaHei';">评测项目信息填写</p>
    </center>
    <hr size="2" color="#FF0000" style="width:90%;"/>
    <div style='text-align:center;'>
    <div style='text-align:center;margin-top:10px;'>
        <label for='project_name'><span style='font-size:16px;font-family: Microsoft YaHei UI; font-weight:normal;'><span style='color:white;'>占位</span>项目名称</span></label>
        <input required type='text' class='form-control' id='project_name' style='display:inline-block;height:36px;font-size:16px;width:200px;'/>
    </div>
    <div style='text-align:center;margin-top:3px;'>
        <label for='begintime'><span style='font-size:16px;font-family: Microsoft YaHei UI; font-weight:normal;'>项目开始时间</span></label>
        <input required type='text' class='form-control' id='begintime' style='display:inline-block;height:36px;font-size:16px;width:200px;'/>
    </div>
    <div style='text-align:center;margin-top:3px;'>
        <label for='endtime'><span style='font-size:16px;font-family: Microsoft YaHei UI; font-weight:normal;'>项目结束时间</span></label>
        <input required type='text' class='form-control' id='endtime' style='display:inline-block;height:36px;font-size:16px;width:200px;'/>
    </div>
    <div style='text-align:center;margin-top:3px;'>
        <label for='pm_name'><span style='font-size:16px;font-family: Microsoft YaHei UI; font-weight:normal;'>项目经理名称</span></label>
        <input required type='text' class='form-control' id='pm_name' style='display:inline-block;height:36px;font-size:16px;width:200px;'/>
    </div>
    <div style='text-align:center;margin-top:3px;'>
        <label for='pm_username'><span style='font-size:16px;font-family: Microsoft YaHei UI; font-weight:normal;'>项目经理账号</span></label>
        <input required type='text' class='form-control' id='pm_username' style='display:inline-block;height:36px;font-size:16px;width:200px;'/>
    </div>
    <div style='text-align:center;margin-top:3px;'>
        <label for='pm_password'><span style='font-size:16px;font-family: Microsoft YaHei UI; font-weight:normal;'>项目经理密码</span></label>
        <input required type='text' class='form-control' id='pm_password' style='display:inline-block;height:36px;font-size:16px;width:200px;'/>
    </div>
    <div style='text-align:center;margin-top:3px;'>
       <textarea type="text" id="description" style=" line-height: 28px;height: 100px;width: 600px;font-size:16px; font-family:'Microsoft YaHei';" placeholder='添加更详细的信息描述...'></textarea>
    </div>
    </div>
    <div style="text-align:center;margin-top:5px;">
        <div class="form-group">
            <button type='button' class="btn btn-success" style='padding:5px 40px; ' onclick='history.go(-1);'>返回</button>
            &nbsp;&nbsp;<button id="submit" class="btn btn-primary" style='padding:5px 40px; ' >提交</button>
        </div>
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
<script type='text/javascript'>
$('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});   
var spinner = null;
var target = document.getElementsByClassName('Leo_question')[0];
$("#submit").click(function(){
	            spinner = new Spinner().spin(target);
        	    var msg = '';
        	    var pattern_str = new RegExp('^[0-9a-zA-Z]*$'); //匹配字母数字串
        	    var pattern_time = new RegExp("^[1-9][0-9]{3}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])[ ](0?[0-9]|1[0-9]|2[0-3])[:](0?[0-9]|[1-5][0-9])[:][0][0]$");
        	    if($("#project_name").val() == ''){ 
        	    	msg += '项目名称不能为空<br />';
        	    }else if ( $("#begintime").val() == '' ){ 
        	    	msg+='项目开始时间不能为空<br />'; 
        	    }else if ($("#endtime").val() == '' ){ 
        	    	msg+='项目结束时间不能为空<br />'; 
        	    }else if ( !$("#begintime").val().match(pattern_time) ){
        	    	msg+= ('项目开始时间格式有误-'+ $("#begintime").val()+'-请按照日历选择');
        	    }else if ( !$("#endtime").val().match(pattern_time) ){
                    msg+= ('项目结束时间格式有误-'+ $("#begintime").val()+'-请按照日历选择');
                }else if ( unix_time_stamp($("#endtime").val()) <= unix_time_stamp($("#begintime").val())){
                	msg+='开始时间与结束时间冲突';
                }else if ($("#pm_name").val() == ''){ 
        	    	msg+='项目经理名称不能为空<br />';
        	    }else if ($("#pm_username").val() == ''){ 
        	    	msg+='项目经理账号不能为空<br />';
        	    }else if( !($("#pm_username").val()).match(pattern_str)){
                    msg+='项目经理账号格式：字母,数字,字母数字组合<br />';
                }else if ($("#pm_password").val() == ''){
                	msg+='项目经理密码不能为空';
                }else if(!$("#pm_password").val().match(pattern_str)){
                    msg+='项目经理密码格式：字母,数字,字母数字组合<br />';
                }else{
                	//
                }
                if(msg != ''){
                	 if(spinner){ spinner.stop(); }
                	 $('.Leo_question').css('width','843px')
	                 $('.modal-body').html('');
	                 $('.modal-body').html(
	                     "<p class=\"bg-danger\" style='padding:20px;'>"+msg+ "</p>"
	                     );
	                 $('.modal-footer').html('');
	                 $('.modal-footer').html(
	                    "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">返回修改</button>"
	                 );
	                 $('#myModal').modal({
	                    keyboard:true,
	                    backdrop:'static'
	                 })
                }else{
                 var project_info = {
                    "project_name" :$("#project_name").val(),
                    "description" :$("#description").val(),
                    "begintime" :$("#begintime").val(),
                    "endtime" :$("#endtime").val(),
                    "pm_name" :$("#pm_name").val(),
                    "pm_username" :$("#pm_username").val(),
                    "pm_password" :$("#pm_password").val()
                  };
                  $.post('/admin/newproject', project_info,function(data){
                        if(data.error){
                        	 if(spinner){ spinner.stop(); }
                             $('.Leo_question').css('width','843px')
                             $('.modal-body').html('');
                             $('.modal-body').html(
                                "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+"</p>"
                             );
                             $('.modal-footer').html('');
                             $('.modal-footer').html(
                                "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">返回修改</button>"   
                             );
                             $('#myModal').modal({
                                keyboard:true,
                                backdrop:'static'
                             })
                            
                        }else{
                        	 if(spinner){ spinner.stop(); }
                             $('.Leo_question').css('width','843px')
                             $('.modal-body').html('');
                             $('.modal-body').html(
                                "<p class=\"bg-success\" style='padding:20px;'>项目添加成功!</p>"
                             );
                             $('.modal-footer').html('');
                             $('.modal-footer').html(
                                "<a type='button' href='/admin/addnew' class=\"btn btn-primary\" style='padding:5px 20px;'>继续添加项目</a>"+
                                "<a type='button' href='/admin/index' class=\"btn btn-success\" style='padding:5px 20px;'>回到首页</a>"
                             );
                             $('#myModal').modal({
                                keyboard:true,
                                backdrop:'static'
                             })
                        }
                    });
                }
                
})
    
$(function(){
	 $('#begintime').datetimepicker({
                            language: 'zh-CN', //汉化 
                            format:'yyyy-mm-dd hh:ii:00' , 
                            autoclose:true,
                            minuteStep: 10
    }).on('changeDate', function(){
    	 $('#endtime').datetimepicker('setStartDate',  dateCon($('#begintime').val(),60))
    });
    $('#endtime').datetimepicker({
                            language: 'zh-CN', //汉化 
                            format:'yyyy-mm-dd hh:ii:00' , 
                            autoclose:true,
                            minuteStep: 10
    }).on('changeDate', function(){
         $('#begintime').datetimepicker('setEndDate',  dateCon($('#endtime').val(), -60))
    });
    
});
//yy-mm-dd h:i
function unix_time_stamp( timestr ){
	time_standard = timestr.replace(new RegExp("-","gm"),"/");
    return (new Date(time_standard)).getTime();
}
/**
* d : 字符串时间，格式为 yyyy-MM-dd HH:mm:ss
* num : 秒
* return : 返回 字符串 ，格式跟传入的相同
*/
function dateCon(d,num){
    var d = new Date(d.substring(0,4),
    d.substring(5,7)-1,
    d.substring(8,10),
    d.substring(11,13),
    d.substring(14,16),
    d.substring(17,19)
    );

    d.setTime(d.getTime()+num*1000);
    //alert(d.toLocaleString());
    return d.getFullYear()+"-"
    +(d.getMonth()+1)
    +"-"+d.getDate()
    +" "+d.getHours()
    +":"+d.getMinutes()
    +":"+d.getSeconds();
}
</script>