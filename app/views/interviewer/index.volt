
<link rel="stylesheet" type="text/css" href="/css/css/Leo_projects_css.css" />


<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/lib/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>
<div class="Leo_question">
	<div style="width:100%;height:500px;overflow:hidden;">
		<table id="grid-table"></table>
	</div>
</div>

<script type="text/javascript">
	jQuery(function($) {
		var grid_selector = "#grid-table";		
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
			url: "/pm/examineeofmanager/{{manager_id}}",
			datatype: "json",
			height: '420px',
			autowidth: true,
			colNames:['被试编号','姓名','性别', '最后登录时间','是否测试完毕','查看测试数据','增加面巡意见'],
            colModel:[
                {name:'number',index:'number', sorttype:"int",width:100, editable: false,align:'center'},
                {name:'name',index:'name', sortable:true, width:100,sorttype:"string", editable:true,align:'center'},
                {name:'sex',index:'sex',width:60, sortable:false, editable:false,align:'center',
                	formatter:function(cellvalue){
                        var temp = "";
                        if(cellvalue == 1){
                            temp = "男" ;
                        } 
                        else { 
                            temp = "女";
                        }
                        return temp;
                    }
            	},
            	{name:'last_login',index:'last_login', sortable:true,width:200, editable: false,unformat:pickDate,align:'center'},
                {name:'state',index:'state',width:90, sortable:false, editable:false,align:'center',
                	formatter:function(cellvalue){
                        var temp = "";
                        if(cellvalue > 0){
                            temp = "是" ;
                        } 
                        else { 
                            temp = "否";
                        }
                        return temp;
                    }
            	},                
                {name:'result',index:'result', sortable:false, width:100, resize:false,align:'center',
                    formatter:function(cellvalue,options,rowObject){
                        var temp = "<a href='/pm/check/"+rowObject.id+"' >导出</a>";
                        return temp;
                    }   
                },
                {name:'point',index:'point', sortable:false,width:100, editable: false,align:'center',
            		formatter:function(cellvalue,options,rowObject){
                        var temp = "<a href='/interviewer/point/"+rowObject.id+"' >进入编辑</a>";
                        return temp;
                    }
            	}
            ], 
			viewrecords : true,
			altRows: true,
			loadComplete : function() {
				var table = this;
				setTimeout(function(){
					updateActionIcons(table);
					updatePagerIcons(table);
				}, 0);
			},
			editurl: "/pm/update",//nothing is saved
			caption: "被试人员列表",
			autowidth: true
		});
		$(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size

		//navButtons
		jQuery(grid_selector).jqGrid('navGrid',
			{
				//view record form
				recreateForm: true,
				beforeShowForm: function(e){
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
				}
			}
		)

		function pickDate( cellvalue, options, cell ) {
			setTimeout(function(){
				$(cell) .find('input[type=text]')
						.datetimepicker({format:'yyyy-mm-dd hh:ii' , autoclose:true});
			}, 0);
		}
	});
</script>

</div>
