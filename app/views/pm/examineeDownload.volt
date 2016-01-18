<script type="text/javascript" src="/js/bootstrap.js"></script>
<!-- multi file upload  -->
<script type="text/javascript" src='/fileupload/plupload-2.1.8/js/plupload.full.min.js'></script>

<!-- debug 
<script type="text/javascript" src="/fileupload/plupload-2.1.8/js/moxie.js"></script>
<script type="text/javascript" src="/fileupload/plupload-2.1.8/js/plupload.dev.js"></script>
-->
<div class="Leo_question" style="overflow:auto;padding-top:25px;">
    <div class="form-group" style='display:inline-block;'>
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">被试人员列表</div>
    </div> 
    <div class='form-group' style='display:inline-block;float:right;margin-right:40px;'>
        <form action='/pm' class="form-inline" method='post'>
            <input id='page' value='1' name='page' type='hidden'/>
            <button type='submit' class='btn btn-success' style='width:100px;'>
            <i class="glyphicon glyphicon-fast-backward"></i>&nbsp;返回上层</button>
        </form>
    </div> 
    <div style="display:block;">
    <div class='form-group' style='margin-left:40px;display:inline-block;'>
            <button class="btn btn-primary" onclick='exportExaminees()' style='width:100px;' type='button'>
                <i class="glyphicon glyphicon-download"></i>&nbsp;列表下载
            </button>
    </div> 
    <div class='form-group' style='margin-left:40px;display:inline-block;'>
            <button class="btn btn-primary" onclick='exportExamineesSimple()' style='width:100px;' type='button'>
                <i class="glyphicon glyphicon-download"></i>&nbsp;简表下载
            </button>
    </div>
     </div>
    <div class="form-group">
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">批量下载</div>
    </div>  
<div style="height:40px;margin-left:40px;">
    <div class='form-group' style='display:inline-block;'>
        <button  type='button' onclick="oneKeyCalculate()" class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-send"></i>&nbsp;一键算分
        </button>
        <span class="label label-default" id='score'>未完成</span>
    </div>
</div>
<div style="height:40px;margin-left:40px;">
  <div class='form-group' style='display:inline-block;'>
     <button  type='button' onclick="tenSheetDownload()" class="btn btn-primary start" style=''>
            <i class="glyphicon glyphicon-send"></i>&nbsp;十项报表下载
        </button>
    </div>
</div>
<div style="height:40px;margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>个人综合素质报告
    </div>
     &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button  onclick="oneKeyReport(1)" type='button' class="btn btn-primary start" style='width:100px;'>
             <i class="glyphicon glyphicon-send"></i>&nbsp;一键生成
        </button>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id="onekeys1" onclick="downloadZip(1,1)" type='button' class="btn btn-primary start" style='width:150px;'>
            <i class="glyphicon glyphicon-download"></i>&nbsp;原始版打包下载
        </button>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button id="onekeyd1" onclick="downloadZip(2,1)" type='button' class="btn btn-primary start" style='width:150px;'>
            <i class="glyphicon glyphicon-download"></i>&nbsp;修改版打包下载
        </button>
    </div>
</div>
<div style="height:40px; margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" ><i class='glyphicon glyphicon-tag' style='font-size:15px;'></i></span>个人胜任力报告<span style='visibility: hidden'>位</span>
    </div>
     &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button  onclick="oneKeyReport(2)" type='button' class="btn btn-primary start" style='width:100px;'>
             <i class="glyphicon glyphicon-send"></i>&nbsp;一键生成
        </button>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button  onclick="downloadZip(1,2)" type='button' class="btn btn-primary start" style='width:150px;'>
             <i class="glyphicon glyphicon-download"></i>&nbsp;原始版打包下载
        </button>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <button  onclick="downloadZip(2,2)"type='button' class="btn btn-primary start" style='width:150px;'>
            <i class="glyphicon glyphicon-download"></i>&nbsp;修改版打包下载
        </button>
    </div>
</div>
<div class="form-group">
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">批量上传</div>
</div>  
<div id = 'container_1' style="height:40px;margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" >
        	<i class='glyphicon glyphicon-tag' style='font-size:15px;'></i>
        </span>
                      个人综合素质报告
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a id="pickfile_1" href="javascript:;">
        	<span class="btn btn-success " style='width:100px;'>
            <i class="glyphicon glyphicon-plus"></i>
            <span>选择文件</span>
            </span>
        </a> 
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
         <a id="uploadfile_1" href="javascript:;">
         <span  class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-upload"></i>
            <span>开始上传</span>
         </span>
        </a>
    </div>
      &nbsp;&nbsp;
     <div class='form-group' style='display:inline-block;'>
         <button onclick='checkUploaded(this)' id = 'check_1' class="btn btn-warning start" style='width:100px;'>
            <i class="glyphicon glyphicon-search"></i>
            <span>查看</span>
         </button>
    </div>
