<script type="text/javascript" src= '/datetimepicker/bootstrap.min.js'></script>
<!-- jqgrid 组件-->
<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<!--jqgrid 辅助-->
<script type="text/javascript" src="/jqGrid/js/jqgrid.assist.js"></script>
<div class="Leo_question" style="text-align:center;overflow:auto;">

<div class="form-group" style='text-align:left;'>
<div style="display:inline-block;margin-left:40px;font-size:26px;color:red;margin-top:15px; 
">面巡专家:{{ manager_id }}
</div>  
</div>
<hr size="2" color="#FF0000" style="width:90%;"/>
<div style="width:90%;overflow:hidden;display:inline-block;">
    <table id="grid-table"></table>
    <div id="grid-pager"></div>   
</div>
<div style="width:90%;overflow:hidden;display:inline-block;">
    <table id="grid-table-2"></table>
    <div id="grid-pager-2"></div>   
</div>
<div class='form-group' style='margin-top:10px; margin-right:60px;text-align:right'>
<form action='/pm' class="form-inline" method='post'>
                    <input id='page' value='2' name='page' type='hidden'/>
                    <button type='submit' class='btn btn-success' style='width:80px;'>返回上层</button>
</form>
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
    getInfo('#grid-table', '#grid-pager','未分配人员列表', '/pm/listexaminee','/pm/updateexaminee' );
    getInfo('#grid-table-2','#grid-pager-2','已分配人员列表','/pm/listexaminee','/pm/updateexaminee' );
    function getInfo(table,paper,title, url, editurl){
        var grid_selector = table;
        var pager_selector = paper;
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
            url: url,
            editurl: editurl,
            datatype: "json",
            height: '260px',
            shrinkToFit:false,
            hidegrid:false,
            autowidth:true,
            
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
                     {  name:'state', label:'是否为绿色通道人员',  index:'state', width:240, fixed:true, resizable:false,  editable:true,sortable:false, align:'center',
                        editrules:{required : true, }, 
                        search:true, searchoptions: {  sopt: ['eq']  },
                        searchrules:{ required: true, },
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
            caption: title,
            multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,
    
        });
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
                         "<p class=\"bg-success\" style='padding:20px;'>被试人员纪录删除成功</p>"
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
            {   //navbar options
                add: false,
                edit: false,
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
});
</script>