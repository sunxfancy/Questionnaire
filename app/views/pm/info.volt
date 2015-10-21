<script type="text/javascript" src= '/datetimepicker/bootstrap.min.js'></script>
<div class="Leo_question">
    <div class="baseinfo" style="width:100%;height:100%;overflow:auto;">
        <div style="padding:10px;text-align:center;font-size:28px;">基本信息</div>
        <table border="1" style="line-height:33px; margin:0 auto; font-size:16px; font-family:'微软雅黑'">
            <tr>
                <td style="width:120px;font-size:14px;">&nbsp;姓名</td>
                <td style="width:180px;" id='name'></td>
                <td style="width:120px;font-size:14px;">&nbsp;性别</td>
                <td style="width:180px;" id='sex'></td></tr>
            <tr>
                <td style="width:120px;font-size:14px;">&nbsp;学历</td>
                <td style="width:180px;" id='education'></td>
                <td style="width:120px;font-size:14px;">&nbsp;学位</td>
                <td style="width:180px;" id='degree'></td></tr>
            <tr>
                <td style="width:120px;font-size:14px;">&nbsp;出生年月</td>
                <td style="width:180px;" id='birthday'></td>
                <td style="width:120px;font-size:14px;">&nbsp;籍贯</td>
                <td style="width:180px;" id='native'></td></tr>
            <tr>
                <td style="width:120px;font-size:14px;">&nbsp;政治面貌</td>
                <td style="width:180px;" id='politics'></td>
                <td style="width:120px;font-size:14px;">&nbsp;职称</td>
                <td style="width:180px;" id='professional'></td></tr>
            <tr><td style="width:120px;font-size:14px;">&nbsp;工作单位</td>
                <td colspan="3" style="width:180px;" id='employer'></td></tr>
            <tr><td style="width:120px;font-size:14px;">&nbsp;部门</td>
                <td colspan="3" style="width:180px;" id='unit'></td></tr>
            <tr><td style="width:120px;font-size:14px;">&nbsp;职务</td>
                <td colspan="3" style="width:180px;" id='duty'></td></tr>
            <tr><td style="width:120px;font-size:14px;">&nbsp;班子/系统</td>
                <td colspan="3" style="width:180px;" id='team'></td></tr>
        </table>

        <div style="padding:10px;text-align:center;font-size:28px;">教育经历</div>
        <table id="eduTable" border="1" style="text-align:center;width:600px;line-height:33px;margin:0 auto;font-size:16px; font-family:'微软雅黑'">
            <tr style="font-weight:bold;font-size:14px;"><td>&nbsp;毕业院校</td><td>&nbsp;专业</td><td>&nbsp;所获学位</td><td>&nbsp;时间</td></tr>
        </table>

        <div style="padding:10px;text-align:center;font-size:28px;">工作经历</div>
        <table id="workTable" border="1" style="text-align:center;width:600px; line-height:33px; margin:0 auto; font-size:16px; font-family:'微软雅黑'">
            <tr style="font-weight:bold;font-size:14px;"><td>&nbsp;就职单位</td><td>&nbsp;部门</td><td>&nbsp;岗位/职务</td><td>&nbsp;起止时间</td></tr>
        </table>
        <div class="panel panel-danger" style='width:600px; margin:30px auto 0;'>
        	 <div class="panel-heading">
                <h3 class="panel-title">用户信息修改条目</h3>
            </div>
            <div class="panel-body" id='diff_body'>
               
            </div>
        </div>
        <div class="panel panel-danger" style='width:600px; margin:30px auto 0;'>
             <div class="panel-heading">
                <h3 class="panel-title">用户教育经历修改对比</h3>
            </div>
            <div class="panel-body" id='diff_body_edu'>
               
            </div>
        </div>
        <div class="panel panel-danger" style='width:600px; margin:30px auto 0;'>
             <div class="panel-heading">
                <h3 class="panel-title">用户工作经历修改对比</h3>
            </div>
            <div class="panel-body" id='diff_body_work'>
               
            </div>
        </div>
        <div style="width:80%;text-align:right;margin: 40px">    
              <!--   <div style='display:inline-block;'>
                    <button class="btn btn-info" style='width:100px;'>
                    <i class="glyphicon glyphicon-print"></i>&nbsp;打印</button>
                </div>
                &nbsp;&nbsp;
                <div style='display:inline-block;'>
                    <button class="btn btn-primary"  style='width:100px;'>
                    <i class="glyphicon glyphicon-download"></i>&nbsp;导出
                    </button>
                </div>
                &nbsp;&nbsp; -->
                <div style='display:inline-block;'>
                    <span id='page'></span>
                </div>
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
<script type="text/javascript">
    var spinner = null;
    var target = document.getElementsByClassName('Leo_question')[0];
    var url="/pm/listinfo";
    var examinee_id = <?php if(isset($examinee_id)){ echo $examinee_id; }else { echo -1; }?>;
    var type = <?php if(isset($type)){ echo $type; }else { echo 0; }?>;