</div>

<div id = 'container_2' style="height:40px;margin-left:40px;">
    <div class="form-group" style='display:inline-block;font-size:20px;'>
        <span class="text-primary" >
            <i class='glyphicon glyphicon-tag' style='font-size:15px;'></i>
        </span>
                      个人胜任力报告<span style='visibility: hidden;'>占</span>
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
        <a id="pickfile_2" href="javascript:;">
            <span class="btn btn-success" style='width:100px;'>
            <i class="glyphicon glyphicon-plus"></i>
            <span>选择文件</span>
            </span>
        </a> 
    </div>
    &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
         <a id="uploadfile_2" href="javascript:;">
         <span  class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-upload"></i>
            <span>开始上传</span>
         </span>
        </a>
    </div>
      &nbsp;&nbsp;
    <div class='form-group' style='display:inline-block;'>
         <button onclick='checkUploaded(this)' id = 'check_2' class="btn btn-warning start" style='width:100px;'>
            <i class="glyphicon glyphicon-search"></i>
            <span>查看</span>
         </button>
    </div>
    
</div>
    <div  class='form-group' id="filelist" style="height:40px;margin: 10px 40px;text-align:center;">       
    </div>
    <div  class='form-group' id="console"  style="height:40px;margin: 10px 40px;text-align:center;">    
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
 
// plupload 

var uploader_1 = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'pickfile_1', // you can pass an id...
    container: document.getElementById('container_1'), // ... or DOM Element itself
    url : '/file/fileUploadv2/1',
    flash_swf_url : '/fileupload/plupload-2.1.8/js/Moxie.swf',
    silverlight_xap_url : '/fileupload/plupload-2.1.8/js/Moxie.xap',
    
    filters : {
        max_file_size : '40mb',
        mime_types: [
            // {title : "word files", extensions : "docx"},

        ]
    },

    init: {
        PostInit: function() {
            document.getElementById('filelist').innerHTML = '';
            document.getElementById('uploadfile_1').onclick = function() {
                uploader_1.start();
                return false;
            };
        },

        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                document.getElementById('filelist').innerHTML += 
                "<table class=\"table table-hover\" style='margin-bottom:0;' ><tr><td style='width:100px;'>综合</td><td style='width:480px;'>"+file.name+'(' + plupload.formatSize(file.size) + ')' + "</td><td style='width:200px;'><b  id = "+file.id+"></b></td></tr></table>"
            });
        },

        UploadProgress: function(up, file) {
            //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },
        FileUploaded:function(up,file,result){
        	result = eval('('+result.response+')');
        	if (result.error){
        		 document.getElementById(file.id).innerHTML = '<span style=\'color:red;\'>' + result.error+'</span>';
        	}else{
        		  document.getElementById(file.id).innerHTML = '<span style=\'color:green;\'>上传成功</span>';
        	}
      
        },
        // Error: function(up, err) {
            // document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
        // }

    }
});

uploader_1.init();

var uploader_2 = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'pickfile_2', // you can pass an id...
    container: document.getElementById('container_2'), // ... or DOM Element itself
    url : '/file/fileUploadv2/2',
    flash_swf_url : '/fileupload/plupload-2.1.8/js/Moxie.swf',
    silverlight_xap_url : '/fileupload/plupload-2.1.8/js/Moxie.xap',
    
    filters : {
        max_file_size : '40mb',
        mime_types: [
            // {title : "word files", extensions : "docx"},

        ]
    },

    init: {
        PostInit: function() {
            document.getElementById('filelist').innerHTML = '';
            document.getElementById('uploadfile_2').onclick = function() {
                uploader_2.start();
                return false;
            };
        },

        FilesAdded: function(up, files) {
             plupload.each(files, function(file) {
                document.getElementById('filelist').innerHTML += 
                "<table class=\"table table-hover\"  style='margin-bottom:0;'><tr><td style='width:100px;'>胜任力</td><td style='width:480px;'>"+file.name+'(' + plupload.formatSize(file.size) + ')' + "</td><td style='width:200px;'><b  id = "+file.id+"></b></td></tr></table>"
             });
        },

        UploadProgress: function(up, file) {
            //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },
        FileUploaded:function(up,file,result){
        	result = eval('('+result.response+')');
            if (result.error){
                 document.getElementById(file.id).innerHTML = '<span style=\'color:red;\'>' + result.error+'</span>';
            }else{
                  document.getElementById(file.id).innerHTML = '<span style=\'color:green;\'>上传成功</span>';
            }
      
       
},
        // Error: function(up, err) {
            // document.getElementById('console').innerHTML +=
            	 // "<table class=\"table table-hover\"><tr><td>Error:"+err.message+ "</td><td><b>文件类型错误</b></td></tr></table>"
            // ;
        // }

    }
});

