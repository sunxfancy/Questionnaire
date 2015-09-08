<link rel="stylesheet" type="text/css" href="/css/css/Leo_projects_css.css" />
<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/lib/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>

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

	jQuery(function($) {
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
			datatype: "json",
			height:'306px',
			autowidth:true,
			colModel:[
			         {   name:'id',  label:'编号',  index:'id',    width:60, fixed:true, resize:false, editable:false, sortable:true,  sorttype:"int",  align:'center',
			             formatter:function(cellvalue, options, rowObject){
                            return "<div class='ui-pg-div ui-inline-edit' data-original-title='项目编号'>"+cellvalue+"</div>";
                         },
			         },
				     {   name:'myac',label:' ',       index:'',      width:70, fixed:true, resize:false, editable:false, sortable:false, align:'center',
					     formatter:'actions', 
					     formatoptions:{ 
						      keys:true,
						      delOptions:{recreateForm: true, beforeShowForm:beforeDeleteCallback},
					     }
				     },
				     {   name:'detail',label:'详情', index:'detail', width:60, fixed:true, resize:false, editable:false, sortable:false, align:'center',
                         formatter:function(cellvalue, options, rowObject){
                         return "<div class='ui-pg-div ui-inline-edit' data-original-title='查看详细信息'><a href='/admin/detail/"+rowObject.id+"' ><i class='fa fa-th-list'></i></a></div>"
                         }
                     },
				    {   name:'name', label:'名称',  index:'name', width:160, fiexed:true, resize:false, editable:true,sortable:true, sorttype:"string", align:'center',
				         editrules:{required : true} ,
				    },
				    {   name:'manager_name', label:'经理', index:'manager_name', width:80, fixed:true, resize:false, sortable:false,  editable:true,align:'center',
				         editrules:{required : true} ,
				    },
				    {   name:'manager_username', label:'账号', index:'manager_username', width:80, fixed:true, resize:false, sortable:false, editable:true, align:'center',
				         editrules:{required : true} ,
				    },
				    {   name:'begintime', label:'开始时间', index:'begintime', width:160, fixed:true, resize:false, sortable:true, editable: true, edittype:'text',unformat:pickDate,align:'center',
				         editrules:{required : true} ,
				    },
				    {   name:'endtime', label:'结束时间', index:'endtime', width:160, fixed:true, resize:false, sortable:true,editable: true, edittype:'text', unformat:pickDate,align:'center',
				         editrules:{required : true} ,
				    },
				    {name:'user_count', label:'参与人数', index:'user_count', sortable:true,width:90, editable: false,align:'center',
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
			loadComplete : function() {
				var table = this;
				setTimeout(function(){
					styleCheckbox(table);
					updateActionIcons(table);
					updatePagerIcons(table);
					enableTooltips(table);
				}, 0);

						

			},
			editurl: "/admin/update",//nothing is saved
			caption: "项目管理",
	
		});
		$(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size
	
		//switch element when editing inline
		function aceSwitch( cellvalue, options, cell ) {
			setTimeout(function(){
				$(cell) .find('input[type=checkbox]')
					.addClass('ace ace-switch ace-switch-5')
					.after('<span class="lbl"></span>');
			}, 0);
		}
	
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
			{
				//edit record form
				//closeAfterEdit: true,
				//width: 700,
				recreateForm: true,
				beforeShowForm : function(e) {
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_edit_form(form);
				}
			},
			{},
			{
				//delete record form
				recreateForm: true,
				beforeShowForm : function(e) {
					var form = $(e[0]);
					if(form.data('styled')) return false;
					
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_delete_form(form);
					
					form.data('styled', true);
				},
				onClick : function(e) {
					alert(1);
				}
			},
			{
				//search form
				recreateForm: true,
				afterShowSearch: function(e){
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
					style_search_form(form);
				},
				afterRedraw: function(){
					style_search_filters($(this));
				}
				,
				multipleSearch: true,
			},
			{},
			{}
		)

		function style_edit_form(form) {
			//enable datepicker on "sdate" field and switches for "stock" field
			form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
				.end().find('input[name=stock]')
					.addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
					   //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
					  //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');
	
			//update buttons classes
			var buttons = form.next().find('.EditButton .fm-button');
			buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
			buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
			buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')
			
			buttons = form.next().find('.navButton a');
			buttons.find('.ui-icon').hide();
			buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
			buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');		
		}
	
		function style_delete_form(form) {
			var buttons = form.next().find('.EditButton .fm-button');
			buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
			buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
			buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
		}
		
		function style_search_filters(form) {
			form.find('.delete-rule').val('X');
			form.find('.add-rule').addClass('btn btn-xs btn-primary');
			form.find('.add-group').addClass('btn btn-xs btn-success');
			form.find('.delete-group').addClass('btn btn-xs btn-danger');
		}
		function style_search_form(form) {
			var dialog = form.closest('.ui-jqdialog');
			var buttons = dialog.find('.EditTable')
			buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
			buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
			buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
		}
		
		function beforeDeleteCallback(e) {
			var form = $(e[0]);
			if(form.data('styled')) return false;
			
			form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
			style_delete_form(form);
			
			form.data('styled', true);
		}
		
		function beforeEditCallback(e) {
			var form = $(e[0]);
			form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
			style_edit_form(form);
		}
	
		function styleCheckbox(table) {

		}
		
		function updateActionIcons(table) {

		}
		function pickDate( cellvalue, options, cell ) {
			setTimeout(function(){
				$(cell) .find('input[type=text]')
						.datetimepicker({format:'yyyy-mm-dd hh:ii' , autoclose:true}); 
			}, 0);
		}
		//replace icons with FontAwesome icons like above
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
	
		function enableTooltips(table) {
			$('.navtable .ui-pg-button').tooltip({container:'body'});
			$(table).find('.ui-pg-div').tooltip({container:'body'});
		}

	});
</script>