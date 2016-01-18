<script type="text/javascript" src="/js/bootstrap.js"></script>
<div class="Leo_question" style="overflow:hidden;padding:10px;">
	<div class="form-group">
            <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;"> 题目模块配置状态</div>
            <span class="label" id='module_state'></span>
    </div>  
    <div style="width:100%;height:350px;">
        <div style="width:50%;height:350px;background-color:    #C4E1FF;float:left;">
			<div id="leibie" style="width:90%;height:90%;margin-top:5%;font-size:26px;text-align:right;margin-right:10%;float:left;">
                <div style="width:100%;height:50px;cursor:pointer;" id='lingdaoli'>胜任力模块<span style='color:red'>>></span></div>
                <div style="width:100%;height:50px;cursor:pointer;" id='zonghe'>素质测评模块</div>
            </div>
		</div>

        <div style="width:50%;height:350px;background-color:pink;float:left;">
			<div id="xifen" style="width:95%;height:90%;margin-top:5%;margin-left:5%;font-size:20px;float:left;">
                <div id='lingdaoli_sel'>
                    <div style="width:100%;height:50px;"><input value="领导力" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >领导力</span></div>
                    <div style="width:100%;height:50px;"><input value="职业素质" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >职业素质</span></div>
                    <div style="width:100%;height:50px;"><input value="思维能力" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >思维能力</span></div>
                    <div style="width:100%;height:50px;"><input value="态度品质" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >态度品质</span></div>
                    <div style="width:100%;height:50px;"><input value="专业能力" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >专业能力</span></div>
                    <div style="width:100%;height:50px;"><input value="个人特质" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >个人特质</span></div>
                </div>
                <div id='zonghe_sel' style="display:none">
                    <div style="width:100%;height:50px;"><input value="心理健康" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >心理健康</span></div>
                    <div style="width:100%;height:50px;"><input value="素质结构" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >素质结构</span></div>
                    <div style="width:100%;height:50px;"><input value="能力结构" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >能力结构</span></div>
                    <div style="width:100%;height:50px;"><input value="智体结构" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >智体结构</span></div>
                </div>         
            </div>
		</div>
    </div>

    <div style="width:100%;height:40px;text-align:center;margin-top:20px;">   
    	<button class='btn btn-danger' id='del' style='width:120px'>
        <i class="glyphicon glyphicon-trash"></i>&nbsp;清空项目模块</button>&nbsp;&nbsp;    
        <button class="btn btn-primary" id='sel_all' style='width:80px;'>
        <i class="glyphicon glyphicon-ok-circle"></i>&nbsp;全选</button>&nbsp;&nbsp;    
        <button class="btn btn-primary" id='unsel_all' style='width:80px;'>
        <i class="glyphicon glyphicon-ban-circle"></i>&nbsp;全不选</button>&nbsp;&nbsp; 
        <button class="btn btn-danger" id="submit" style='width:80px;'>
        <i class="glyphicon glyphicon-pencil"></i>&nbsp;提交</button> &nbsp;&nbsp;     
        <a href='/pm'type='button' class='btn btn-success' style='width:100px;'>
        <i class="glyphicon glyphicon-home"></i>&nbsp;返回首页</a>     
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
    var url="/pm/getmodule";
    var choices = new Array();
    $(function(){
    	
    	getData(url);

    	
    });
    function getData(url){
    	  $('button').attr('disabled',true);
          spinner = new Spinner().spin(target);
    	  $.post(url, function(data) {
    	  	if(spinner){ spinner.stop(); }
    	  	$('button').attr('disabled',false);
    	  	if(data.error){
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
	if (data.state == true){
		$('#module_state').addClass('label-success');
        $('#module_state').html('已完成');
		$('#del').attr('disabled', false);
	}else{
		$('#del').attr('disabled', true);
		$('#module_state').addClass('label-danger');
        $('#module_state').html('未完成');
	}
	//edit by brucewyh 修复ie10下出现的问题  对象空值
	if (!data.ans && typeof(data.ans)!="undefined" && data.ans!=0 )
    {
           return ;
    }
    //edit end 
    var ans=data.ans.split("|");
    choices = ans;
    for (var i = 0; i < ans.length; i++) {
        $("[value="+ans[i]+"]").prop("checked","checked");
    };
}

$("#lingdaoli").click(function(){
            $("#lingdaoli").html("胜任力模块<span style='color:red'>>></span>");
            $("#zonghe").html("素质测评模块");
            $("#zonghe_sel").css('display','none');
            $("#lingdaoli_sel").css('display','');
        });
$("#zonghe").click(function(){
            $("#lingdaoli").html("胜任力模块");
            $("#zonghe").html("素质测评模块<span style='color:red'>>></span>");
            $("#lingdaoli_sel").css('display','none');
            $("#zonghe_sel").css('display','');
        });

$('#sel_all').click(function(){ $(":checkbox").prop('checked','checked'); console.log($(":checkbox"))});

$('#unsel_all').click(function(){ $(":checkbox").prop('checked',false);});

        $('#myModal').on('hidden.bs.modal', function (e) {
            $('.Leo_question').css('width','860px')
        });
        $('#myModal').on('hide.bs.modal', function (e) {
            $('.Leo_question').css('width','860px')
        });  
        
$("#submit").click(function(){    
	        var checks=$(":checkbox");
            var checkeds=new Array();
            var values=new Array();
            var state = false;
            for(var i=0;i<checks.length;i++){
                    checkeds[i]= checks[i].checked;
                    state = checks[i].checked || state;
                    values[i]=checks[i].value;
            }    
	        if(!state){
	        	 $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>选择不能为空</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回修改</button></a>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
                
	        }else{
	        	console.log(choices);
	        	console.log(checkeds);
	        	console.log(values);
	        	 $('.Leo_question').css('width','843px');    
                 $('.modal-body').html("<p class=\"bg-success\" style='padding:20px;'>系统正在配置模块中，请勿关闭浏览器</p>"+"<div style='text-align:center; padding:5px 10px 10px 10px;'><img src='/image/loading.gif' style='width:300px' /></div>");
                 $('.modal-footer').html('');
                 $('#myModal').modal({keyboard:true, backdrop:'static'});
                   
                $.post('/pm/writeprojectdetail',{'checkeds':checkeds,'values':values}, 
                function(data) {
                if(data.error){
                    $('.modal-body').html("<p class=\"bg-danger\" style='padding:20px;'>处理失败："+data.error+"</p>"+"<p class=\"bg-danger\"></p>");
                    $('.modal-footer').html('');
                    $('.modal-footer').html("<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回处理</button>");
                    $('#myModal').modal({keyboard:true, backdrop:'static'});
                }else{
                    $('.modal-body').html('');
                    $('.modal-body').html( "<p class=\"bg-success\" style='padding:20px;'>项目模块选择配置完成!</p>");
                    $('.modal-footer').html('');
                    $('.modal-footer').html("<a href='/pm/module' type=\"button\" class=\"btn btn-success\" >留在本页</a>"+
                    "<a href=\'/pm\/index\' type=\"button\" class=\"btn btn-success\" >返回首页</button>"
                    );
                    
                    $('#myModal').modal({keyboard:true, backdrop:'static'});
                }
            });
	        }
           

           
        });
$('#del').click(function(){
    $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>确定要删除项目已配置的模块吗?</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                     "<button type=\"button\" class=\"btn btn-danger\" onclick='delmodule();'>确定</button>"+
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回</button>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
})    

function delmodule(){
	$('button').attr('disabled', true);
     spinner = new Spinner().spin(target);
          $.post('/pm/delmodule', function(data) {
          	$('button').attr('disabled', false);
            if(spinner){ spinner.stop(); }
            if(data.error){
                showError(data.error);
            }else{
            
            $('.modal-body').html('');
            $('.modal-body').html( "<p class=\"bg-success\" style='padding:20px;'>项目题目配置信息已删除!</p>");
            $('.modal-footer').html('');
            $('.modal-footer').html("<a href='/pm/module' type=\"button\" class=\"btn btn-success\">留在本页</a>"+
            "<a href='/pm/index' type=\"button\" class=\"btn btn-success\" >返回首页</button>"
            );
            
            $('#myModal').modal({keyboard:true, backdrop:'static'});
            }
        })
}
function showError(msg){
    $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+msg+"</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回修改</button>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
}
</script>

   