uploader_2.init();


//已上传文件的情况查询
function checkUploaded(args){
	 var number = args.id.substr( args.id.length-1, 1);
	  $.post('/file/getIndividualReportState/'+number,function(data) { 
	  	if (data.error){
	  		downloadError(data.error);
	  	}else{
	  		var msg ='';
	  		if (number == 1 ){
	  			msg +='个体综合报告上传结果统计';
	  		}else{
	  			msg +='个体胜任力报告上传结果统计';
	  		}
            msg += "<table class=\"table table-hover\"  style='margin-bottom:0;margin-top:0;'>";
            msg +='<caption><b style=\'color:red;\'>未上传名单</b></caption>';
	  		var not = data.success.not;
	  		for(var i = 0, len = not.length; i < len; i++ ){
	  			msg+=('<tr><td>'+not[i]+'</td></tr>');
	  		}
	  		msg +='</table>';
	  		msg +='<br />';
	  		msg += "<table class=\"table table-hover\"  style='margin-bottom:0;'>";
            msg +='<caption><b style=\'color:green;\'>已上传名单</b></caption>';
	  		var ok = data.success.ok;
	  		console.log(ok.length);
	  		for(var i =0, len = ok.length; i <len; i ++ ){
	  			msg+=('<tr><td>'+ok[i]+'</td></tr>');
	  		}
	  		msg +='</table>';
	  		downloadSuccess(msg);
	  	}
	  })
}
//打包下载控制
function downloadZip(type, newold){
    $.post('/file/packageFiles/'+type+'/'+newold, function(data){
        if(data.error){
        	if (isArray(data.error)){
        		//打印未完成名单
        	var msg ='';
            if (type == 1 &&  newold  == 1 ){
                msg +='如下人员个体综合报告未生成';
            }else if(type == 1 &&  newold  == 2 ){
                msg +='如下人员个体胜任力报告未生成';
            }else if(type == 2 &&  newold  == 1 ){
                msg +='如下人员个体综合报告修改版未上传';
            }else if(type == 2 &&  newold  == 2 ){
                msg +='如下人员个体胜任力报告修改版未上传';
            }
            msg += "<table class=\"table table-hover\"  style='margin-bottom:0;margin-top:0;'>";
            msg +='<caption><b style=\'color:red;\'></b></caption>';
            var not = data.error;
            for(var i = 0, len = not.length; i < len; i++ ){
                msg+=('<tr><td>'+not[i]+'</td></tr>');
            }
            msg +='</table>';
            downloadError(msg);        		
        	}else{
        		//打印错误信息
        		downloadError(data.error);
        	}
        }else{
        	var msg ='';
            if (type == 1 &&  newold  == 1 ){
                msg ='个体综合报告打包下载';
            }else if(type == 1 &&  newold  == 2 ){
                msg ='个体胜任力报告打包下载';
            }else if(type == 2 &&  newold  == 1 ){
                msg ='个体综合报告修改版打包下载';
            }else if(type == 2 &&  newold  == 2 ){
                msg ='个体胜任力报告修改版打包下载';
            }
            msg = "<a href='"+data.success.substr( 1, data.success.length-1)+"'>"+msg+"</a>";
            downloadSuccess(msg);
        }
    })
}
function isArray(o) {  
  return Object.prototype.toString.call(o) === '[object Array]';   
} 

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
                    "<a href='/managerlogin'><button type=\"button\" class=\"btn btn-primary\" >重新登录</button></a>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
        }else{
            if(spinner){ spinner.stop(); }
            // datadeal(data.success);  
            if (data.success == 'true'){
            	  $('#score').removeClass('label-default');
            	  $('#score').addClass('label-success');
                  $('#score').html('已完成');
                  
            }else {
            	  $('#score').removeClass('label-success');
            	  $('#score').addClass('label-default');
                  $('#score').html('未完成');
            }     
            
        }
    })
}

