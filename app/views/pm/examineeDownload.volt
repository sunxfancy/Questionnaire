<script type="text/javascript" src="/js/bootstrap.js"></script>
<script src='/fileupload/ajaxfileupload.js'></script>

<div class="Leo_question" style="overflow:hidden;padding-top:25px;">
    <div class="form-group" style='display:inline-block;'>
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">被试信息</div>
    </div> 
    <div class='form-group' style='display:inline-block;float:right;margin-right:40px;'>
        <form action='/pm' class="form-inline" method='post'>
            <input id='page' value='1' name='page' type='hidden'/>
            <button type='submit' class='btn btn-success' style='width:100px;'>
            <i class="glyphicon glyphicon-fast-backward"></i>&nbsp;返回上层</button>
        </form>
    </div> 
    <div class='form-group' style='margin-left:60px;'>
        <div class="row fileupload-buttonbar">
            <a class="btn btn-primary" style='width:200px;'  href="/pm/examineeExport"  type='button'>
                <i class="glyphicon glyphicon-download"></i>&nbsp;所有被试信息列表
            </a>
        </div>
    </div> 
    <div class="form-group">
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">批量下载</div>
    </div>  
<div style="width:100%;height:40px;margin-left:40px;">
    <div class='form-group' style='display:inline-block;'>
        <button id="onekeyc" type='button' onclick="oneKeyCalculate()" class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-send"></i>&nbsp;一键算分
        </button>
        <span class="label" id='score'></span>
    </div>
</div>
<div style="width:100%;height:40px;margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>个人综合素质报告
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id="onekeys1" onclick="oneKeyComprehensive()" type='button' class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-send"></i>&nbsp;一键生成
        </button>
        <span class="label" id='comprehesive'></span>
    </div>&nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id="onekeyd1" onclick="downloadProjectComReport()" type='button' class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-download"></i>&nbsp;一键导出
        </button>
    </div>
</div>
<div style="width:100%;height:40px; margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>个人胜任力报告<span style='visibility: hidden'>位</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id="onekeys2" onclick="oneKeyCompetency()" type='button' class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-send"></i>&nbsp;一键生成
        </button>
        <span class="label" id='competency'></span>
    </div>&nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id="onekeyd2" onclick="downloadProjectComReport()" type='button' class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-download"></i>&nbsp;一键导出
        </button>
    </div>
</div>
<div class="form-group">
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">批量上传</div>
    </div>  
<div style="width:100%;height:40px;margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>个人综合素质报告
    </div>
    &nbsp;&nbsp;
   <div class='form-group' style='display:inline-block;'>
        <span class="btn btn-success fileinput-button" style='width:100px;'>
            <i class="glyphicon glyphicon-plus"></i>
            <span>上传</span>
            <input onchange = 'checkFile3();' accept="application/msexcel" type="file" id='file1' name='file1' style='opacity:0; position:absolute; top:0;left:0;cursor:pointer; width:100px;'>
        </span>
        <span class="label label-default" id='file3_state'>未选择</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id='submit1' type='button' class="btn btn-danger start" style='width:100px;'>
            <i class="glyphicon glyphicon-upload"></i>
            <span>导入</span>
        </button>
    </div>
</div>
<div style="width:100%;height:40px; margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>个人胜任力报告<span style='visibility: hidden'>位</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <span class="btn btn-success fileinput-button" style='width:100px;'>
            <i class="glyphicon glyphicon-plus"></i>
            <span>上传</span>
            <input onchange = 'checkFile3();' accept="application/msexcel" type="file" id='file1' name='file1' style='opacity:0; position:absolute; top:0;left:0;cursor:pointer; width:100px;'>
        </span>
        <span class="label label-default" id='file3_state'>未选择</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id='submit1' type='button' class="btn btn-danger start" style='width:100px;'>
            <i class="glyphicon glyphicon-upload"></i>
            <span>导入</span>
        </button>
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
    var url="/pm/getReportState";
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
    if(data.score){
        $('#score').addClass('label-success');
        $('#score').html('已完成');
        $('#onekeyc').attr('disabled',true);
    }else{
        $('#score').addClass('label-default');
        $('#score').html('未完成');
        $('#onekeys1').attr('disabled',true);
        $('#onekeys2').attr('disabled',true);
    }
    if(data.comprehesive){
        $('#comprehesive').addClass('label-success');
        $('#comprehesive').html('已完成');
        $('#onekeys1').attr('disabled',true);
    }else{
        $('#comprehesive').addClass('label-default');
        $('#comprehesive').html('未完成');
        $('#onekeyd1').attr('disabled',true);
    }
    if(data.competency){
        $('#competency').addClass('label-success');
        $('#competency').html('已完成');
        $('#onekeys2').attr('disabled',true);
    }else{
        $('#competency').addClass('label-default');
        $('#competency').html('未完成');
        $('#onekeyd2').attr('disabled',true);
    }
}
function oneKeyCalculate(){
    downloadWait('正在计算所有被试人员测评得分！');
    $.post('/pm/oneKeyCalculate', function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function oneKeyComprehensive(){
    downloadWait('正在生成所有被试人员个人综合素质报告！');
    $.post('/file/getAllIndividualComprehesive', function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function oneKeyCompetency(){
    downloadWait('正在生成所有被试人员个人胜任力报告！');
    $.post('/file/getAllIndividualCompetency',function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadAllComprehensive(){
    downloadWait('正在生成所有被试人员个人综合素质报告！');
    $.post('/file/getAllIndividualComprehesive', function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadAllCompetency(){
    downloadWait('正在生成所有被试人员个人胜任力报告！');
    $.post('/file/getAllIndividualCompetency', function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadWait(msg){
    $('.Leo_question').css('width','843px');    
    $('.modal-body').html("<p class=\"bg-success\" style='padding:20px;'>"+msg+"</p>"+"<div style='text-align:center; padding:5px 10px 10px 10px;'><img src='/image/loading.gif' style='width:300px' /></div>");
    $('.modal-footer').html('');
    $('#myModal').modal({keyboard:true, backdrop:'static'});
}
function downloadError(msg){
    $('.Leo_question').css('width','843px')
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
    $('.Leo_question').css('width','843px')
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

   