$('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});

$(function(){
    getInfo(url, examinee_id,type);
});

function backChose(type){
	//绿色通道
	if (type == 1){
		var data =  "<a href='/pm/greenchannel'><button type=\"button\" class=\"btn btn-success\" style='width:100px;'><i class='glyphicon glyphicon-fast-backward'></i>&nbsp;返回</button></a>"
        return data;      
	}else {
		var data = "<form action='/pm' class='form-inline' method=\'post\'><input id='page' value='1' name='page' type='hidden'/><button type='submit' class='btn btn-success' style='width:100px;'><i class='glyphicon glyphicon-fast-backward'></i>&nbsp;返回</button></form>";
	    return data;
	}
}
function getInfo(url, examinee_id,type){
        spinner = new Spinner().spin(target);
        $.post(url, {'examinee_id': examinee_id}, function(data) {
            if(data.error){
                 if(spinner){ spinner.stop(); }
                 $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    backChose(type)
                    );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
            }else{
                 if(spinner){ spinner.stop(); }
                 $('.Leo_question').css('width','860px');
                 //加载成功后获取jqgrid数据
                 renderring(data.success);
                 $('#page').html(backChose(type))  ;
            }
        });
}
function renderring(data){
	var space = '&nbsp;';
    $('#name').html(space+showvalue(data.name));
    $('#sex').html(space+showvalue(data.sex));
    $('#education').html(space+showvalue(data.education));
    $('#degree').html(space+showvalue(data.degree));
    $('#birthday').html(space+showvalue(data.birthday));
    $('#native').html(space+showvalue(data.native));
    $("#politics").html(space+showvalue(data.politics));
    $("#professional").html(space+showvalue(data.professional));
    $("#employer").html(space+showvalue(data.employer));
    $("#unit").html(space+showvalue(data.unit));
    $("#duty").html(space+showvalue(data.duty));
    $("#team").html(space+showvalue(data.team));
    if (data.diff_comm){
    	  showDiffComm(data.diff_comm);
    }
    if (data.diff_other){
    	  showDiffOth(data.diff_other);
    }
    
  
    if(data.educations){
    	showEdu(data.educations);
    }
    if(data.works){
    	 showWork(data.works);
    }
}
function showDiffOth(diff){
	var data ='';
	if (diff.education || diff.education.length > 0){
	   if (diff.education['value']){
	   	 var len_1 = diff.education['value'].length;
	   	 data += '<h4>修改前</h4>';
	   	 var j = 1;
         for (var i = 0; i < len_1; i+=4) {
           data += ( (j++) +".&nbsp;&nbsp;" +diff.education['value'][i] + '--'+ diff.education['value'][i+1] +'--'+diff.education['value'][i+2] +'--'+diff.education['value'][i+3]+'<br />');
         }
         data += '<h4>修改后</h4>';
         var len_2 = diff.education['svalue'].length;
         var j = 1;
         for (var i = 0; i < len_2; i+=4) {
           data += ( (j++) +".&nbsp;&nbsp;"+diff.education['svalue'][i] + '--'+ diff.education['svalue'][i+1] +'--'+diff.education['svalue'][i+2] +'--'+diff.education['svalue'][i+3]+'<br />');
         }
        }
	   $('#diff_body_edu').append(data);
	}
	var data = '';
	if  (diff.work || diff.work.length > 0){
        console.log(diff.work);
        if (diff.work['value']){
        	var len_1 = diff.work['value'].length;
        	data += '<h4>修改前</h4>';
        	var j = 1;
            for (var i = 0; i < len_1; i+=4) {
                data += ( (j++) +".&nbsp;&nbsp;"+diff.work['value'][i] + '-'+ diff.work['value'][i+1] +'-'+diff.work['value'][i+2] +diff.work['value'][i+3]+'<br />');
                
            }
            var len_2= diff.work['svalue'].length;
            data += '<h4>修改后</h4>';
            var j = 1;
            for (var i = 0; i < len_2; i+=4) {
                data += ( (j++) +".&nbsp;&nbsp;"+diff.work['svalue'][i] + '-'+ diff.work['svalue'][i+1] +'-'+diff.work['svalue'][i+2] +diff.work['svalue'][i+3]+'<br />');
            }
            
          
        }
         $('#diff_body_work').append(data);
    }
   
}

