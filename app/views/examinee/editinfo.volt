<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/lib/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>

<div class="Leo_question">
    <div class="baseinfo" style="width:100%;height:100%;">
        <div style="overflow:auto;height:440px;">
            <div style="height:40px;text-align:center;font-size:28px;">基本信息</div>
            <table border="1" cellspacing="0" cellpadding="0" style="margin:0 auto;font-size:16px; font-family:'微软雅黑'">
                <tr>
                    <td style="width:120px;line-height:33px;">姓名</td>
                    <td style="width:180px;"><input id="name" type="text" value="{{ name }}" style="width:178px;font-size:16px;"></td>
                    <td style="width:120px;line-height:33px;">性别</td>
                    <td style="width: 180px;"><input id="sex" type="text" value="{{ sex }}" style="width:178px;font-size:16px;"></td>
                </tr>
                <tr>
                    <td style="width:120px;line-height:33px;">学历</td>
                    <td style="width:180px;">
                        <select id="education" type="text" value="{{ education }}" style="width:178px;font-size:16px;line-height:28px;font-family:'微软雅黑'">
                            <option value="{{ education }}">{{ education }}</option>
                            <option value="函授大专">函授大专</option>
                            <option value="在职大专">在职大专</option>
                            <option value="全日制大专">全日制大专</option>
                            <option value="函授本科">函授本科</option>
                            <option value="在职本科">在职本科</option>
                            <option value="全日制本科">全日制本科</option>
                            <option value="在职硕士">在职硕士</option>
                            <option value="全日制硕士">全日制硕士</option>
                            <option value="博士">博士</option>
                            <option value="其他">其他</option>
                        </select>
                    </td>
                    <td style=" width:120px;line-height:33px;">学位</td>
                    <td style="width:180px;">
                        <select id="degree" type="text" value="{{ degree }}" style="width:178px;font-size:16px;line-height:28px; font-family:'微软雅黑'">
                            <option value="{{ degree }}">{{ degree }}</option>
                            <option value="工科学士学位">工科学士学位</option>
                            <option value="理科学士学位">理科学士学位</option>
                            <option value="文科学士学位">文科学士学位</option>
                            <option value="普通硕士学位">普通硕士学位</option>
                            <option value="专业硕士学位">专业硕士学位</option>
                            <option value="博士学位">博士学位</option>
                            <option value="其他">其他</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">出生年月</td>
                    <td style="width:180px;">
                        <div class="input-append date form_datetime">
                            <input id="birthday" type="text" value="{{birthday}}" readonly style="width:178px;height:31px;">
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </td>
                    <td style=" width:120px;line-height:33px;">籍贯</td>
                    <td style="width:180px;">
                        <select id="native" type="text" value="{{ native }}" style="width:178px;font-size:16px;line-height:28px; font-family:'微软雅黑'">
                            <option value="{{ native }}">{{ native }}</option> 
                            <option value="北京市">北京市</option>
                            <option value="安徽省">安徽省</option>
                            <option value="重庆市">重庆市</option>
                            <option value="福建省">福建省</option>
                            <option value="甘肃省">甘肃省</option>
                            <option value="广东省">广东省</option>
                            <option value="广西壮族自治区">广西壮族自治区</option>
                            <option value="贵州省">贵州省</option>
                            <option value="海南省">海南省</option>
                            <option value="河北省">河北省</option>
                            <option value="河南省">河南省</option>
                            <option value="黑龙江省">黑龙江省</option>
                            <option value="湖北省">湖北省</option>
                            <option value="湖南省">湖南省</option>
                            <option value="吉林省">吉林省</option>
                            <option value="江苏省">江苏省</option>
                            <option value="江西省">江西省</option>
                            <option value="辽宁省">辽宁省</option>
                            <option value="内蒙古自治区">内蒙古自治区</option>
                            <option value="宁夏回族自治区">宁夏回族自治区</option>
                            <option value="青海省">青海省</option>
                            <option value="山东省">山东省</option>
                            <option value="山西省">山西省</option>
                            <option value="陕西省">陕西省</option>
                            <option value="上海市">上海市</option>
                            <option value="四川省">四川省</option>
                            <option value="天津市">天津市</option>
                            <option value="西藏自治区">西藏自治区</option>
                            <option value="新疆维吾尔族自治区">新疆维吾尔族自治区</option>
                            <option value="云南省">云南省</option>
                            <option value="浙江省">浙江省</option>
                            <option value="台湾省">台湾省</option>
                            <option value="香港">香港</option>
                            <option value="澳门">澳门</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">政治面貌</td>
                    <td style="width:180px;">
                        <select id="politics" type="text" value="{{ politics }}" style="width:178px;font-size:16px;line-height:28px;font-family:'微软雅黑'">
                            <option value="{{ politics }}">{{ politics }}</option>
                            <option value="无">无党派</option>
                            <option value="团员">团员</option>
                            <option value="党员">党员</option>
                            <option value="群众">群众</option>
                            <option value="民主党派">民主党派</option>
                        </select>
                    </td>
                    <td style=" width:120px;line-height:33px;">职称</td>
                    <td style="width:180px;">
                        <select id="professional" type="text" value="{{ professional }}" style="width:178px;font-size:16px;line-height:28px;font-family:'微软雅黑'">
                            <option value="{{ professional }}">{{ professional }}</option>
                            <option value="无职称">无职称</option>
                            <option value="初级">初级</option>
                            <option value="中级">中级</option>
                            <option value="副高职">副高职</option>
                            <option value="正高职">正高职</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">工作单位</td>
                    <td colspan="3" style="font-size:16px;"><input id="employer" type="text" value="{{ employer }}" style="width:478px;font-size:16px;"></td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">部门</td>
                    <td colspan="3" style="font-size: 16px;"><input id="unit" type="text" value="{{ unit }}" style="width:478px;font-size:16px;"></td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">岗位/职务</td>
                    <td colspan="3" style="font-size: 16px;"><input id="duty" type="text" value="{{ duty }}" style="width:478px;font-size:16px;"></td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">班子/系统成员</td>
                    <td colspan="3" style="font-size: 16px;"><input id="team" type="text" value="{{ team }}" style="width:478px;font-size:16px;"></td>
                </tr>
            </table>

            <div style="height:10px;"></div>
            <div style="width:600px;margin:0 auto;overflow:hidden;">
                <table id="grid-table1"></table>
            </div>
            <div style="height:10px;"></div>
            <div style="width:600px;margin:0 auto;overflow:hidden;">
                <table id="grid-table2"></table>
            </div>
            
            <div style="width:600px;height:40px;margin:0 auto;margin-top:10px;">  
                <table style="width:600px; text-align:center;">                
                <tr><td><button class="btn btn-primary" id="submit">保存</button></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    $(".form_datetime").datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    $(document).ready(function() {
        $("#submit").click(function(){
                var base_info ={
                    "name"          :$("#name").val(),
                    "sex"           :$("#sex").val(),
                    "education"     :$("#education").val(),
                    "degree"        :$("#degree").val(),
                    "birthday"      :$("#birthday").val(),
                    "native"        :$("#native").val(),
                    "politics"      :$("#politics").val(),
                    "professional"  :$("#professional").val(),
                    "employer"      :$("#employer").val(),
                    "unit"          :$("#unit").val(),
                    "duty"          :$("#duty").val(),
                    "team"          :$("#team").val()
                }
                $.post('/examinee/submit', base_info, callbk);
        });
    });
    function callbk(){
            window.location.href = '/examinee/doexam';
    }

