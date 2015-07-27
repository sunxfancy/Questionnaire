<h4 class="header blue lighter">
    <ol class="breadcrumb">
        <span class='glyphicon glyphicon-eye-open text-primary'></span>
        <li><a href="#">查看测评列表</a></li>
        <li class="active">查看测评</li>
    </ol>
</h4>

<div class="space-6"></div>

<div class="col-sm-12">
    <div style="padding: 0">
        未完成人数：{{ notdone }} /总人数：{{ sum }} 
    </div>
    <div style="width: 100%;">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div>
</div>

<!-- <script src="/bootstrap/date-time/bootstrap-datepicker.min.js"></script>
<script src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
 -->

<script type="text/javascript">
                    
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
                })
            
                function stuFormatter(cellvalue, options, rowObject) {
                    if (cellvalue == 1) return "<span class='green'>完成</span>";
                    else return "<span class='orange'>未完成</span>";
                }

                function sexFormatter(cellvalue, options, rowObject) {
                    if (cellvalue == 1) return "男";
                    else return "女";
                }

                function sexUnFormatter(cellvalue, options, rowObject) {
                    if (cellvalue == '男') return 1;
                    if (cellvalue == '女') return 0;
                }

                function nativeplaceFormatter(cellvalue, options, rowObject) {
                    if (cellvalue == 1) return "城镇";
                    else return "农村";
                }

                function nativeplaceUnFormatter(cellvalue, options, rowObject) {
                    if (cellvalue == '城镇') return 1;
                    if (cellvalue == '农村') return 0;
                }

                function singletonFormatter(cellvalue, options, rowObject) {
                    if (cellvalue == 1) return "是";
                    else return "否";
                }

                function singletonUnFormatter(cellvalue, options, rowObject) {
                    if (cellvalue == '是') return 1;
                    if (cellvalue == '否') return 0;
                }
                
                jQuery(grid_selector).jqGrid({
                    //subgrid options
                    subGrid : false,
                   
                    url: "/index/getstudentlist?test_id={{ test_id }}",
                    datatype: "json",
                    height: '300px',
                    shrinkToFit:false,
                    autowidth: true,
                    colNames:[' ', 'ID','状态','学号','Username','姓名','学院','专业','班级','性别','年级','生源地','出生日期','民族','是否独生子女'],
                    colModel:[
                        {name:'myac',index:'', width:80, fixed:true, sortable:false, resize:false,
                            formatter:'actions', 
                            formatoptions:{ 
                                keys:true,

                                delOptions:{recreateForm: true, beforeShowForm:beforeDeleteCallback},
                                //editformbutton:true, editOptions:{recreateForm: true, beforeShowForm:beforeEditCallback}
                            }
                        },
                        {name:'stu_id',index:'stu_id', width:60, sorttype:"int", editable: false, key :true},
                        {name:'status',index:'status', width:60, editable: false,formatter: stuFormatter,unformat:function(cellvalue, options, rowObject) {
                                if (cellvalue == '完成') return 1;
                                if (cellvalue == '未完成') return 0;
                            }},
                        {name:'stu_no',index:'stu_no', width:70, editable: true},
                        {name:'username',index:'username',width:110,sorttype:"string", editable:true},
                        {name:'name',index:'name', width:90,editable: true,sortable:false},
                        
                        {name:'college',index:'college', width:180, sortable:false,editable: true},
                        {name:'major',index:'major', width:180, sortable:false,editable: true},
                        {name:'class',index:'class', width:80, editable: true},
                        {name:'sex',index:'sex', width:90, sortable:false,editable: true,
                            formatter: sexFormatter, unformat: sexUnFormatter },
                        {name:'grade',index:'grade', width:90, sortable:false,editable: true},
                        {name:'nativeplace',index:'nativeplace', width:90, sortable:false,editable: true,formatter: nativeplaceFormatter, unformat: nativeplaceUnFormatter },
                        {name:'birthday',index:'birthday', width:130, sortable:false,editable: true},
                        {name:'nation',index:'nation', width:90, sortable:false,editable: true},
                        {name:'singleton',index:'singleton', width:90, sortable:false,editable: true,formatter: singletonFormatter, unformat: singletonUnFormatter }
                    ], 
            
                    viewrecords : true, 
                    rowNum:10,
                    rowList:[10,20,30],
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
            
                    editurl: "/index/editstudentlist",//nothing is saved
                    caption: "学生数据编辑"
            
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