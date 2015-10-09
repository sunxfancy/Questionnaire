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
    <div class='form-group' style='margin-left:60px;'>
        <div class="row fileupload-buttonbar">
            <a class="btn btn-primary" style='width:200px;' href="#" onclick="downloadAllComprehesive()" type='button'>
                <i class="glyphicon glyphicon-download"></i>个人综合素质报告
            </a>
        </div>
    </div> 
    <div class='form-group' style='margin-left:60px;'>
        <div class="row fileupload-buttonbar">
            <a class="btn btn-primary" style='width:200px;' href="#" onclick="downloadAllCompetency()" type='button'>
                <i class="glyphicon glyphicon-download"></i>个人胜任力报告
            </a>
        </div>
    </div>
    <hr size="2" color="#FF0000" style="width:90%;"/>
    <div class="form-group" style='text-align:right;width:90%;'> 
    	<form action='/pm' method='post'>
    		<input id='page' value='1' name='page' type='hidden'/>
            <button type='submit' class='btn btn-success' style='width:80px;'>返回上层</button>
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
$('#myModal').on('hidden.bs.modal', function (e) {
    $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
    $('.Leo_question').css('width','860px')
});  
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

   
