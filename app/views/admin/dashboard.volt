<h4 class="header blue lighter">
    <ol class="breadcrumb">
      <span class='glyphicon glyphicon-home blue'></span>
	  <li><a href="#" >Home</a></li>
	  <li class="active">DashBoard</li>
	</ol>
</h4>


<div class="space-6"></div>
<div class="row">
	<div class="infobox-container">

		<div class="infobox infobox-red">
			<div class="infobox-icon">
				<i class="ace-icon fa fa-flask"></i>
			</div>

			<div class="infobox-data">
				<span class="infobox-data-number">{{sumstudent}}</span>
				<div class="infobox-content">学生总数</div>
			</div>
		</div>

		<div class="infobox infobox-orange2">
			<!-- #section:pages/dashboard.infobox.sparkline -->
			<!-- <div class="infobox-chart">
				<span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
			</div> -->

			<!-- /section:pages/dashboard.infobox.sparkline -->
			<div class="infobox-data">
				<span class="infobox-data-number">{{finishedstudent}}</span>
				<div class="infobox-content">学生完成数目</div>
			</div>

			<!-- <div class="badge badge-success">
				7.2%
				<i class="ace-icon fa fa-arrow-up"></i>
			</div> -->
		</div>

		<div class="infobox infobox-blue2">
			<div class="infobox-progress">
				<!-- #section:pages/dashboard.infobox.easypiechart -->
				<div class="easy-pie-chart percentage" data-percent="{{percent}}" data-size="46">
					<span class="percent">{{percent}}</span>%
				</div>

				<!-- /section:pages/dashboard.infobox.easypiechart -->
			</div>

			<div class="infobox-data">
				<span class="infobox-text">学生完成度</span>

				<div class="infobox-content">
					<span class="bigger-110">~</span>
					还有{{notdonestudent}}人未完成
				</div>
			</div>
		</div>

		<!-- /section:pages/dashboard.infobox -->
		<div class="space-6"></div>

		<!-- #section:pages/dashboard.infobox.dark -->
		<div class="infobox infobox-green infobox-small infobox-dark">
			<div class="infobox-progress">
				<!-- #section:pages/dashboard.infobox.easypiechart -->
				<div class="easy-pie-chart percentage" data-percent="{{schoolpercent}}" data-size="39">
					<span class="percent">{{schoolpercent}}</span>%
				</div>

				<!-- /section:pages/dashboard.infobox.easypiechart -->
			</div>

			<div class="infobox-data">
				<div class="infobox-content">校完成率</div>
				<div class="infobox-content">已测{{doneschool}}</div>
			</div>
		</div>
		<div class="infobox infobox-blue infobox-small infobox-dark">
			<!-- /section:pages/dashboard.infobox.sparkline -->
			<div class="infobox-data">
				<div class="infobox-content">学校总数</div>
				<div class="infobox-content">{{sumschool}}</div>
			</div>
		</div>
		<div style="width: 100%;">
	        <table id="grid-table"></table>
	        <div id="grid-pager"></div>
	    </div>
	</div>
</div>

