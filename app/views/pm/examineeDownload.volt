<script type="text/javascript" src="/js/bootstrap.js"></script>
<script src='/fileupload/ajaxfileupload.js'></script>

<div name='{{project_id}}' class="Leo_question" style="overflow:hidden;padding:10px;">
    <div class="form-group">
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">被试信息</div>
    </div>  
    <hr size="2" color="#FF0000" style="width:90%;"/>
    <div class='form-group' style='margin-left:60px;'>
        <div class="row fileupload-buttonbar">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <a class="btn btn-primary" style='width:200px;'  href="/pm/examineeExport"  type='button'>
                <i class="glyphicon glyphicon-download"></i>所有被试信息列表
            </a>
        </div>
    </div> 
    <hr size="2" color="#FF0000" style="width:90%;"/>
    <div class="form-group">
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">批量下载</div>
    </div>  
    <hr size="2" color="#FF0000" style="width:90%;"/>
<div style="width:100%;height:40px;margin-left:40px;">
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectComReport()">
            <button type='button' class="btn btn-primary start" style='width:100px;'>
                <i class="glyphicon glyphicon-plane"></i>
                <span>一键算分</span>
                <span class="label" id='score'></span>
            </button>
        </a>
    </div>
</div>
<div style="width:100%;height:40px;margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>个人综合素质报告
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectComReport()">
            <button id="onekeys1" type='button' class="btn btn-primary start" style='width:100px;'>
                <i class="glyphicon glyphicon-send"></i>
                <span>一键生成</span>
            </button>
            <span class="label" id='comprehesive'></span>
        </a>
    </div>
     &emsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectComReport()">
            <button id="onekeyd1" type='button' class="btn btn-primary start" style='width:100px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>一键导出</span>
            </button>
        </a>
    </div>
</div>
<div style="width:100%;height:40px; margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>个人胜任力报告<span style='visibility: hidden'>位</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectComReport()">
            <button id="onekeys2" type='button' class="btn btn-primary start" style='width:100px;'>
                <i class="glyphicon glyphicon-send"></i>
                <span>一键生成</span>
            </button>
            <span class="label" id='competency'></span>
        </a>
    </div>
     &emsp;
    <div class='form-group' style='display:inline-block;'>
        <a href = '#' onclick="downloadProjectComReport()">
            <button id="onekeyd2" type='button' class="btn btn-primary start" style='width:100px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>一键导出</span>
            </button>
        </a>
    </div>
</div>
    <hr size="2" color="#FF0000" style="width:90%;"/>
    <div class='form-group' style='display:inline-block;text-align:right;width:90%;'>
        <form action='/pm' class="form-inline" method='post'>
            <input id='page' value='1' name='page' type='hidden'/>
            <button type='submit' class='btn btn-primary' style='width:80px;'>返回上层</button>
        </form>
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
    if(data.comprehesive){
        $('#comprehesive').addClass('label-success');
        $('#comprehesive').html('已完成');
        $('#onekeys1').attr('disabled',true);
    }else{
        $('#comprehesive').addClass('label-danger');
        $('#comprehesive').html('未完成');
        $('#onekeyd1').attr('disabled',true);
    }
    if(data.competency){
        $('#competency').addClass('label-success');
        $('#competency').html('已完成');
        $('#onekeys2').attr('disabled',true);
    }else{
        $('#competency').addClass('label-danger');
        $('#competency').html('未完成');
        $('#onekeyd2').attr('disabled',true);
    }
}
function downloadAllComprehesive(){
    downloadWait('正在生成所有被试人员个人综合素质报告！');
    $.post('/file/getAllIndividualComprehesive',{'project_id':{{project_id}}}, function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadAllCompetency(){
    downloadWait('正在生成所有被试人员个人胜任力报告！');
    $.post('/file/getAllIndividualCompetency',{'project_id':{{project_id}}}, function(data){
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

   
