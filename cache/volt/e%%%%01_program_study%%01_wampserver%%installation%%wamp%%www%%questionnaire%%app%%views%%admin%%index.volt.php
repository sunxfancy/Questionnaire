<link rel="stylesheet" type="text/css" href="/css/css/Leo_projects_css.css" />
<!--引入时间控件样式表-->
<link rel="stylesheet" href="/datetimepicker/bootstrap-datetimepicker.min.css" />
<!--引入时间控件js-->
<script type='text/javascript' src='/datetimepicker/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src= '/datetimepicker/bootstrap.min.js'></script>
<script type="text/javascript" src="/datetimepicker/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
<!-- jqgrid 组件-->
<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<!--jqgrid 辅助-->
<script type="text/javascript" src="/jqGrid/js/jqgrid.assist.js"></script>

<div class="Leo_question">
	<div style="padding:10px 40px;text-align:right;">
    <a href='/admin/addnew' type='button' class="btn btn-success" style='padding:5px 40px;'>添加新项目</a>
    </div>
<div style="text-align:center;height:448px;overflow:hidden;">
		<table id="grid-table"></table>
		<div id="grid-pager" style='height:80px;'></div>
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
    getInfo();
});

function name_check(value, colName){
    var id = $("#grid-table").jqGrid('getGridParam','selrow');
	var rt_array ;
	$.ajax({
		  type: 'POST',
		  url: '/admin/namecheck',
		  async: false,
		  data:  {name:value,id:id},
		  success: function(data){
	             if(data.flag){
	                rt_array = [false, colName+"列"+value+'已存在,请修改'];
	             }else{
	                rt_array =  [true, ""] ;
	             }
             }
        });
	 return rt_array;
}
function manager_username_check(value,colName){
	var id = $("#grid-table").jqGrid('getGridParam','selrow');
	var rt_array ;
	$.ajax({
          type: 'POST',
          url: '/admin/managerusernamecheck',
          async: false,
          data: {username:value, id:id},
          success: function(data){
			        if(data.flag){
			           rt_array = [false, colName+"列"+value+'已存在,请修改'];
			        }else{
			           rt_array = [true, ""] ;
			        }
                  }   
        });
     return rt_array;
}