<script src="/lib/jquery.easypiechart.min.js"></script>
<!-- <script src="/lib/jquery.sparkline.min.js"></script> -->
	<script type="text/javascript">
		$('.easy-pie-chart.percentage').each(function(){
			var $box = $(this).closest('.infobox');
			var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
			var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
			var size = parseInt($(this).data('size')) || 50;
			$(this).easyPieChart({
				barColor: barColor,
				trackColor: trackColor,
				scaleColor: false,
				lineCap: 'butt',
				lineWidth: parseInt(size/10),
				animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
				size: size
			});
		})
	
		$('.sparkline').each(function(){
			var $box = $(this).closest('.infobox');
			var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
			$(this).sparkline('html',
			 {
				tagValuesAttribute:'data-values',
				type: 'bar',
				barColor: barColor ,
				chartRangeMin:$(this).data('min') || 0
			 });
		});




		//=========华丽丽的分割线===========
		jQuery(function($) {
                var grid_selector = "#grid-table";
                var pager_selector = "#grid-pager";
                
                //resize to fit page size
                $(window).on('resize.jqGrid', function () {
                    $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
                })
                //resize on sidebar collapse/expand
                var parent_column = $(grid_selector).closest('[class*="col-"]');
                $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
                    if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
                        $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
                    }
                });
                function customFormatter(cellvalue, options, rowObject){  
                    var str = "<a class='glyphicon glyphicon-download-alt' style='margin-left:10px;' href='/admin/export/"+rowObject.school_id+"'></a> ";
                    //alert(cellvalue);
                    return str;
                } 
                jQuery(grid_selector).jqGrid({
                    //subgrid options
                    subGrid : false,
                   
                    url: "/admin/getallschooldata",
                    datatype: "json",
                    height: '300px',
                    shrinkToFit:false,
                    autowidth: true,
                    colNames:[' ','导出', '学校id','学校名','学生总数','已完成学生总数','未完成学生总数','学生完成度'],
                    colModel:[
                        {name:'myac',index:'', width:80, fixed:true, sortable:false, resize:false,
                            formatter:'actions', 
                            formatoptions:{ 
                                keys:true,
                                delOptions:{recreateForm: true, beforeShowForm:beforeDeleteCallback}
                            }
                        },
                        // 自定义导出按钮
                        {name:'cac',index:'', width:50, fixed:true, sortable:false, resize:false,
                            formatter:customFormatter, 
                            unformat: function(cellvalue, options, rowObject) {
                                return '';
                            }
                        },

                        {name:'school_id',index:'school_id', width:70, sorttype:"int", editable: false, key :false},
                        {name:'name',index:'name', width:120, sorttype:"int", editable: false},
                        {name:'sumstudents',index:'sumstudents', width:70, editable: false},
                        {name:'sumfinishedstudents',index:'sumfinishedstudents', width:110, editable: false},
                        {name:'notdonestudents',index:'notdonestudents',width:110,sorttype:"string", editable:false},
                        {name:'finishedpercent',index:'finishedpercent', width:90,editable: false,sortable:false}
                    ], 
            
                    viewrecords : true, 
                    rowNum:60,
                    rowList:[60],
                    pager : pager_selector,
                    altRows: true,
                    //toppager: true,
                    
                    multiselect: true,
                    //multikey: "ctrlKey",
                    multiboxonly: true,
            
                    loadComplete : function() {
                        var table = this;
                        setTimeout(function(){
                            styleCheckbox(table);
                            
                            updateActionIcons(table);
                            updatePagerIcons(table);
                            enableTooltips(table);
                        }, 0);
                    },

                    caption: "查看学校统计"
            
                    ,autowidth: true
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
                //enable datepicker
                function pickDate( cellvalue, options, cell ) {
                    setTimeout(function(){
                        $(cell) .find('input[type=text]')
                                .datepicker({format:'yyyy-mm-dd' , autoclose:true}); 
                    }, 0);
                }
            
            
                //navButtons
                jQuery(grid_selector).jqGrid('navGrid',pager_selector,
                    {   //navbar options
                        edit: true,
                        editicon : 'ace-icon fa fa-pencil blue',
                        add: true,
                        addicon : 'ace-icon fa fa-plus-circle purple',
                        del: true,
                        delicon : 'ace-icon fa fa-trash-o red',
                        search: true,
                        searchicon : 'ace-icon fa fa-search orange',
                        refresh: true,
                        refreshicon : 'ace-icon fa fa-refresh green',
                        view: true,
                        viewicon : 'ace-icon fa fa-search-plus grey',
                    },
                    {
                        recreateForm: true,
                        beforeShowForm : function(e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                            style_edit_form(form);
                        }
                    },
                    {
                        closeAfterAdd: true,
                        recreateForm: true,
                        viewPagerButtons: false,
                        beforeShowForm : function(e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                            .wrapInner('<div class="widget-header" />')
                            style_edit_form(form);
                        }
                    },
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
                    {
                        //view record form
                        recreateForm: true,
                        beforeShowForm: function(e){
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                        }
                    }
                )
      
                function style_edit_form(form) {
                    //enable datepicker on "sdate" field and switches for "stock" field
                    form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
                        .end().find('input[name=stock]')
                            .addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
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