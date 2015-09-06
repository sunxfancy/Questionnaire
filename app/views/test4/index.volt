<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>

<div class="Leo_question">
    <table id="list5"></table>
    <div id="pager5"></div>
</div>
<script>
$(function(){
  pageInit();
});
function pageInit(){
  jQuery("#list5").jqGrid(
      {
        url : '/examinee/listedu',
        datatype : "json",
        height:'auto',
        autowidth:true,
        colNames:['序号','毕业院校','专业','所获学位','起止时间'],
            colModel:[
                {name:'id',index:'', width:70, fixed:true, sortable:true, resize:false, align:'center' },               
                {name:'school', index:'school', width:140, editable: true, sortable:false, align:'center'},
                {name:'profession', index:'profession', sortable:false, width:140, editable:true, align:'center'},
                {name:'degree', index:'degree', width:80, sortable:false, editable:true, align:'center'},
                {name:'date', index:'date', sortable:true, width:110, editable: true,edittype:'text',align:'center'}
                ],
        rowNum : 10,
        rowList : [ 10, 20, 30 ],
        pager : '#pager5',
        viewrecords : true,
        sortorder : "asc",
        caption : "教育经历",
        editurl : "/examinee/updateedu"
      }).navGrid('#pagerb',{
 add: true,
 addtext: "添加 ",
 del: false,
 edit: true,
 edittext: "修改 ",
 position: "left",
 view: true,
 viewtext: "查看 ",
 search: false,
 refreshtitle: "刷新",
 refreshtext: "刷新 ",
 alertcap: "提示信息"
},{ //edit 编辑时
 top : 10,  //位置
 left: 200, //位置
 height:480, //大小
 width:750, //大小
 
},{ //add 添加时
 top : 10,
 left: 200,
 height:480,
 width:750,
 
},{ //del
},{ //search
},{ //view
}
);
        


 
}
    
</script>