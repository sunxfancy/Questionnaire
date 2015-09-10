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
	var spinner = null;
    var target = document.getElementsByClassName('Leo_question')[0];
    spinner = new Spinner().spin(target);
    getInfo();
    if(spinner){ spinner.stop(); }
});

function name_check(rowid,cellname,value){
	console.log(value);
	console.log(cellname);
	console.log(rowid);
	var rt_array ;
	$.ajax({
		  type: 'POST',
		  url: '/admin/namecheck',
		  async: false,
		  data:  {name:value},
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
	var rt_array ;
	$.ajax({
          type: 'POST',
          url: '/admin/managerusernamecheck',
          async: false,
          data: {username:value},
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
        return [true, ""];
    }else{
        return [false, colName+"时间设定不合理"];
    }
}

function getInfo(){
	var lastsel;
		var grid_selector = "#grid-table";
		var pager_selector = "#grid-pager";
		jQuery(grid_selector).jqGrid({
			url: "/admin/list",
			editurl:'/admin/update',
			datatype: "json",
			height:'306px',
			shrinkToFit:false,
			hidegrid:false,
		    autowidth:true,
			colModel:[
			         {   name:'id',  label:'编号',  index:'id',    width:100, fixed:true, resize:false, editable:false, sortable:true,  sorttype:"int",  align:'center',
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
				     {   name:'',label:'详情', index:'', width:60, fixed:true, resize:false, editable:false, sortable:false, align:'center',
                         formatter:function(cellvalue, options, rowObject){
                         return "<div class='ui-pg-div ui-inline-edit' data-original-title='查看详细信息'><a href='/admin/detail/"+rowObject.id+"' ><i class='fa fa-th-list'></i></a></div>"
                         },
                         search:false,
                     },
				    {   name:'name', label:'项目名称',  index:'name', width:200, fiexed:true, resize:false, editable:true,sortable:true, sorttype:"string", align:'center',
				        editrules:{required : true, custom:true, custom_func:name_check}, 
				    },
				    {   name:'manager_name', label:'经理', index:'manager_name', width:100, fixed:true, resize:false, sortable:false,  editable:true,align:'center',
				         editrules:{required : true} ,
				    },
				    {   name:'manager_username', label:'经理账号', index:'manager_username', width:120, fixed:true, resize:false, sortable:false, editable:true, align:'center',
				          editrules:{required : true, custom:true, custom_func:manager_username_check}, 
				    },
				     {   name:'manager_password', label:'经理密码', index:'manager_password', width:120, fixed:true, resize:false, sortable:false, editable:true, align:'center',
                         editrules:{required : true} ,
                    },
				    {   name:'begintime', label:'开始时间', index:'begintime', width:160, fixed:true, resize:false, sortable:true, editable: false, align:'center',
		
				    },
				    {   name:'endtime', label:'结束时间', index:'endtime', width:160, fixed:true, resize:false, sortable:true,editable: true,align:'center',
				        editrules:{required : true, custom:true, custom_func:endtime_check}, 
				        editoptions: { dataInit: function(element) { 
				        	$(element).wrap('<div class="input-group date form_datetime"></div>')
				        	$(element).addClass('form-control');
				        	var id = element.id.substring(0,4);
				        	var starttime = $('#grid-table').getCell(id,'begintime');
				        	$(element).datetimepicker({
				            language: 'zh-CN', //汉化 
                            format:'yyyy-mm-dd hh:ii:00' , 
                            autoclose:true,
                            minuteStep: 10,
                            startDate: starttime,
				        	}) 
				        	} 
				        },
                   },
				   {   name:'user_count', label:'参与人数', index:'user_count', sortable:true,width:90, fixed:true, resize:false,editable: false,align:'center',
				         formatter:function(cellvalue, options, rowObject){
                            return "<div class='ui-pg-div ui-inline-edit' data-original-title='项目参与人数'>"+cellvalue+"</div>";
                         },
				    },
				    {   name:'description', label:'项目描述', index:'description', sortable:false,width:300,fixed:true, resize:false, editable: true,align:'left',
                    },
				    
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
			 onSelectRow: function(id){
     if(id && id!==lastsel){ 
        jQuery('#grid_id').restoreRow(lastSel); 
        lastsel=id; 
     }
     jQuery('#grid_id').editRow(id, true); 
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