function oneKeyCalculate(){
    downloadWait('正在计算所有被试人员测评得分！');
    $.post('/pm/oneKeyCalculate', function(data){
        if (data.error){
            if (isArray(data.error)){
                //打印未完成名单
            var msg ='一键算分失败';
            msg += "<table class=\"table table-hover\"  style='margin-bottom:0;margin-top:0;'>";
            msg +='<caption><b style=\'color:red;\'></b></caption>';
            var not = data.error;
            for(var i = 0, len = not.length; i < len; i++ ){
                msg+=('<tr><td>'+not[i]+'</td></tr>');
            }
            msg +='</table>';
            downloadError(msg);             
            }else{
                //打印错误信息
                downloadError(data.error);
            }
        }else{
            downloadSuccess('一键算分完成');
        }
    });
}
function oneKeyReport(number){
	if (number == 1 ){
		   downloadWait('正在生成所有被试人员个人综合素质报告！');
	}else if ( number == 2 ){
		  downloadWait('正在生成所有被试人员个人胜任力报告！');
	}else{
		alert('参数错误');
	}
    $.post('/file/getAllIndividualComprehesive/'+number, function(data){
        if(data.error){
            if (isArray(data.error)){
                //打印失败原因
            var msg ='一键生成失败：';
            msg += "<table class=\"table table-hover\"  style='margin-bottom:0;margin-top:0;'>";
            msg +='<caption><b style=\'color:red;\'></b></caption>';
            var not = data.error;
            for(var i = 0, len = not.length; i < len; i++ ){
                msg+=('<tr><td>'+not[i]+'</td></tr>');
            }
            msg +='</table>';
            downloadError(msg);             
            }else{
                //打印错误信息
                downloadError(data.error);
            }
        }else{
            downloadSuccess('一键生成成功');
        }

    });
}

function downloadAllComprehensive(){
    downloadWait('正在生成所有被试人员个人综合素质报告！');
    $.post('/file/getAllIndividualComprehesive', function(data){
          if(data.error){
            if (isArray(data.error)){
                //打印失败 
            var msg ='';
            if (type == 1 &&  newold  == 1 ){
                msg +='如下人员个体综合报告未生成';
            }else if(type == 1 &&  newold  == 2 ){
                msg +='如下人员个体胜任力报告未生成';
            }else if(type == 2 &&  newold  == 1 ){
                msg +='如下人员个体综合报告修改版未上传';
            }else if(type == 2 &&  newold  == 2 ){
                msg +='如下人员个体胜任力报告修改版未上传';
            }
            msg += "<table class=\"table table-hover\"  style='margin-bottom:0;margin-top:0;'>";
            msg +='<caption><b style=\'color:red;\'></b></caption>';
            var not = data.error;
            for(var i = 0, len = not.length; i < len; i++ ){
                msg+=('<tr><td>'+not[i]+'</td></tr>');
            }
            msg +='</table>';
            downloadError(msg);             
            }else{
                //打印错误信息
                downloadError(data.error);
            }
        }else{
            var msg ='';
            if (type == 1 &&  newold  == 1 ){
                msg ='个体综合报告打包下载';
            }else if(type == 1 &&  newold  == 2 ){
                msg ='个体胜任力报告打包下载';
            }else if(type == 2 &&  newold  == 1 ){
                msg ='个体综合报告修改版打包下载';
            }else if(type == 2 &&  newold  == 2 ){
                msg ='个体胜任力报告修改版打包下载';
            }
            msg = "<a href='"+data.success.substr( 1, data.success.length-1)+"'>"+msg+"</a>";
            downloadSuccess(msg);
        }
    })
}
function exportExaminees(){
	downloadWait('正在生成被试人员列表');
    $.post('/file/exportRole/1', function(data){
        if (data.error){
            downloadError(data.error);
        }else {
        	var msg = "<a href='"+data.success.substr( 1, data.success.length-1)+"'>被试人员列表</a>";
            downloadSuccess(msg);
        }
    });
}

function exportExamineesSimple(){
    downloadWait('正在生成被试人员列表');
    $.post('/file/exportRole/4', function(data){
        if (data.error){
            downloadError(data.error);
        }else {
            var msg = "<a href='"+data.success.substr( 1, data.success.length-1)+"'>被试人员列表</a>";
            downloadSuccess(msg);
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
function isObject(obj){

    return (typeof obj=='object')&&obj.constructor==Object;

} 



function tenSheetDownload(){

   downloadWait('正在生成个人十项报表数据：');

    $.post('/file/getpersonalresultsbyproject', function(data){

        if (data.error){

           if(isObject(data.error)){

               var msg ='';

            msg += "<table class=\"table table-hover\"  style='margin-bottom:0;margin-top:0;'>";

            var not = data.error.error;

            if(not.length != 0 ){

                msg +='<caption><b style=\'color:red;\'>十项报表生成失败：</b></caption>';

               for(var i = 0, len = not.length; i < len; i++ ){

                msg+=('<tr><td>'+not[i]+'</td></tr>');

                }

            }

            msg +='</table>';

            downloadError(msg); 

           }else{

                downloadError(data.error);

           }

        }else {

           // var msg = "鐐瑰嚮涓嬭浇<a href='"+data.success.substr( 1, data.success.length-1)+"'></a>";

            var msg = "请点击下载<a href='"+data.success.success.substr( 1, data.success.success.length-1)+"'>个人十项报表 </a>";

            downloadSuccess(msg);

        }

    });

}



</script>

   
