<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src='/ichart/ichart.latest.min.js'></script>

<div style='text-align:center; margin-top:10px;'>
        <div id="ichart-render-ceping" style='display:inline-block;'></div>
        <div style='display:inline-block;width:10px;'></div>
        <div id='ichart-render-mianxun' style='display:inline-block;'></div>
</div>

<div style="width:100%;height:100px;">
    <div style="margin-left:40px;font-size:26px;color:red;"> 项目时间计划</div>

    <div style="width:90%; margin:0 auto;">
        <table style="width:100%">
        	<tr>
        	<td id="begintime" style="width:20%;text-align:left;">
        	</td>
        	<td id="project_state" style="width:60%; text-align:center;">
        	</td>
        	<td id="endtime" style="width:20%;text-align:right;">
        	</td></tr>
        </table>
    </div> 
    <div class="progress" style="width:90%; margin:0 auto ">
        <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>
    <div style="width:90%; margin:0 auto 20px;">
        <table style="width:100%">
        	<tr>
        		<td style="width:20%;text-align:left;">开始时间</td>
        		<td style="width:20%;text-align:right;">截止时间</td>
        	</tr>
        </table>
    </div> 
	  <div style="display:inline-block;font-size:26px;color:red;height:30px;margin: 0 0 0 40px;">项目配置
	  </div>
	  <div id='state' role="alert" class="alert alert-dismissible fade in" style='display:inline-block; padding-top:5px; padding-bottom:5px; margin-top:0;margin-bottom:0;height:30px; ' >
         </button>
      </div>
      <form class="form-inline" style='text-align:center;margin-top:10px;'>
      	 <div class="form-group">
                <a href='/pm/inquery' type='button' class="btn btn-primary">
                <i class="glyphicon glyphicon-wrench"></i>&nbsp;
                需求量表配置</a>
                <span class="label" id='inquery'></span>
         </div>
         &emsp;&emsp;&emsp;
         <div class="form-group">
                <a href='/pm/module' type= 'button' class="btn btn-primary">
                <i class="glyphicon glyphicon-wrench"></i>&nbsp;
                题目模块配置</a>
                <span class="label" id='exam'></span>
         </div>
      </form>
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
    var url="/pm/getdetail";
$('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$(function(){
    getData(url);
});
function getData(url){
    spinner = new Spinner().spin(target);
    $.post(url,function(data) { 
        if(data.error){
            if(spinner){ spinner.stop(); }
                 $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<a href='/managerlogin'><button type=\"button\" class=\"btn btn-primary\">重新登录</button></a>"
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
    if(data.state){
    	$('#state').addClass('alert-success');
    	$('#state').append('项目配置已完成！')
    }else{
    	$('#state').addClass('alert-danger');
        $('#state').append('请先完成项目配置！')
    }
    if(data.exam){
    	$('#exam').addClass('label-success');
        $('#exam').html('已完成')
    }else{
    	$('#exam').addClass('label-danger');
        $('#exam').html('未完成');
    }
    if(data.inquery){
        $('#inquery').addClass('label-success');
        $('#inquery').html('已完成')
    }else{
        $('#inquery').addClass('label-danger');
        $('#inquery').html('未完成');
    }
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