function endtime_check (value,colName) {
    var pattern = new RegExp("^[1-9][0-9]{3}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])[ ](0?[0-9]|1[0-9]|2[0-3])[:](0?[0-9]|[1-5][0-9])[:](0?[0-9]|[1-5][0-9])$");
    if (value.match(pattern) ) {
    	//判断开始时间
    	  var id = $("#grid-table").jqGrid('getGridParam','selrow');
          var starttime = $('#grid-table').getCell(id,'begintime');
          if(value <= starttime){
          	return [false, colName+"不得早于开始时间"];
          }else{
          	  return [true, ""];
          }
    }else{
        return [false, colName+"时间设定不合理"];
    }
}

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
			url: "/admin/list",
			editurl:'/admin/update',
			datatype: "json",
			height:'306px',
			shrinkToFit:false,
			hidegrid:false,
		    autowidth:true,
			colModel:[
			         {   name:'id',  label:'项目编号',  index:'id',  width:100, fixed:true, resizable:false, editable:false,sortable:false, sorttype:"int", align:'center',
                         search:true, searchoptions: { sopt: ['eq'], },
                         searchrules:{ required: true, integer:true,},
                         hidden:true,
                     },
			         {   name:'id',  label:'项目编号',  index:'id',  width:100, fixed:true, resizable:false, editable:true,sortable:false, sorttype:"int", align:'center',
                         search:true, searchoptions: { sopt: ['eq'], },
                         searchrules:{ required: true, integer:true,},
                         //设为可编辑，显示时再设为不可变
                         editoptions:{ 
                            dataInit:function(element) { 
                            $(element).attr('disabled', 'disabled');
                            
                            } 
                         }
                     },
			         
				     {   name:'',label:'详情', index:'', width:60, fixed:true, resizable:false, editable:false, sortable:false, align:'center',
                         search:false,
                         formatter:function(cellvalue, options, rowObject){
                            return "<div class='ui-pg-div ui-inline-edit' data-original-title='查看详细信息'><a href='/admin/detail/"+rowObject.id+"'><i class='fa fa-th-list'></i></a></div>"
                         },
                         viewable:false,
                     },
                     {  name:'name', label:'项目名称',  index:'name', width:200, fixed:true, resizable:false,  editable:true,sortable:false, sorttype:"string", align:'center',
                        editrules:{required : true, custom:true, custom_func:name_check}, 
                        search:true, searchoptions: {  sopt: ['eq']  },
                        searchrules:{ required: true, },
                     },
                     {  name:'manager_name', label:'经理', index:'manager_name', width:100, fixed:true, resizable:false, sortable:false,  editable:true,align:'center',
                        editrules:{required : true} ,
                        search:true, searchoptions: {  sopt: ['eq']  },
                        searchrules:{ required: true, },
                     },
                     {  name:'manager_username', label:'经理账号', index:'manager_username', width:120, fixed:true, resizable:false, sortable:false, editable:true, align:'center',
                        editrules:{required : true, custom:true, custom_func:manager_username_check}, 
                        search:true, searchoptions: {  sopt: ['eq']  },
                        searchrules:{ required: true, },
                     },
                     {  name:'manager_password', label:'经理密码', index:'manager_password', width:120, fixed:true, resizable:false,  sortable:false, editable:true, align:'center',
                        editrules:{required : true} ,
                        search:false,
                     },
                     {  name:'begintime', label:'开始时间', index:'begintime', width:160, fixed:true,resizable:false, sortable:true, sorttype:'date', editable: true, align:'center',
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
                        searchrules:{ required: true, date:true, },
                        editoptions:{ 
                            dataInit:function(element) { 
                            $(element).attr('disabled', 'disabled');
                            
                            } 
                         }
                    },
                    {   name:'endtime', label:'结束时间', index:'endtime', width:160, fixed:true, resizable:false,  sortable:true, sorttype:'date',  editable: true,align:'center',
                        editrules:{required : true, custom:true, custom_func:endtime_check}, 
                        editoptions: { dataInit: function(element) { 
                            // $(element).wrap('<div class="input-group date form_datetime"></div>')
                            $(element).parent().addClass("input-group date form_date");
                            $(element).addClass('form-control');
                            //获取行的id值
                            var id = $("#grid-table").jqGrid('getGridParam','selrow');
                            var starttime = $('#grid-table').getCell(id,'begintime');
                            $(element).datetimepicker({
                            language: 'zh-CN', //汉化 
                            format:'yyyy-mm-dd hh:ii:00' , 
                            autoclose:true,
                            minuteStep: 10,
                            startDate: dateCon(starttime,60)
                            }) 
                            } 
                        },
                        search:true, searchoptions: {  sopt: ['bw', 'ew'],
                        dataInit:function(element) { 
                        	$(element).parent().addClass("input-group date form_date");
                            //$(element).wrap('<div class="input-group date form_datetime"></div>')
                            $(element).addClass('form-control');
                            $(element).datetimepicker({
                                language: 'zh-CN', //汉化 
                                format:'yyyy-mm-dd' , 
                                autoclose:true,
                                minView:2,
                            }); 
                            
                            } 
                        },
                        searchrules:{ required: true, date:true, },
                    },
                    {   name:'description', label:'项目描述', index:'description', sortable:false,width:300, fixed:true, resizable:false,  editable: true,align:'left',
                        search:false,
                        edittype:"textarea", editoptions: {rows:"4",cols:"20"},
                         
                    },
                    {   name:'user_count', label:'参与人数', index:'user_count', sortable:true,width:90, fixed:true, resizable:false, editable: false,align:'center',
                        search:true, searchoptions: {  sopt: ['eq','lt', 'le','gt','ge'] },
                        searchrules:{ required: true, integer:true,},
                    },  
                    
			], 
			viewrecords : true, 
			rowNum:10,
			rowList:[10,20,30,40,50,60,70,80,90,100],
			pager : pager_selector,
			altRows: true,
			emptyrecords: "<span style='color:red'>还未添加项目</span>", 
			loadComplete : function() {
				var table = this;
				setTimeout(function(){
					updatePagerIcons(table);
					enableTooltips(table);
				}, 0);
			},
            reloadAfterSubmit:true,
			caption: "项目管理",
	
		});
		
    	//navButtons
    	var edit_options={
                    left:10,
                    top:10,
                    afterSubmit:function(res,rowid){
                        var result = eval('(' + res.responseText + ')');   
                        console.log(res);
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
                         "<p class=\"bg-success\" style='padding:20px;'>项目更新成功</p>"
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
                         "<p class=\"bg-success\" style='padding:20px;'>项目删除成功</p>"
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
			{ 	//navbar options
				add: false,
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
			{//add
				},
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
		
		function style_delete_form(form) {
            var buttons = form.next().find('.EditButton .fm-button');
            buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
            buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
            buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
        }
        function style_search_form(form) {
            var dialog = form.closest('.ui-jqdialog');
            var buttons = dialog.find('.EditTable')
            buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
            buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
            buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
        }

	
	}
/**
* d : 字符串时间，格式为 yyyy-MM-dd HH:mm:ss
* num : 秒
* return : 返回 字符串 ，格式跟传入的相同
*/
function dateCon(d,num){
    var d = new Date(d.substring(0,4),
    d.substring(5,7)-1,
    d.substring(8,10),
    d.substring(11,13),
    d.substring(14,16),
    d.substring(17,19)
    );

    d.setTime(d.getTime()+num*1000);
    //alert(d.toLocaleString());
    return d.getFullYear()+"-"
    +(d.getMonth()+1)
    +"-"+d.getDate()
    +" "+d.getHours()
    +":"+d.getMinutes()
    +":"+d.getSeconds();
}
</script>