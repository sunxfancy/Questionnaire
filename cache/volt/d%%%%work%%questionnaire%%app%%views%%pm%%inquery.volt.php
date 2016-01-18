<script type="text/javascript" src="/js/bootstrap.js"></script>
<script src='/fileupload/ajaxfileupload.js'></script>
<div class="Leo_question" style="overflow:hidden;padding:10px;">
    <div class="form-group">
            <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;"> 需求量表配置状态</div>
            <span class="label" id='inquery_state'></span>
    </div>  
    <hr size="2" color="#FF0000" style="width:90%;"/>
    <div class='form-group' style='margin-left:60px;'>
      <div class="row fileupload-buttonbar">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <a class="btn btn-primary" style='width:200px;' href='/template/inquery.xls' type='button'>
                    <i class="glyphicon glyphicon-download"></i>
                    需求量表模板下载
                </a>
                <br />
                <br />
                <span class="btn btn-success fileinput-button" style='width:200px;'>
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>上传需求量表</span>
                    <input accept="application/msexcel" type="file" id='file' name='file' style='opacity:0; position:absolute; top:0;left:0;cursor:pointer; width:200px;'>
                </span>
                <button id='submit' type='submit' class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>开始上传</span>
                </button>
                &nbsp;&nbsp;<span id='filename'></span>
                <br />
                <br />
                <button id='search' class="btn btn-primary " style='width:200px;'>
                    <i class="glyphicon glyphicon-zoom-in"></i>
                    <span>查看需求量表</span>
                </button>
                <br />
                <br />
                <button id='del' class="btn btn-danger " style='width:200px;'>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>删除需求量表</span>
                </button>
                <!-- The global file processing state -->
      </div>
    </div> 
      <hr size="2" color="#FF0000" style="width:90%;"/>
    <div class="form-group" style='text-align:right;width:90%;'> 
        <a href='/pm' type='button' class='btn btn-success' style='width:100px;'>
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
    var url="/pm/getinquery";
    inquery_data = null;
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
    if(data.state == false){
    	//项目需求量表没有
    	$('#inquery_state').addClass('label-danger');
        $('#inquery_state').html('未完成');
        $('#search').attr('disabled',true);
        $('#del').attr('disabled',true);
        
    }else{
    	$('#inquery_state').addClass('label-success');
        $('#inquery_state').html('已完成');
        inquery_data = data.result;
        $('#submit').attr('disabled',true);
        $('#file').attr('disabled',true);
    }
    
}

$('#myModal').on('hidden.bs.modal', function (e) {
    $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
    $('.Leo_question').css('width','860px')
});  

$('#file').change(function(){
	var path = $('#file').val();
	path=path.replace('/','\\');
	var path_arr = path.split('\\');
    var filename = path_arr.pop();
    $('#filename').html('&nbsp;'+"文件名:"+filename);
}
)   
$("#submit").click(function(){   
	   var path = $("#file").val();
	   if(path == '' || path == undefined){
	   	      showError('请先选择要上传的文件');
	   	      return false;   
	   }
	   path=path.replace('/','\\');
	   var path_arr = path.split('\\');
       var filename = path_arr.pop();
       if(!checkFiles(filename)){
       	      showError('文件类型错误，请先下载模板！');
              return false;   
       }
        $('.Leo_question').css('width','843px');    
        $('.modal-body').html("<p class=\"bg-success\" style='padding:20px;'>系统正在导入需求量表，请勿关闭浏览器</p>"+"<div style='text-align:center; padding:5px 10px 10px 10px;'><img src='/image/loading.gif' style='width:300px' /></div>");
        $('.modal-footer').html('');
        $('#myModal').modal({keyboard:true, backdrop:'static'});
        $.ajaxFileUpload ({
        url:'/pm/uploadInquery', //你处理上传文件的服务端
        secureuri:false, //与页面处理代码中file相对应的ID值
        fileElementId:'file',
        dataType: 'json', //返回数据类型:text，xml，json，html,scritp,jsonp五种
        success: function (data) {
            if(data.error){
                showError(data.error);
            }else{
            $('.modal-body').html('');
            $('.modal-body').html( "<p class=\"bg-success\" style='padding:20px;'>项目需求量表配置完成!</p>");
            $('.modal-footer').html('');
            $('.modal-footer').html("<a href='/pm/inquery' type=\"button\" class=\"btn btn-success\">留在本页</a>"+
            "<a href='/pm/index' type=\"button\" class=\"btn btn-success\" >返回首页</button>"
            );
            
            $('#myModal').modal({keyboard:true, backdrop:'static'});
           }
        }

        });
});

$('#del').click(function(){
	$('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>确定要删除项目需求量表吗?</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                 	 "<button type=\"button\" class=\"btn btn-danger\" onclick='delinquery();'>确定</button>"+
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回</button>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
})    

function delinquery(){
	$('button').attr('disabled', true);
	 spinner = new Spinner().spin(target);
          $.post('/pm/delinquery', function(data) {
          	$('button').attr('disabled', false);
            if(spinner){ spinner.stop(); }
            if(data.error){
            	showError(data.error);
            	$('#submit').attr('disabled',true);
        $('#file').attr('disabled',true);
            }else{
            
            $('.modal-body').html('');
            $('.modal-body').html( "<p class=\"bg-success\" style='padding:20px;'>项目需求量表已删除!</p>");
            $('.modal-footer').html('');
            $('.modal-footer').html("<a href='/pm/inquery' type=\"button\" class=\"btn btn-success\">留在本页</a>"+
            "<a href='/pm/index' type=\"button\" class=\"btn btn-success\" >返回首页</button>"
            );
            
            $('#myModal').modal({keyboard:true, backdrop:'static'});
            }
        })
}

$('#search').click(function(){
	function count(o){
    var t = typeof o;
    if(t == 'string'){
            return o.length;
    }else if(t == 'object'){
            var n = 0;
            for(var i in o){
                    n++;
            }
            return n;
    }
    return false;
}; 
 
 
	$('.Leo_question').css('width','843px')
	        $('.modal-body').html('');
            $('.modal-body').html()
            var len = count(inquery_data);
            var str = '';
            for(var i = 0; i<len; i++ ){
            	str += ('<span style=\'color:red\'>题号</span>-'+ inquery_data[i].id+'-');
            	str += ('<span style=\'color:green\'>类型</span>-'+ (inquery_data[i].is_radio == 1 ? '[单选]':'[多选]')+'<br />');
            	str += ('<span style=\'color:blue\'>题目</span>-'+ inquery_data[i].topic+'<br />');
            	str += ('<span style=\'color:gray\'>选项</span>-'+ inquery_data[i].options+'<br /><br />');
            	
            }
            $('.modal-body').html(str);
            $('.modal-footer').html("<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回</button>"
                 );
            
            $('#myModal').modal({keyboard:true, backdrop:'static'});
})
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
function checkFiles(str)
{
     var strRegex = "(.xls|.xlsx)$";
     var re=new RegExp(strRegex);
     if (re.test(str.toLowerCase())){
         return true;
     }
     else{
         return false;
     }
}
</script>

   
