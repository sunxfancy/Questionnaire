<script type="text/javascript" src="/js/bootstrap.js"></script>
<script src='/fileupload/ajaxfileupload.js'></script>
<!--pm 页面公用函数库-->
<script src='/js/pm.assit.js'></script>

<!-- <div class="form-group" style='text-align:center;font-size:26px;color:red;margin-top:10px;'> 综&nbsp;合&nbsp;素&nbsp;质
</div> -->
<div style="">
<hr size="2" color="#FF0000" style="width:90%;"/>

<div style="width:100%;height:40px;text-align:center; margin: 5px 10px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>人才综合测评总体分析报告
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <span class="btn btn-success fileinput-button" style='width:150px;'>
            <i class="glyphicon glyphicon-plus"></i>
            <span>上传</span>
            <input onchange = 'checkFile(this);' type="file" id='file_1' name='file_1' style='opacity:0; position:absolute; top:0;left:0;cursor:pointer; width:150px;'>
        </span>
        <span class="label label-default" id='state_1'>未选择</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id='submit_1' type='button' onclick='submitFile(this)'  class="btn btn-danger start" style='width:150px;'>
            <i class="glyphicon glyphicon-upload"></i>
            <span>导入</span>
        </button>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectComReport()">
            <button type='button' class="btn btn-primary start" style='width:150px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>导出</span>
            </button>
        </a>
    </div>
</div>
<hr size="2" color="#FF0000" style="width:90%;" class='active'/>
<!-- <div class="form-group" style='text-align:center;font-size:26px;color:red;margin-top:10px;'>胜&nbsp;任&nbsp;力&nbsp;模&nbsp;型
</div>  
<hr size="2" color="#FF0000" style="width:90%;"/> -->
<div style="width:100%;height:40px;text-align:center; margin: 5px 10px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>班子胜任力模型测评报告<span style='visibility: hidden'>位</span>
    </div>
    &nbsp;&nbsp;
     <div class='form-group' style='display:inline-block;'>
        <span class="btn btn-success fileinput-button" style='width:150px;'>
            <i class="glyphicon glyphicon-plus"></i>
            <span>上传</span>
            <input onchange = 'checkFile(this);'  type="file" id='file_2' name='file_2' style='opacity:0; position:absolute; top:0;left:0;cursor:pointer; width:150px;'>
        </span>
        <span class="label label-default" id='state_2'>未选择</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id='submit_2' type='button' onclick='submitFile(this)'  class="btn btn-danger start" style='width:150px;'>
            <i class="glyphicon glyphicon-upload"></i>
            <span>导入</span>
        </button>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadTeamReport()">
            <button type='button' class="btn btn-primary start" style='width:150px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>导出</span>
            </button>
        </a>
    </div>
</div>
<div style="width:100%;height:40px;text-align:center; margin: 5px 10px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>系统胜任力模型测评报告<span style='visibility: hidden'>位</span>
    </div>
    &nbsp;&nbsp;
     <div class='form-group' style='display:inline-block;'>
        <span class="btn btn-success fileinput-button" style='width:150px;'>
            <i class="glyphicon glyphicon-plus"></i>
            <span>上传</span>
            <input onchange = 'checkFile(this);' type="file" id='file_3' name='file_3' style='opacity:0; position:absolute; top:0;left:0;cursor:pointer; width:150px;'>
        </span>
        <span class="label label-default" id='state_3'>未选择</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id='submit_3' onclick='submitFile(this)' type='button' class="btn btn-danger start" style='width:150px;'>
            <i class="glyphicon glyphicon-upload"></i>
            <span>导入</span>
        </button>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadSystemReport()">
            <button type='button' class="btn btn-primary start" style='width:150px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>导出</span>
            </button>
        </a>
    </div>
</div>
<hr size="2" color="#FF0000" style="width:90%;"/>
<!-- <div class="form-group" style='text-align:center;font-size:26px;color:red;margin-top:10px;'> 总&nbsp;体&nbsp;数&nbsp;据
</div>
<hr size="2" color="#FF0000" style="width:90%;"/> -->
<div style="width:100%;height:40px;text-align:left; margin: 5px 40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>人才综合测评总体数据<span style='visibility: hidden'>位位</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectData()">
            <button type='button' class="btn btn-primary start" style='width:150px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>导出</span>
            </button>
        </a>
    </div>
</div>
<div style="width:100%;height:40px;text-align:left; margin: 5px 40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>人才综合素质评估数据<span style='visibility: hidden'>位位</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectEvaluation()">
            <button type='button' class="btn btn-primary start" style='width:150px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>导出</span>
            </button>
        </a>
    </div>
</div>
<div style="width:100%;height:40px;text-align:left; margin: 5px 40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>总体数据分析<span style='visibility: hidden'>位位位位位位</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectAnalysis()">
            <button type='button' class="btn btn-primary start" style='width:150px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>导出</span>
            </button>
        </a>
    </div>
</div>

<div style="width:100%;height:40px;text-align:left; margin: 5px 40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>需求量表统计结果<span style='visibility: hidden'>位位位位</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadInqueryData()">
            <button type='button' class="btn btn-primary start" style='width:150px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>导出</span>
            </button>
        </a>
    </div>
