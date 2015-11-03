<script src='/ichart/ichart.latest.min.js'></script>
<script type='text/javascript' src='/js/spin.js'></script>
<script type="text/javascript" src= '/datetimepicker/bootstrap.min.js'></script>
<div class="Leo_question">
    <div style="margin:0 auto;width:100%;padding:10px 10px 0 10px;text-align:center;">
    	<span style="font-size:30px;font-family:'Microsoft YaHei UI'" id='project_name'>
    	</span>
    </div>
    <hr size="2" color="#FF0000" style="width:90%;"/>
    <div style='text-align:center;'>
        <div id="ichart-render-ceping" style='display:inline-block;'></div>
        <div style='display:inline-block;width:10px;'></div>
        <div id='ichart-render-mianxun' style='display:inline-block;'></div>
    </div>
    <div style="width:100%;padding:10px;">
        <div style="margin-left:30px;padding:10px;font-size:26px;color:red;">项目时间计划
        </div>       
        <div style="width:90%; margin:0 auto;">
        <table style="width:100%">
        	<tr>
        	<td id="begintime" style="width:20%;text-align:left;" > 	
                </td>
            <td id="project_state" style="width:60%; text-align:center;">
                </td>
            <td id="endtime" style="width:20%;text-align:right;">
            </td>
            </tr>
        </table>
        </div> 
        <div class="progress" style="width:90%; margin:0 auto;">
            <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
        </div>
        </div>
        <div style="width:90%; margin:0 auto;">
            <table style="width:100%">
            <tr>
                <td style="width:20%;text-align:left;">
            	开始时间</td>
            	<!-- <td style="width:60%; text-align:center;">
            	现在时间</td> -->
            	<td style="width:20%;text-align:right;">
            	结束时间</td>
            </tr>
            </table>
        </div> 
    </div>
    <div style="width:100%;padding:0 60px;text-align:right; ">
        <div class="form-group">
            <button class="btn btn-primary" onclick='history.go(-1);'>返回首页</button>
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
    var spinner = null;
    var target = document.getElementsByClassName('Leo_question')[0];
    var url="/admin/getdetail";
$('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$(function(){
	var project_id = getproject();
    getData(url, project_id);
});
function getproject(){
	var url = window.location.href;
	var url_arr = url.split('/');
	return url_arr.pop();
}
function getData(url, project_id){
	spinner = new Spinner().spin(target);
    $.post(url, {'id':project_id},function(data) {
    	
    	if(data.error){
    		if(spinner){ spinner.stop(); }
    		     $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<a href='/admin/index'><button type=\"button\" class=\"btn btn-primary\">返回</button></a>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
    	}else{
    		if(spinner){ spinner.stop(); }
    		datadeal(data.success);
    		 
    	}
    })
}

function datadeal(data){
	$('#project_name').html(data.project_name);
	var count = data.exam_count;
	var exam = data.exam_finish;
	var interview = data.interview_finish;
	var examinee_percent = 0;
	var interview_percent = 0;
	if(count != 0){
		examinee_percent = exam/count;
		if(exam != 0 ){
			interview_percent = interview/exam;
		}
	}
	var examinee = examinee_percent;
    var interview = interview_percent;
            var data_ceping = [
                 {
                  name:"未完成",
                  value:1-examinee,
                  color:"#aa4643"
            },{
                  name:"已完成",
                  value:examinee,
                  color:"#89a54e"
            }
            ];
             var data_mianxun= [
                 {
                  name:"未完成",
                  value:1-interview,
                  color:"#aa4643"
            },{
                  name:"已完成",
                  value:interview,
                  color:"#89a54e"
            }
            ];
	  ichartDraw('ichart-render-ceping', data_ceping, '测评完成度');    
      ichartDraw('ichart-render-mianxun', data_mianxun,'面询完成度');  
	var begintime = data.begintime;
	var endtime = data.endtime;
	var begindate = begintime.split(' ')[0];
	var enddate = endtime.split(' ')[0];
	$('#begintime').html(begindate);
	$('#endtime').html(enddate);
	var nowtime = CurentTime();
	// $('#nowtime').html(nowtime.split(' ')[0]);
	
	if(nowtime >= endtime){
		$('#project_state').html('<span style=\'color:red\'>项目已结束</span>')
		$('#progress').width('100%');
		$('#progress').addClass('progress-bar-success');
	}else if(nowtime<=begintime){
		$('#project_state').html('<span style=\'color:red\'>项目未开始</span>')
		$('#progress').width('0%');
	}else{
		//时间计算
		$('#project_state').html('<span style=\'color:green\'>项目正在进行</span>')
		begintime = new Date(Date.parse(begintime.replace(/-/g, "/"))).getTime();   
		endtime = new Date(Date.parse(endtime.replace(/-/g, "/"))).getTime();
		nowtime = new Date().getTime();
		// console.log(begintime);
		// console.log(endtime);
		// console.log(nowtime);
		var t1 = endtime-begintime;
		var t2 = nowtime-begintime;
		if( t1 == 0 ){
			 $('#progress').width('100%');
			 $('#progress').addClass('progress-bar-success');
		}else{
			var bi = t2/t1;
			bi=bi.toFixed(2);
            bi=bi.slice(2,4)+"%";
            $('#progress').width(bi);
		}
		
	}
}
function ichartDraw( container, data, title){
	new iChart.Pie2D({
                    render : container,
                    data: data,
                    title : title,
                    legend : {
                        enable : false,
                    },
                    sub_option : {
                        label : {
                            background_color:null,
                            sign:true,//设置禁用label的小图标
                            padding:'0 4',
                            border:{
                                enable:false,
                                color:'#666666'
                            },
                            fontsize:12,
                            fontweight:600,
                            color : '#4572a7'
                        },
                        border : {
                            width : 1,
                            color : '#ffffff'
                        }
                    },
                    animation:true,
                    showpercent:true,
                    decimalsnum:2,
                    radius:50,
                    height:200,
                    width:380,
                }).draw();
	
}    
function CurentTime()
    { 
        var now = new Date();
       
        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日
       
        var hh = now.getHours();            //时
        var mm = now.getMinutes();          //分
       
        var clock = year + "-";
       
        if(month < 10)
            clock += "0";
       
        clock += month + "-";
       
        if(day < 10)
            clock += "0";
           
        clock += day + " ";
       
        if(hh < 10)
            clock += "0";
           
        clock += hh + ":";
        if (mm < 10) clock += '0'; 
        clock += mm; 
        return(clock); 
    }     
</script>