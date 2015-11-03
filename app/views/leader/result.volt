<script type="text/javascript" src="/js/bootstrap.js"></script>

<div class="form-group" style='text-align:center;font-size:26px;color:red;margin-top:10px;'>综&nbsp;合&nbsp;素&nbsp;质</div>
<hr size="2" color="#FF0000" style="width:70%;"/>
<div style="width:100%;height:40px;text-align:center; margin: 5px 10px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>人才综合测评总体分析报告
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

<hr size="2" color="#FF0000" style="width:70%;"/>
<div class="form-group" style='text-align:center;font-size:26px;color:red;margin-top:10px;'>胜&nbsp;任&nbsp;力&nbsp;模&nbsp;型</div>  
<hr size="2" color="#FF0000" style="width:70%;"/>
<div style="width:100%;height:40px;text-align:center; margin: 5px 10px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>班子胜任力模型测评报告<span style='visibility: hidden'>位</span>
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
        <a href = '#' onclick="downloadSystemReport()">
        	<button type='button' class="btn btn-primary start" style='width:150px;'>
                <i class="glyphicon glyphicon-download"></i>
                <span>导出</span>
        	</button>
        </a>
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
function downloadProjectComReport(){
    $.post('/file/LgetProjectComReport', function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadTeamReport(){
    $.post('/file/LgetTeamReport',function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
}
function downloadSystemReport(){
    $.post('/file/LgetSystemReport', function(data){
        if (data.error){
            downloadError(data.error);
        }else{
            downloadSuccess(data.success);
        }
    });
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