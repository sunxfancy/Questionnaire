grid_selector = "#grid-table";
pager_selector = "#grid-pager";

#resize to fit page size
$(window).on('resize.jqGrid',  () ->
    $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() )
)
#resize on sidebar collapse/expand
parent_column = $(grid_selector).closest('[class*="col-"]')
$(document).on('settings.ace.jqGrid' , (ev, event_name, collapsed) ->
    if( event_name == 'sidebar_collapsed' || event_name == 'main_container_fixed' ) 
        $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() )
)

$("#grid-table").jqGrid({
    url: '/admin/getrequest',
    datatype:"json", # 数据来源，本地数据
    mtype:"GET", # 提交方式
    height:420,# 高度，表格高度。可为数值、百分比或'auto'
    # width:1000,# 这个宽度不能为百分比
    autowidth:true,# 自动宽
    colNames:['添加日期', '手机号码', '银行卡号','备注','操作'],
    colModel:[
        # {name:'id',index:'id', width:'10%', align:'center' },
        {name:'createDate',index:'createDate', width:'20%',align:'center'},
        {name:'phoneNo',index:'phoneNo', width:'15%',align:'center'},
        {name:'cardNo',index:'cardNo', width:'20%', align:"center"},
        {name:'remark',index:'remark', width:'35%', align:"left", sortable:false},
        {name:'del',index:'del', width:'10%',align:"center", sortable:false}
    ],
    rownumbers:true,# 添加左侧行号
    # altRows:true,# 设置为交替行表格,默认为false
    # sortname:'createDate',
    # sortorder:'asc',
    viewrecords: true,# 是否在浏览导航栏显示记录总数
    rowNum:15,# 每页显示记录数
    rowList:[15,20,25],# 用于改变显示行数的下拉列表框的元素数组。
    jsonReader:{
        id: "back",# 设置返回参数中，表格ID的名字为back
        repeatitems : false
    },
    pager:$('#grid-pager'),

    #subgrid options
    subGrid : true,
    #subGridModel: [{ name : ['No','Item Name','Qty'], width : [55,200,80] }],
    #datatype: "xml",
    subGridOptions : {
        plusicon : "ace-icon fa fa-plus center bigger-110 blue",
        minusicon  : "ace-icon fa fa-minus center bigger-110 blue",
        openicon : "ace-icon fa fa-chevron-right center orange"
    },
    #for this example we are using local data
    subGridRowExpanded: (subgridDivId, rowId) ->
        subgridTableId = subgridDivId + "_t";
        $("#" + subgridDivId).html("<table id='" + subgridTableId + "'></table>");
        $("#" + subgridTableId).jqGrid({
            datatype: 'local',
            data: subgrid_data,
            colNames: ['No','Item Name','Qty'],
            colModel: [
                { name: 'id', width: 50 },
                { name: 'name', width: 150 },
                { name: 'qty', width: 50 }
            ]
        });
    }
)