jQuery(function($) {
        var grid_selector = "#grid-table1";
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
            subGrid : false,
            url: "/examinee/listedu",
            datatype: "json",
            height: 'auto',
            shrinkToFit:true,
            forceFit:true,
            autowidth: true,
            colNames:[' ','毕业院校','专业','所获学位','起止时间'],
            colModel:[
                {name:'myac',index:'', width:70, fixed:true, sortable:false, resize:false,
                    formatter:'actions', 
                    formatoptions:{ 
                        keys:true,                       
                        delOptions:{recreateForm: true, beforeShowForm:beforeDeleteCallback},
                    }
                },               
                {name:'school', index:'school', width:140, editable: true, sortable:false, align:'center'},
                {name:'profession', index:'profession', sortable:false, width:140, editable:true, align:'center'},
                {name:'degree', index:'degree', width:80, sortable:false, editable:true, align:'center'},
                {name:'date', index:'date', sortable:true, width:110, editable: true,edittype:'text',align:'center'}
                ],
            viewrecords : true, 
            rowNum:10,
            rowList:[10,20,30],
            pager : pager_selector,
            altRows: true,
            toppager: false,
            
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
    
            editurl: "/examinee/updateedu",//nothing is saved
            caption: "教育经历"
    
            ,autowidth: true
    
        });
        jQuery("#grid-table1").setGridParam().hideCol("id").trigger("reloadGrid");

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
            {
                //new record form
                //width: 700,
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

jQuery(function($) {
        var grid_selector = "#grid-table2";
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
            subGrid : false,
            url: "/examinee/listwork",
            datatype: "json",
            height: 'auto',
            shrinkToFit:true,
            forceFit:true,
            autowidth: true,
            colNames:[' ','就职单位','部门','岗位/职务','起止时间'],
            colModel:[
                {name:'myac',index:'', width:70, fixed:true, sortable:false, resize:false,
                    formatter:'actions', 
                    formatoptions:{ 
                        keys:true,
                        
                        delOptions:{recreateForm: true, beforeShowForm:beforeDeleteCallback},
                    }
                },
                {name:'employer', index:'employer', width:190, editable:true, sortable:false, align:'center'},
                {name:'unit',index:'unit', sortable:false, width:80, editable:true,align:'center'},
                {name:'duty', index:'duty', width:80, sortable:false, editable:true, align:'center'},
                {name:'date',index:'date', sortable:true,width:140, editable: true,edittype:'text',align:'center'}
                ], 
            viewrecords : true, 
            rowNum:10,
            rowList:[10,20,30],
            pager : pager_selector,
            altRows: true,
            toppager: false,
            
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
    
            editurl: "/examinee/updatework",//nothing is saved
            caption: "工作经历"
    
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
            {
                //new record form
                //width: 700,
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

        function style_edit_form(form) {
            //enable datepicker on "sdate" field and switches for "stock" field
            form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
                .end().find('input[name=stock]')
                    .addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
 
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
    });
</script> 
