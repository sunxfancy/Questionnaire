<!--引入时间控件样式表-->
<link rel="stylesheet" href="/datetimepicker/bootstrap-datetimepicker.min.css" />
<!--引入时间控件js-->
<script type="text/javascript" src= '/datetimepicker/bootstrap.min.js'></script>
<script type="text/javascript" src="/datetimepicker/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
<!-- jqgrid 组件-->
<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<!--jqgrid 辅助-->
<script type="text/javascript" src="/jqGrid/js/jqgrid.assist.js"></script>
<!--文件上传 -->
<script src='/fileupload/ajaxfileupload.js'></script>
<!--pm 页面公用函数库-->
<script src='/js/pm.assit.js'></script>

<div style="width:100%;height:460px;overflow:hidden;">
    <table id="grid-table"></table>
    <div id="grid-pager"></div>   

    <div style="width:100%;height:40px;text-align:center; margin: 5px 10px;">
            <div class="form-group" style='display:inline-block;'>
                <a class="btn btn-info" href="/template/interviewer.xls" style='width:150px;'>
                	<i class="glyphicon glyphicon-collapse-down"></i>
                	导入模板下载</a>
            </div>
            &nbsp;&nbsp;
            <div class='form-group' style='display:inline-block;'>
            <span class="btn btn-success fileinput-button" style='width:150px;'>
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>上传面询专家列表</span>
                    <input onchange = 'checkFile1();' accept="application/msexcel" type="file" id='file1' name='file1' style='opacity:0; position:absolute; top:0;left:0;cursor:pointer; width:150px;'>
            </span>
            <span class="label label-default" id='file1_state'>未选择</span>
            </div>
            &nbsp;&nbsp;
            <div class='form-group' style='display:inline-block;'>
            <button id='submit1' type='button' class="btn btn-danger start" style='width:150px;'>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>导入</span>
            </button>
            </div>
            &nbsp;&nbsp;
            <div class='form-group' style='display:inline-block;'>
            <button type='button' onclick ='exportInterviewers()' class="btn btn-primary start" style='width:150px;'>
                    <i class="glyphicon glyphicon-download"></i>
                    <span>导出</span>
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
$('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});  
$(function(){
	$('#submit1').attr('disabled',true);
    getInfo();
    function getInfo(){
        var lastsel;
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";
        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
            $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        });
        //resize on sidebar collapse/expand
        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
            if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
                $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
            }
        })
        
        jQuery(grid_selector).jqGrid({
            url: "/pm/listinterviewer",
            editurl: "/pm/updateinterviewer",
            datatype: "json",
            height: '270px',
            shrinkToFit:false,
            hidegrid:false,
            autowidth:true,
            colModel:[
                     {   name:'id',  label:'用户id',  index:'id',  width:100, fixed:true, resizable:false, editable:false,sortable:false, sorttype:"int", align:'center',
                         hidden:true,
                     },
                     {   name:'username',  label:'专家编号',  index:'username',  width:140, fixed:true, resizable:false, editable:true,sortable:true, sorttype:"int", align:'center',
                         search:true, searchoptions: { sopt: ['eq'], },
                         searchrules:{ required: true, integer:true,},
                         //设为可编辑，显示时再设为不可变
                         editoptions:{ 
                            dataInit:function(element) { 
                            $(element).attr('disabled', 'disabled');
                            
                            } 
                         }
                     },
                     
                     {  name:'name', label:'姓名',  index:'name', width:120, fixed:true, resizable:false,  editable:true,sortable:true, align:'center',
                        editrules:{required : true, }, 
                        search:true, searchoptions: {  sopt: ['eq']  },
                        searchrules:{ required: true, },
                     },

                     {  name:'password', label:'用户密码', index:'password', width:120, fixed:true, resizable:false, sortable:false, editable:true, align:'center',
                        editrules:{required : true, }, 
                        search:false, 
                     },
                     {  name:'last_login', label:'最后登录时间', index:'last_login', width:240, fixed:true, resizable:false,  sortable:true, sorttype:'date',editable:false, align:'center',
                        search:true, searchoptions: {  sopt: ['bw', 'ew'],
                        dataInit:function(element) { 
                            $(element).parent().addClass("input-group date form_date");
                            $(element).addClass('form-control');
                            $(element).datetimepicker({
                                language: 'zh-CN', //汉化 
                                format:'yyyy-mm-dd' , 
                                autoclose:true,
                                minView:2,
                            }); 
                            
                            } 
                         },
                         searchrules:{required:true,}
                       
                     },
                     {  name:'count', label:'面询完成情况', index:'count', sortable:false,width:110, fixed:true, resizable:false, editable:false,align:'center',
                        search:false, 
                     }, 
                     {  name:'fenpei', label:'配置', index:'fenpei', sortable:false,width:110, fixed:true, resizable:false, editable: false,align:'center',
                        search:false,
                        sortable:false,
                        viewable:true,
                        formatter:function(cellvalue,options,rowObject){
                            return "<div class='ui-pg-div' data-original-title='查看及配置面询情况'><span style='visibility:hidden;'>&nbsp;</span><a href='/pm/userdivide/"+rowObject.id+"'><i class=\"glyphicon glyphicon-cog\"></i></a><span style='visibility:hidden;'>&nbsp;</span></div>"
                        },
                     },                     
            ], 
            viewrecords : true, 
            rowNum:20,
            rowList:[20,40,60,80,100,120,140,160,180,200],
            pager : pager_selector,
            altRows: true,
            emptyrecords: "<span style='color:red'>还未添加记录</span>", 
            loadComplete : function(data) {
                if(data.error){
                         $('.Leo_question').css('width','843px')
                         $('.modal-body').html('');
                         $('.modal-body').html(
                         "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                         );
                        $('.modal-footer').html('');
                        $('.modal-footer').html(
                         "<a href='/managerlogin'><button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'>重新登录</button></a>"
                        );
                        $('#myModal').modal({
                         keyboard:true,
                         backdrop:'static'
                       })
                }
                var table = this;
                setTimeout(function(){
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            reloadAfterSubmit:true,
            caption: "项目管理",
            multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,
    
        });
        
        //navButtons
        var add_options={
                    left:10,
                    top:10,
                    afterSubmit:function(res,rowid){
                        var result = eval('(' + res.responseText + ')');   
                        if(result.error) {
                        $('.Leo_question').css('width','843px')
                         $('.modal-body').html('');
                         $('.modal-body').html(
                         "<p class=\"bg-danger\" style='padding:20px;'>"+result.error+ "</p>"
                         );
                        $('.modal-footer').html('');
                        $('.modal-footer').html(
                         "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">返回修改</button>"
                        );
                        $('#myModal').modal({
                         keyboard:true,
                         backdrop:'static'
                       })

                       // return false; 返回jqgrid相关的数据格式
                        return [false, 'fail',0];   
                        }else{
                        $('.Leo_question').css('width','843px')
                         $('.modal-body').html('');
                         $('.modal-body').html(
                         "<p class=\"bg-success\" style='padding:20px;'>记录添加成功</p>"
                         );
                        $('.modal-footer').html('');
                        $('.modal-footer').html(
                         "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">关闭提示</button>"
                        );
                        $('#myModal').modal({
                         keyboard:true,
                         backdrop:'static'
                      })
                        return [true, 'success'];
                        }
                    },
                    beforeShowForm : function(e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                    .wrapInner('<div class="widget-header" />')
                    //password 不可编辑
                    $('#password').attr('disabled', true);
                    $('#password').val('**系统自动生成**');
                    style_edit_form(form);
                    },
                    reloadAfterSubmit:true,
                    closeAfterAdd:true
 
        };
        var edit_options={
                    left:10,
                    top:10,
                    afterSubmit:function(res,rowid){
                        var result = eval('(' + res.responseText + ')');   
                        if(result.error) {
                        $('.Leo_question').css('width','843px')
                         $('.modal-body').html('');
                         $('.modal-body').html(
                         "<p class=\"bg-danger\" style='padding:20px;'>"+result.error+ "</p>"
                         );
                        $('.modal-footer').html('');
                        $('.modal-footer').html(
                         "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">返回修改</button>"
                        );
                        $('#myModal').modal({
                         keyboard:true,
                         backdrop:'static'
                       })

                       // return false; 返回jqgrid相关的数据格式
                        return [false, 'fail',0];   
                        }else{
                        $('.Leo_question').css('width','843px')
                         $('.modal-body').html('');
                         $('.modal-body').html(
                         "<p class=\"bg-success\" style='padding:20px;'>记录更新成功</p>"
                         );
                        $('.modal-footer').html('');
                        $('.modal-footer').html(
                         "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">关闭提示</button>"
                        );
                        $('#myModal').modal({
                         keyboard:true,
                         backdrop:'static'
                      })
                        return [true, 'success'];
                        }
                    },
                    beforeShowForm : function(e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                    .wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                    },
                    reloadAfterSubmit:true,
                    closeAfterEdit:true
 
        };
        var del_options = {
                top : 80,  //位置
                left: 300, //位置
                reloadAfterSubmit: true,
                recreateForm: true,
                beforeShowForm : function(e) {
                    var form = $(e[0]);
                    if(form.data('styled')) return false;
                    
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_delete_form(form);
                    
                    form.data('styled', true);
                },
                closeAfterDelete: true,
                afterSubmit : function(response, postdata){
                    var result = eval('(' + response.responseText + ')');  
                    if(result.error){
                         $('.Leo_question').css('width','843px')
                         $('.modal-body').html('');
                         $('.modal-body').html(
                         "<p class=\"bg-danger\" style='padding:20px;'>"+result.error+ "</p>"
                         );
                        $('.modal-footer').html('');
                        $('.modal-footer').html(
                         "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">返回修改</button>"
                        );
                        $('#myModal').modal({
                         keyboard:true,
                         backdrop:'static'
                       })

                       // return false; 返回jqgrid相关的数据格式
                        
                       return [true,"修改失败",0];
                    }else{
                        $('.Leo_question').css('width','843px')
                         $('.modal-body').html('');
                         $('.modal-body').html(
                         "<p class=\"bg-success\" style='padding:20px;'>记录删除成功</p>"
                         );
                        $('.modal-footer').html('');
                        $('.modal-footer').html(
                         "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">关闭提示</button>"
                        );
                        $('#myModal').modal({
                         keyboard:true,
                         backdrop:'static'
                      })

                      // return true;

                      return [true,""]
                    }
                 },
        }
        jQuery(grid_selector).jqGrid('navGrid',pager_selector,
            {   //navbar options
               add: true,
           addicon : 'ace-icon fa fa-plus-circle purple',
           addtext:'添加',
                edit: true,
                editicon : 'ace-icon fa fa-pencil blue',
                edittext:'编辑',
                del: true,
                delicon : 'ace-icon fa fa-trash-o red',
                deltext:'删除',
                refresh: true,
                refreshicon : 'ace-icon fa fa-refresh green',
                refreshtext:'刷新',
                search:true,
                searchicon : 'ace-icon fa fa-search orange',
                searchtext:'搜索',
                view: true,
                viewicon : 'ace-icon fa fa-search-plus grey',
                viewtext:'查看',
                
            },
            //edit,
            edit_options,
            //add
            add_options,
            //del
            del_options,
            {//search
                top : 80,  //位置
                left: 300, //位置 
                multipleSearch: false,
                caption:'搜索查询...',
                Reset: '重置',
                Find:'查询',
                closeAfterSearch:true,
                afterShowSearch: function(e){
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                    style_search_form(form);
                },
            },
            {//view
                top : 10,  //位置
                left: 10, //位置 
             }, 
             {//refresh
                
             }
            
        );
           
}
});

//$('#file1').change(function(){
//	console.log('444');
 //   checkFile1();
//}) 


$('#submit1').click(function(){
      var path = $("#file1").val();
       if(path == '' || path == undefined){
              showError('请先选择要上传的文件');
              return false;   
       }
       path=path.replace('/','\\');
       var path_arr = path.split('\\');
       var filename = path_arr.pop();
       if(!checkFileType(filename)){
              showError('文件类型错误，请先下载模板！');
              return false;   
       }
        $('.Leo_question').css('width','843px');    
        $('.modal-body').html("<p class=\"bg-success\" style='padding:20px;'>系统正在导入专家列表，请勿关闭浏览器</p>"+"<div style='text-align:center; padding:5px 10px 10px 10px;'><img src='/image/loading.gif' style='width:300px' /></div>");
        $('.modal-footer').html('');
        $('#myModal').modal({keyboard:true, backdrop:'static'});
        $.ajaxFileUpload ({
        url:'/pm/uploadInterviewer', //你处理上传文件的服务端
        secureuri:false, //与页面处理代码中file相对应的ID值
        fileElementId:'file1',
        dataType: 'json', //返回数据类型:text，xml，json，html,scritp,jsonp五种
        success: function (data) {
            if(data.error){
                showError(data.error);
            }else{
            clearFileInput(document.getElementById('file1'));
            checkFile1();
            jQuery("#grid-table").trigger("reloadGrid");
            $('.modal-body').html('');
            $('.modal-body').html( "<p class=\"bg-success\" style='padding:20px;'>专家信息导入完成!</p>");
            $('.modal-footer').html('');
            $('.modal-footer').html("<button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">关闭提示</button>"
            );
            $('#myModal').modal({keyboard:true, backdrop:'static'});
            //成功返回后的操作
           }

        }
        });
})

function checkFile1(){
    if($('#file1').val() != ''){
        $('#file1_state').removeClass('label-default');
        $('#file1_state').addClass('label-success');
        $('#file1_state').html('已选择');
        $('#submit1').attr('disabled', false);
    }else{
        $('#file1_state').removeClass('label-success');
        $('#file1_state').addClass('label-default');
        $('#file1_state').html('未选择');
        $('#submit1').attr('disabled', true);
   }
} 

function exportInterviewers(){
	downloadWait('正在生成面询专家列表');
    $.post('/file/exportRole/2', function(data){
        if (data.error){
            downloadError(data.error);
        }else {
            var msg = "<a href='"+data.success.substr( 1, data.success.length-1)+"'>面询专家列表</a>";
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
</script>