</div>
<hr size="2" color="#FF0000" style="width:90%;"/>
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
$('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});  

$(function(){
	for(var i = 1; i <= 3; i++ ){
		$('#submit_'+i).attr('disabled',true);
	}
})

function checkFile(args){
    var number = args.id.substr( args.id.length-1, 1);
    if($('#file_'+number ).val() != ''){
        $('#state_'+number ).removeClass('label-default');
        $('#state_'+number ).addClass('label-success');
        $('#state_'+number ).html('已选择');
        $('#submit_'+number ).attr('disabled', false);
    }else{
        $('#state_'+number ).removeClass('label-success');
        $('#state_'+number ).addClass('label-default');
        $('#state_'+number ).html('未选择');
        $('#submit_'+number ).attr('disabled', true);
   }
    console.log(number);
}

function submitFile(args){
	 var number = args.id.substr( args.id.length-1, 1);
     var path = $('#file_'+number ).val();
       if(path == '' || path == undefined){
              downloadError('请先选择要上传的文件');
              return false;   
       }
        $('.Leo_question').css('width','843px');    
        $('.modal-body').html("<p class=\"bg-success\" style='padding:20px;'>上传文件中...</p>"+"<div style='text-align:center; padding:5px 10px 10px 10px;'><img src='/image/loading.gif' style='width:300px' /></div>");
        $('.modal-footer').html('');
        $('#myModal').modal({keyboard:true, backdrop:'static'});
        $.ajaxFileUpload ({
        url:'/file/fileUploadv1/'+number, //你处理上传文件的服务端 
        secureuri:false, //与页面处理代码中file相对应的ID值
        fileElementId:'file_'+number,
        dataType: 'json', //返回数据类型:text，xml，json，html,scritp,jsonp五种
        success: function (data) {
            if(data.error){
                downloadError(data.error);
                clearFileInput(document.getElementById('file_'+number));
                checkFile(document.getElementById('file_'+number));
            }else{
            	clearFileInput(document.getElementById('file_'+number));
                checkFile(document.getElementById('file_'+number));
            $('.modal-body').html('');
            $('.modal-body').html( "<p class=\"bg-success\" style='padding:20px;'>上传完成</p>");
            $('.modal-footer').html('');
            $('.modal-footer').html("<button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">关闭提示</button>"
            );
            $('#myModal').modal({keyboard:true, backdrop:'static'});
            //成功返回后的操作
           }

        }
        });
}

function downloadProjectComReport(){
    downloadWait('正在生成人才综合测评总体分析报告！');
    $.post('/file/MgetProjectComReport', function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadTeamReport(){
    downloadWait('正在生成班子胜任力报告！');
    $.post('/file/MgetTeamReport', function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadSystemReport(){
    downloadWait('正在生成系统胜任力报告！');
    $.post('/file/MgetSystemReport',function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadProjectData(){
    downloadWait('正在生成人才综合测评总体数据！');
    $.post('/file/getProjectData',function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadProjectEvaluation(){
    downloadWait('正在生成人才综合素质评估数据！');
    $.post('/file/getProjectEvaluation',function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}

function downloadProjectAnalysis(){
    downloadWait('正在生成总体数据分析表！');
    $.post('/file/getProjectAnalysis',function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function isArray(o) {  
  return Object.prototype.toString.call(o) === '[object Array]';   
} 

function downloadInqueryData() {
	downloadWait('正在生成需求量表统计结果！');
    $.post('/file/getinqueryans',function(data){
        if (data.error){
        	if(isArray(data.error)){
        		    //打印未完成名单
            var not = data.error;
            var msg ='还有如下被试未完成需求量表作答【'+ not.length+'人】：<br />';
            for(var i = 0, len = not.length; i < len; i++ ){
                msg+= (not[i]+'<br />');
            }
            downloadError(msg);   
        	}else{
        		 downloadError(data.error);
        	} 
        }else{
            downloadSuccess(data.success);
        }
    });
}

function downloadWait(msg){
    $('.Leo_question').css('width','840px');    
    $('.modal-body').html("<p class=\"bg-success\" style='padding:20px;'>"+msg+"</p>"+"<div style='text-align:center; padding:5px 10px 10px 10px;'><img src='/image/loading.gif' style='width:300px' /></div>");
    $('.modal-footer').html('');
    $('#myModal').modal({keyboard:true, backdrop:'static'});
}
function downloadError(msg){
    $('.Leo_question').css('width','840px')
    $('.modal-body').html('');
    $('.modal-body').html(
        "<p class=\"bg-danger\" style='padding:20px;'>"+msg+ "</p>"
    );
    $('.modal-footer').html('');
    $('.modal-footer').html(
        "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">返回</button>"
    );
    $('#myModal').modal({
        keyboard:true,
        backdrop:'static'
    })
}
function downloadSuccess(msg){
    $('.Leo_question').css('width','840px')
    $('.modal-body').html('');
    $('.modal-body').html(
        "<p class=\"bg-success\" style='padding:20px;'>"+msg+ "</p>"
    );
    $('.modal-footer').html('');
    $('.modal-footer').html(
       "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">关闭</button>"
    );
    $('#myModal').modal({
        keyboard:true,
        backdrop:'static'
    })
}
</script>
</script>