function showDiffComm(diff){
	 var table=$("<table class=\"table table-hover\">");  
     table.appendTo($("#diff_body")); 
     var tr;
     var th;
     var td;
     tr=$("<tr></tr>");   
     tr.appendTo(table);   
     th=$("<th>修改条目名称</th><th>修改前</th><th>修改后</th>");  
     th.appendTo(tr);   
     for (var i = 0; i < diff.length; i++) {
       switch(diff[i].id){
         case 'name': diff[i].id = '姓名'; break;
          case 'sex': diff[i].id = '性别'; break;
           case 'education': diff[i].id = '学历'; break;
            case 'degree': diff[i].id = '学位'; break;
             case 'birthday': diff[i].id = '出生年月'; break;
              case 'native': diff[i].id = '籍贯'; break;
               case 'politics': diff[i].id = '政治面貌'; break;
                case 'professional': diff[i].id = '职称'; break;
                 case 'employer': diff[i].id = '工作单位'; break;
                  case 'unit': diff[i].id = '部门'; break;
                   case 'duty': diff[i].id = '职务';break;
                    case 'team': diff[i].id = '班子/系统'; break;
                    default : ;
           }
        tr=$("<tr></tr>");   
        tr.appendTo(table);   
        td=$("<td>"+diff[i].id+"</td>"+"<td>"+diff[i].value+"</td>"+"<td>"+diff[i].svalue+"</td>");  
        td.appendTo(tr);    
    } 
     tr.appendTo(table);  
     $("#diff_body").append("</table>");  
}
function showvalue(value){
	if (value){
		return value;
	}else {
		return '';
	}
}
 function showEdu(data){
        for (var i = 0; i < data.length; i++) {
            var data1 = document.getElementById('eduTable').insertRow(i+1);
            var td0 = data1.insertCell(0);
            var td1 = data1.insertCell(1);
            var td2 = data1.insertCell(2);
            var td3 = data1.insertCell(3);
            td0.innerHTML = "&nbsp;"+data[i].school;
            td1.innerHTML = "&nbsp;"+data[i].profession;
            td2.innerHTML = "&nbsp;"+data[i].degree;
            td3.innerHTML = "&nbsp;"+data[i].date;
        }
    }

    function showWork(data){
        for (var i = 0; i < data.length; i++) {
            var data1 = document.getElementById('workTable').insertRow(i+1);
            var td0 = data1.insertCell(0);
            var td1 = data1.insertCell(1);
            var td2 = data1.insertCell(2);
            var td3 = data1.insertCell(3);
            td0.innerHTML = "&nbsp;"+data[i].unit;
            td1.innerHTML = "&nbsp;"+data[i].employer;
            td2.innerHTML = "&nbsp;"+data[i].duty;
            td3.innerHTML = "&nbsp;"+data[i].date;
        }
    }
</script>