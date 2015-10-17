<script type="text/javascript" src= '/datetimepicker/bootstrap.min.js'></script>
<!-- jqgrid 组件-->
<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<!--jqgrid 辅助-->
<script type="text/javascript" src="/jqGrid/js/jqgrid.assist.js"></script>
<div class="Leo_question" style="text-align:center;overflow:auto; ">

<div class="form-group" style='text-align:left;font-size:0;margin-top:15px;'>
<div style="display:inline-block;margin-left:40px;font-size:26px;color:red;width:30%;" id='manager'>
	面询专家:
</div>
<div class='form-group' style='width:60%;text-align:right;display:inline-block; '>
<form action='/pm' class="form-inline" method='post'>
   <input id='page' value='2' name='page' type='hidden'/>
   <button type='submit' class='btn btn-success' style='width:100px;'>
   <i class="glyphicon glyphicon-fast-backward"></i>&nbsp;返回上层</button>
</form>
</div>
</div>
<hr size="2" color="#FF0000" style="width:90%;"/>
<div style="width:90%;display:inline-block;">
    <table id="grid-table-1"></table>
    <div id="grid-pager-1"></div>   
</div>
<hr size="2" color="#FF0000" style="width:90%;"/>
<div style="width:90%;display:inline-block;">
    <table id="grid-table-2"></table>
    <div id="grid-pager-2"></div>   
