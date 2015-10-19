<script type="text/javascript" src="/js/bootstrap.js"></script>
<!-- multi file upload  -->
<script type="text/javascript" src='/fileupload/plupload-2.1.8/js/plupload.full.min.js'></script>

<!-- debug 
<script type="text/javascript" src="/fileupload/plupload-2.1.8/js/moxie.js"></script>
<script type="text/javascript" src="/fileupload/plupload-2.1.8/js/plupload.dev.js"></script>
-->
<div class="Leo_question" style="overflow:auto;padding-top:25px;">
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
            <a class="btn btn-primary" style='width:200px;'  href="/pm/examineeExport"  type='button'>
                <i class="glyphicon glyphicon-download"></i>&nbsp;所有被试信息列表
            </a>
    </div> 
    <div class="form-group">
        <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">批量下载</div>
    </div>  
<div style="height:40px;margin-left:40px;">
    <div class='form-group' style='display:inline-block;'>
        <button id="onekeyc" type='button' onclick="oneKeyCalculate()" class="btn btn-primary start" style='width:100px;'>
            <i class="glyphicon glyphicon-send"></i>&nbsp;一键算分
        </button>
        <span class="label" id='score'></span>
    </div>
</div>
<div style="height:40px;margin-left:40px;">
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
<div style="height:40px; margin-left:40px;">
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
	  			msg +='个体综合报告修改结果统计';
	  		}else{
	  			msg +='个体胜任力报告修改结果统计';
	  		}
            msg += "<table class=\"table table-hover\"  style='margin-bottom:0;margin-top:0;'>";
            msg +='<caption><b style=\'color:red;\'>未修改名单</b></caption>';
	  		var not = data.success.not;
	  		for(var i = 0, len = not.length; i < len; i++ ){
	  			msg+=('<tr><td>'+not[i]+'</td></tr>');
	  		}
	  		msg +='</table>';
	  		msg +='<br />';
	  		msg += "<table class=\"table table-hover\"  style='margin-bottom:0;'>";
            msg +='<caption><b style=\'color:green;\'>已修改名单</b></caption>';
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

   
