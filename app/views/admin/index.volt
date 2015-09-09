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


<div class="Leo_question">
	<div style="padding:10px 40px;text-align:right;">
    <a href='/admin/addnew' type='button' class="btn btn-success" style='padding:5px 40px;'>添加新项目</a>
    </div>
<div style="text-align:center;height:448px;overflow:hidden;">
		<table id="grid-table"></table>
		<div id="grid-pager" style='height:80px;'></div>
</div>
</div>

<script type="text/javascript">
$(function(){
    getInfo();
});
function pickdates(id) {
    jQuery("#" + id + "_endtime", "#grid-table").datetimepicker({
    	                    language: 'zh-CN', //汉化 
                            format:'yyyy-mm-dd hh:ii' , 
                            autoclose:true,
    });
  }
function datetimeEnd( cellvalue, options, rowObject ){
	 var id =  jQuery("#grid-table").jqGrid('getGridParam', 'selrow');
     var ret = jQuery("#grid-table").jqGrid('getRowData', id);
     alert(ret.begintime);
	 setTimeout(function(){
		  //设定最终时间
            $(rowObject).find('input[name=endtime]')
                        .datetimepicker({
                        	language: 'zh-CN', //汉化 
                        	format:'yyyy-mm-dd hh:ii' , 
                        	autoclose:true,
                        	
                        }); 
            }, 0);
}
function getInfo(){
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
			editurl:'/admin/updatelist',
			datatype: "json",
			height:'306px',
			autowidth:true,
			colModel:[
			         {   name:'id',  label:'编号',  index:'id',    width:60, fixed:true, resize:false, editable:false, sortable:true,  sorttype:"int",  align:'center',
			             formatter:function(cellvalue, options, rowObject){
                            return "<div class='ui-pg-div ui-inline-edit' data-original-title='项目编号'>"+cellvalue+"</div>";
                         },
			         },
				     {   name:'',label:' ',       index:'',      width:70, fixed:true, resize:false, editable:false, sortable:false, align:'center', 
					     formatter:'actions', 
					     formatoptions:{ 
						      keys:true,
						      delOptions:{recreateForm: true,},
					     },
					     search:false,
				     },
				     {   name:'',label:'详情', index:'detail', width:60, fixed:true, resize:false, editable:false, sortable:false, align:'center',
                         formatter:function(cellvalue, options, rowObject){
                         return "<div class='ui-pg-div ui-inline-edit' data-original-title='查看详细信息'><a href='/admin/detail/"+rowObject.id+"' ><i class='fa fa-th-list'></i></a></div>"
                         },
                         search:false,
                     },
				    {   name:'name', label:'项目名称',  index:'name', width:160, fiexed:true, resize:false, editable:true,sortable:true, sorttype:"string", align:'center',
				         editrules:{required : true} ,
				    },
				    {   name:'manager_name', label:'经理', index:'manager_name', width:80, fixed:true, resize:false, sortable:false,  editable:true,align:'center',
				         editrules:{required : true} ,
				    },
				    {   name:'manager_username', label:'经理账号', index:'manager_username', width:80, fixed:true, resize:false, sortable:false, editable:true, align:'center',
				         editrules:{required : true} ,
				    },
				    {   name:'begintime', label:'开始时间', index:'begintime', width:160, fixed:true, resize:false, sortable:true, editable: true, edittype:'text',align:'center',
				         editrules:{required : true} , 
				         unformat:function(cellvalue, options, rowObject){
				         	  setTimeout(function(){
						        //设定初始时间
						        $(rowObject).find('input[name=begintime]')
						                      .datetimepicker({
						                            language: 'zh-CN', //汉化 
						                            format:'yyyy-mm-dd hh:ii' , 
						                            autoclose:true,
						                        }); 
						            }, 0);
				         },
				    },
				    {   name:'endtime', label:'结束时间', index:'endtime', width:160, fixed:true, resize:false, sortable:true,editable: true, edittype:'text',align:'center',
				        editrules:{required : true },
				        unformat:function(cellvalue, options, rowObject){
                              setTimeout(function(){
                                //设定初始时间
                                $(rowObject).find('input[name=endtime]')
                                              .datetimepicker({
                                                    language: 'zh-CN', //汉化 
                                                    format:'yyyy-mm-dd hh:ii' , 
                                                    autoclose:true,
                                                }); 
                                    }, 0).wrap('<div class="input-group date form_datetime"></div>');
                         }
                   },
				    {   name:'user_count', label:'参与人数', index:'user_count', sortable:true,width:90, editable: false,align:'center',
				         formatter:function(cellvalue, options, rowObject){
                            return "<div class='ui-pg-div ui-inline-edit' data-original-title='项目参与人数'>"+cellvalue+"</div>";
                         },
				    }
			], 
			viewrecords : true, 
			rowNum:10,
			rowList:[10,20,30],
			pager : pager_selector,
			altRows: true,
			emptyrecords: "<span style='color:red'>还未添加项目</span>", 
			loadComplete : function() {
				var table = this;
				setTimeout(function(){
					updatePagerIcons(table);
				}, 0);

			},
			caption: "项目管理",
	
		});
    	//navButtons
		jQuery(grid_selector).jqGrid('navGrid',pager_selector,
			{ 	//navbar options
				edit: false,
				add: false,
				del: false,
				search: true,
				searchicon : 'ace-icon fa fa-search orange',
				searchtext:'搜索',
				refresh: true,
				refreshicon : 'ace-icon fa fa-refresh green',
				refreshtext:'刷新',
				view: false,
			},
			{//edit
				},
			{//add
				},
			{//del
				},
			{
				// //search form
				// recreateForm: true,
				// afterShowSearch: function(e){
					// var form = $(e[0]);
					// form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
					// style_search_form(form);
				// },
				// afterRedraw: function(){
					// style_search_filters($(this));
				// }
				// ,
				// multipleSearch: true,
			},
			{},
			{}
		)

		function updatePagerIcons(table) {
			var replacement = 
			{
				'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
				'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
				'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
				'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
			};
			$('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
				var icon = $(this);
				var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
				
				if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
			})
		}
	
	}
</script>