</div>
<hr size="2" color="#FF0000" style="width:90%;margin-bottom:40px;"/>
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
var manager_id = <?php if(isset($manager_id)){ echo $manager_id; }else { echo 0; } ?> ;
    $(function(){
    	getManager(manager_id);
    	getExamineeNot(manager_id);
    	getExamineesInt(manager_id)
    })
    function getManager(manager_id){
        $.post('/pm/getInterviewer', {'manager_id': manager_id}, function(data){
        	if (data.error){
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
        	}else{
        		$('#manager').append("<span style='color:black;'>"+data.success+"</span>");
        	}
        })
    }
    function getExamineeNot(manager_id){
    	var grid_selector = '#grid-table-1';
        var pager_selector = '#grid-pager-1';
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
            url: '/pm/listexamineesnoint/'+manager_id,
            editurl: '/pm/updateexamineesnoint/'+manager_id,
            datatype: "json",
            height: '260px',
            shrinkToFit:false,
            hidegrid:true,
            autowidth:false,
            
            colModel:[
                     {   name:'id',  label:'用户id',  index:'id',  width:100, fixed:true, resizable:false, editable:true,sortable:false, sorttype:"int", align:'center',
                         hidden:true,
                     },
                     {   name:'number',  label:'用户账号',  index:'number',  width:250,  resizable:false, editable:true,sortable:true, sorttype:"int", align:'center',
                         search:true, searchoptions: { sopt: ['eq'], },
                         searchrules:{ required: true, },
                     },                     
                     {  name:'name', label:'姓名',  index:'name', width:250, resizable:false,  editable:true,sortable:true,sorttype:"string", align:'center',
                        editrules:{required : true, }, 
                        search:true, searchoptions: {  sopt: ['eq']  },
                        searchrules:{ required: true, },
                     },
                     {  name:'type', label:'是否为绿色通道人员',  index:'type', width:250,  resizable:false,  editable:true,sortable:true, sorttype:'string', align:'center',
                        search:true, 
                        stype:'select', searchoptions:{ sopt: ['eq'], value:"1:是;0:否", },
                        searchrules:{ required: true,},
                        formatter:function(cellvalue){
                            if(cellvalue == 1 ){
                                return '<span style=\'color:green\'>是</span>';
                            }else{
                                return '<span style=\'color:red\'>否</span>';
                            }
                        },   
                     },
            ], 
            viewrecords : true, 
            rowNum:10,
            rowList:[10,20,30,40,50,60,70,80,90,100],
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
            caption: '未分配人员列表',
            multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,
        });
        function style_delete_form_fenpei(form) {
    var buttons = form.next().find('.DelButton .fm-button');
    buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
    buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-link"></i>');
    buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
}
        var del_options = {
                top : 80,  //位置
                left: 300, //位置
                caption:'提示',
                msg:'确认分配被试人员吗？',
                bSubmit: '确认',
                bCancel: "取消",
                reloadAfterSubmit: true,
                recreateForm: true,
                beforeShowForm : function(e) {
                    var form = $(e[0]);
                    if(form.data('styled')) return false;
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_delete_form_fenpei(form);
                    
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
                         "<p class=\"bg-success\" style='padding:20px;'>被试人员面询分配成功</p>"
                         );
                        $('.modal-footer').html('');
                        $('.modal-footer').html(
                         "<button type=\"button\" class=\"btn btn-primary\" style='padding:5px 20px;'data-dismiss=\"modal\">关闭提示</button>"
                        );
                        $('#myModal').modal({
                         keyboard:true,
                         backdrop:'static'
                         })
                         //上下两表同时更新
                        jQuery("#grid-table-2").trigger("reloadGrid");

                      // return true;

                      return [true,""]
                    }
                 },
        }

        jQuery(grid_selector).jqGrid('navGrid',pager_selector,
            {   //navbar options
                add: false,
                edit: false,
                editicon : 'ace-icon fa fa-pencil blue',
                edittext:'编辑',
                del: true,
                delicon : 'ace-icon fa fa-link red',
                deltext:'分配',
                deltitle: "向专家分配被试人员",
                refresh: true,
                refreshicon : 'ace-icon fa fa-refresh green',
                refreshtext:'刷新',
                search:true,
                searchicon : 'ace-icon fa fa-search orange',
                searchtext:'搜索',
                view: false,
                viewicon : 'ace-icon fa fa-search-plus grey',
                viewtext:'查看',
                
            },
            //edit,
            {},
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
    }
    function getExamineesInt(manager_id){
        var grid_selector = '#grid-table-2';
        var pager_selector = '#grid-pager-2';
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
            url: '/pm/listexamineehadint/'+manager_id,
            editurl: '/pm/updateexamineehadint/'+manager_id,
            datatype: "json",
            height: '260px',
            shrinkToFit:false,
            hidegrid:true,
            autowidth:false,
            
            colModel:[
                     {   name:'id',  label:'用户id',  index:'id',  width:100, fixed:true, resizable:false, editable:false,sortable:false, sorttype:"int", align:'center',
                         hidden:true,
                     },
                     {   name:'number',  label:'用户账号',  index:'number',  width:150, fixed:true, resizable:false, editable:true,sortable:true, sorttype:"int", align:'center',
                         search:true, searchoptions: { sopt: ['eq'], },
                         searchrules:{ required: true, integer:true,},
                         //设为可编辑，显示时再设为不可变
                         editoptions:{ 
                            dataInit:function(element) { 
                            $(element).attr('disabled', 'disabled');
                            
                            } 
                         }
                     },                     
                     {  name:'name', label:'姓名',  index:'name', width:150, fixed:true, resizable:false,  editable:true,sortable:false, align:'center',
                        editrules:{required : true, }, 
                        search:true, searchoptions: {  sopt: ['eq']  },
                        searchrules:{ required: true, },
                     },
                     {  name:'type', label:'是否为绿色通道人员',  index:'type', width:225, fixed:true, resizable:false,  editable:true,sortable:false, align:'center',
                        search:true, 
                        stype:'select', searchoptions:{ sopt: ['eq'], value:"1:是;0:否", },
                        searchrules:{ required: true,},
                        searchrules:{ required: true, },
                         formatter:function(cellvalue){
                            if(cellvalue == 1 ){
                                return '<span style=\'color:green\'>是</span>';
                            }else{
                                return '<span style=\'color:red\'>否</span>';
                            }
                        },   
                     },
                     {  name:'state', label:'是否完成面询',  index:'state', width:225, fixed:true, resizable:false,  editable:true,sortable:false, align:'center',
                        search:true, 
                        stype:'select', searchoptions:{ sopt: ['eq'], value:"1:是;0:否", },
                        searchrules:{ required: true,},
                        formatter:function(cellvalue){
                            if(cellvalue == 1 ){
                                return '<span style=\'color:green\'>是</span>';
                            }else{
                                return '<span style=\'color:red\'>否</span>';
                            }
                        },   
                     },
            ], 
            viewrecords : true, 
            rowNum:10,
            rowList:[10,20,30,40,50,60,70,80,90,100],
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
            caption: '已分配人员列表',
            multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,
    
        });
             function style_delete_form_quxiao(form) {
    var buttons = form.next().find('.DelButton .fm-button');
    buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
    buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-unlink"></i>');
    buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
}
        var del_options = {
                top : 80,  //位置
                left: 300, //位置
                caption:'提示',
                msg:'确认取消所选的已分配的被试人员吗？',
                bSubmit: '确认',
                bCancel: "取消",
                reloadAfterSubmit: true,
                recreateForm: true,
                beforeShowForm : function(e) {
                    var form = $(e[0]);
                    if(form.data('styled')) return false;
                    
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_delete_form_quxiao(form);
                    
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
                         "<p class=\"bg-success\" style='padding:20px;'>取消面询分配成功</p>"
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
                                 //上下两表同时更新
                        jQuery("#grid-table-1").trigger("reloadGrid");

                      return [true,""]
                    }
                 },
        }

        jQuery(grid_selector).jqGrid('navGrid',pager_selector,
            {   //navbar options
                add: false,
                edit: false,
                editicon : 'ace-icon fa fa-pencil blue',
                edittext:'编辑',
                del: true,
                delicon : 'ace-icon fa fa-unlink red',
                deltitle:'取消面询分配',
                deltext:'取消分配',
                refresh: true,
                refreshicon : 'ace-icon fa fa-refresh green',
                refreshtext:'刷新',
                search:true,
                searchicon : 'ace-icon fa fa-search orange',
                searchtext:'搜索',
                view: false,
                viewicon : 'ace-icon fa fa-search-plus grey',
                viewtext:'查看',
                
            },
            //edit,
            {},
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
           
}
</script>