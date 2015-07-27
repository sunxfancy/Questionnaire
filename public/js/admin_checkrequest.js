(function() {
  var grid_selector, pager_selector, parent_column;

  grid_selector = "#grid-table";

  pager_selector = "#grid-pager";

  $(window).on('resize.jqGrid', function() {
    return $(grid_selector).jqGrid('setGridWidth', $(".page-content").width());
  });

  parent_column = $(grid_selector).closest('[class*="col-"]');

  $(document).on('settings.ace.jqGrid', function(ev, event_name, collapsed) {
    if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
      return $(grid_selector).jqGrid('setGridWidth', parent_column.width());
    }
  });

  $("#grid-table").jqGrid({
    url: '/admin/getrequest',
    datatype: "json",
    mtype: "GET",
    height: 420,
    autowidth: true,
    colNames: ['添加日期', '手机号码', '银行卡号', '备注', '操作'],
    colModel: [
      {
        name: 'createDate',
        index: 'createDate',
        width: '20%',
        align: 'center'
      }, {
        name: 'phoneNo',
        index: 'phoneNo',
        width: '15%',
        align: 'center'
      }, {
        name: 'cardNo',
        index: 'cardNo',
        width: '20%',
        align: "center"
      }, {
        name: 'remark',
        index: 'remark',
        width: '35%',
        align: "left",
        sortable: false
      }, {
        name: 'del',
        index: 'del',
        width: '10%',
        align: "center",
        sortable: false
      }
    ],
    rownumbers: true,
    viewrecords: true,
    rowNum: 15,
    rowList: [15, 20, 25],
    jsonReader: {
      id: "back",
      repeatitems: false
    },
    pager: $('#grid-pager'),
    subGrid: true,
    subGridOptions: {
      plusicon: "ace-icon fa fa-plus center bigger-110 blue",
      minusicon: "ace-icon fa fa-minus center bigger-110 blue",
      openicon: "ace-icon fa fa-chevron-right center orange"
    },
    subGridRowExpanded: function(subgridDivId, rowId) {
      var subgridTableId;
      subgridTableId = subgridDivId + "_t";
      $("#" + subgridDivId).html("<table id='" + subgridTableId + "'></table>");
      return $("#" + subgridTableId).jqGrid({
        datatype: 'local',
        data: subgrid_data,
        colNames: ['No', 'Item Name', 'Qty'],
        colModel: [
          {
            name: 'id',
            width: 50
          }, {
            name: 'name',
            width: 150
          }, {
            name: 'qty',
            width: 50
          }
        ]
      });
    }
  });

}).call(this);
