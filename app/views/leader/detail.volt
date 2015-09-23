<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>
<script type="text/javascript" src="/lib/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/lib/bootstrap-datetimepicker.js"></script>

<div style="width:100%;height:500px;overflow:hidden;">
    <table id="grid-table"></table>
    <div id="grid-pager"></div>   
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
            url: "/pm/listexaminee",
            datatype: "json",
            height: '310px',
            shrinkToFit:true,
            forceFit:true,
            autowidth: true,
            colNames:[ '个人信息','被试编号','姓名','性别', '是否测评结束','最后登录时间','查看报告'],
            colModel:[
                {name:'info',index:'info', sortable:false, width:60, resize:false,align:'center',
                    formatter:function(cellvalue, options, rowObject){
                        var temp = "<div class='ui-pg-div ui-inline-edit' data-original-title='查看个人详细信息''><a href='/leader/info/"+rowObject.id+"' ><i class='fa fa-th-list'></i></a></div>";
                        return temp;
                    }
                },
                {name:'number',      index:'number',     sortable:true,    width:100,sorttype:"int", editable: false,  align:'center'},
                {name:'name',        index:'name',       sortable:true,    width:110,sorttype:"string", editable:false,align:'center'},
                {name:'sex',         index:'sex',        sortable:true,    width:60,sorttype:"string", editable:false,align:'center'},
                {name:'state',       index:'state',       sortable:false,  width:135,editable:false,align:'center',
                    formatter:function(cellvalue){
                        var temp = "";
                        if(cellvalue > 5){
                            temp = "是" ;
                        } 
                        else { 
                            temp = "否";
                        }
                        return temp;
                    }
                },
                {name:'last_login',  index:'last_login',  sortable:false,  width:200, editable: false,unformat:pickDate,align:'center'},
                {name:'result',      index:'result',      sortable:false,  width:130, resize:false,align:'center',
                    formatter:function(cellvalue, options, rowObject){
                        var temp = '查看';
                        if (rowObject.state > 5) {
                            temp = "<a href='/pm/result' >查看</a>";
                        }
                        return temp;
                    }
                }
            ],            
            viewrecords : true, 
            rowNum:10,
            rowList:[10,20,30],
            pager : pager_selector,
            altRows: true,
            toppager: false,           
            loadComplete : function() {           
                    updatePagerIcons(this);
            },   
            editurl: "/pm/updateexaminee",//nothing is saved
            caption: "被试人员列表",  
            autowidth: true  
        });
        $(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size
    
        //navButtons
        jQuery(grid_selector).jqGrid('navGrid',pager_selector,
            {   //navbar options
                search: true,
                searchicon : 'ace-icon fa fa-search orange',
                refresh: true,
                refreshicon : 'ace-icon fa fa-refresh green',
                view: true,
                viewicon : 'ace-icon fa fa-search-plus grey',
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
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function(e){
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                }
            }
        )
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
        
        function pickDate( cellvalue, options, cell ) {
            setTimeout(function(){
                $(cell) .find('input[type=text]')
                        .datetimepicker({format:'yyyy-mm-dd hh:ii' , autoclose:true}); 
            }, 0);
        }
    });
</script>