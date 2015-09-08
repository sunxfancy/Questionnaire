<!--引入时间控件样式表-->
<link rel="stylesheet" href="/datepicker/jquery.ui.datepicker.css" />
<!--引入时间控件js-->
<script type='text/javascript' src="/datepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="/datepicker/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="/datepicker/jquery.ui.datepicker-zh-CN.min.js"></script>
<!-- jqgrid 组件-->
<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>


<div class="Leo_question">
    <div class="baseinfo" style="width:100%;height:100%;overflow:auto; ">
        <div style="height:440px;">
            <div style="padding:10px;text-align:center;font-size:28px;">基本信息</div>
            <table border="1" cellspacing="0" cellpadding="0" style="margin:0 auto;font-size:16px; font-family:'微软雅黑'">
                <tr>
                    <td style="width:120px;line-height:33px;">&nbsp;姓名</td>
                    <td style="width:180px;"><input id="name" type="text" style="width:178px;font-size:16px;color:black;"></td>
                    <td style="width:120px;line-height:33px;">&nbsp;性别</td>
                    <td style="width: 180px;">
                        <select id="sex" type="text" style="width:178px;font-size:16px;color:black;line-height:28px;font-family:'微软雅黑'">
                            <option value="男">男</option>
                            <option value="女">女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width:120px;line-height:33px;">&nbsp;学历</td>
                    <td style="width:180px;">
                        <select id="education" type="text"  style="width:178px;font-size:16px;color:black;line-height:28px;font-family:'微软雅黑'">
                            <option value="职高">职高</option>
                            <option value="中专">中专</option>
                            <option value="技校">技校</option>
                            <option value="专科">专科</option>
                            <option value="本科">本科</option>
                            <option value="研究生">研究生</option>
                            <option value="其他">其他</option>
                        </select>
                    </td>
                    <td style=" width:120px;line-height:33px;">&nbsp;学位</td>
                    <td style="width:180px;">
                        <select id="degree" type="text"  style="width:178px;font-size:16px;color:black;line-height:28px; font-family:'微软雅黑'">
                            <option value="无">无</option>
                            <option value="学士">学士</option>
                            <option value="硕士">硕士</option>
                            <option value="博士">博士</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">&nbsp;出生年月</td>
                    <td style="width:180px;">
                            <input id="birthday" type="text" style="width:178px;height:31px;color:black;">
                    </td>
                    <td style=" width:120px;line-height:33px;">&nbsp;籍贯</td>
                    <td style="width:180px;">
                        <select id="native" type="text" style="width:178px;font-size:16px;color:black;line-height:28px; font-family:'微软雅黑'">
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
                    <td style=" width:120px;line-height:33px;">&nbsp;政治面貌</td>
                    <td style="width:180px;">
                        <select id="politics" type="text"  style="width:178px;font-size:16px;color:black;line-height:28px;font-family:'微软雅黑'">
                            <option value="无党派">无党派</option>
                            <option value="团员">团员</option>
                            <option value="党员">党员</option>
                            <option value="群众">群众</option>
                            <option value="民主党派">民主党派</option>
                        </select>
                    </td>
                    <td style=" width:120px;line-height:33px;">&nbsp;职称</td>
                    <td style="width:180px;">
                        <select id="professional" type="text"  style="width:178px;font-size:16px;color:black;line-height:28px;font-family:'微软雅黑'">
                            <option value="无职称">无职称</option>
                            <option value="初级">初级</option>
                            <option value="中级">中级</option>
                            <option value="副高职">副高职</option>
                            <option value="正高职">正高职</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">&nbsp;工作单位</td>
                    <td colspan="3" style="font-size:16px;"><input id="employer" type="text" style="width:478px;font-size:16px;color:black;"></td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">&nbsp;部门</td>
                    <td colspan="3" style="font-size: 16px;"><input id="unit" type="text"  style="width:478px;font-size:16px;color:black;"></td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">&nbsp;岗位/职务</td>
                    <td colspan="3" style="font-size: 16px;"><input id="duty" type="text" style="width:478px;font-size:16px;color:black;"></td>
                </tr>
                <tr>
                    <td style=" width:120px;line-height:33px;">&nbsp;班子/系统成员</td>
                    <td colspan="3" style="font-size: 16px;">
                    	 <select id="team" type="text"  style="width:178px;font-size:16px;color:black;line-height:28px;font-family:'微软雅黑'">
                            <option value="">无</option>
                            <option value="班子">班子</option>
                            <option value="系统">系统</option>
                        </select>
                    </td>
                </tr>
            </table>
            
            <div style="width:602px; margin:10px auto; overflow:auto;">
                <table id="grid_table_1"></table>
                <div id="grid_paper_1"></div>
            </div>
            <div style="width:602px; margin:10px auto; overflow:auto;">
                <table id="grid_table_2"></table>
                <div id='grid_paper_2'></div>
            </div>
            
            <div style="width:600px;margin:0 auto;padding:10px 10px 60px 0px;">
                <table style="width:600px; text-align:center;">                
                <tr><td><button class="btn btn-primary" id="submit">保存</button></td></tr>
                </table>
            </div>
        </div>
    </div>
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

<script type="text/javascript" language="javascript">
    var spinner = null;
    var target = document.getElementsByClassName('Leo_question')[0];
    var url="/Examinee/getexamineeinfo";
$('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});
$('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
});

$(function(){
	getInfo(url);
	$("#birthday").datepicker();
});
function getInfo(url){
        spinner = new Spinner().spin(target);
        $.post(url, {'paper_name':"inquery"}, function(data) {
            if(data.error){
                 if(spinner){ spinner.stop(); }
                 $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<a href='/examinee/editinfo'><button type=\"button\" class=\"btn btn-primary\">刷新</button></a>"+
                    "&nbsp;&nbsp;&nbsp;<a href='/'><button type=\"button\" class=\"btn btn-primary\">退出</button></a>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
            }else{
                 if(spinner){ spinner.stop(); }
                 $('.Leo_question').css('width','860px');
                 //加载成功后获取jqgrid数据
                 renderring(data.question);    
                 start_gqgrid();
            }
        });
}
function renderring(data){
    $('#name').val(data.name);
    $('#sex').val(data.sex);
    $('#education').val(data.education);
    $('#degree').val(data.degree);
    $('#birthday').val(data.birthday);
    $('#native').val(data.native);
    $("#politics").val(data.politics);
    $("#professional").val(data.professional);
    $("#employer").val(data.employer);
    $("#unit").val(data.unit);
    $("#duty").val(data.duty);
    $("#team").val(data.team);
}
$("#submit").click(function(){
	 spinner = new Spinner().spin(target);
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
    $.post('/examinee/submit', base_info, function(data){
     
     if(data.error){
     	  if(spinner){ spinner.stop(); }
     	         $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回修改</button>"
                    //+"&nbsp;&nbsp;&nbsp;<a href='/'><button type=\"button\" class=\"btn btn-primary\">退出</button></a>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
     }else{
     	  if(spinner){ spinner.stop(); }
     	        $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-success\" style='padding:20px;'>提交成功！单击查看确认个人信息，或者点击确定跳转到答题页面！</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                 	"<a href='/examinee/editinfo'><button type=\"button\" class=\"btn btn-primary\">查看</button></a>"+
                    "&nbsp;&nbsp;&nbsp;<a href='/examinee/doexam'><button type=\"button\" class=\"btn btn-success\">确认</button></a>"
                   
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
     }     	
    });
});


//jqgrid控件
function datecheck (value,colName) {
	var pattern = new RegExp("^[1-9][0-9]{3}[/](0?[1-9]|1[012])[-][1-9][0-9]{3}[/](0?[1-9]|1[012])$");
    if (value.match(pattern) ) {
        return [true, ""];
    }else{
    	return [false, colName+"格式如:2014/4-2015/10"];
    }
}
function start_gqgrid(){
	  var edit_options={
                    left:300,
                    top:100,
                    reloadAfterSubmit:true,
                    closeAfterEdit:true
 
        };
    var add_options={
                    left:300,
                    top:100,
                    reloadAfterSubmit:true,
                    closeAfterAdd:true
 
    };
        jQuery('#grid_table_1').jqGrid({
            url: "/examinee/listedu",
            datatype: "json",
            height: 'auto',
            autowidth: true,
            colNames:['序号','毕业院校','专业','所获学位','起止时间'],
            colModel:[
                { name:'id',         index:'id',         width:60,  fixed:true, sortable:false, editable:false,  resize:false, align:'center', 
                  editrules:{required : true} ,
                },
                { name:'school',     index:'school',     width:160, fixed:true, sortable:false, editable:true,   resize:false, align:'center', 
                  editrules:{required : true} ,
                },
                { name:'profession', index:'profession', width:160, fixed:true, sortable:false, editable:true,   resize:false, align:'center', 
                  editrules:{required : true} ,
                },
                { name:'degree',     index:'degree',     width:80,  fixed:true, sortable:false, editable:true,   resize:false, align:'center', 
                  editrules:{required : true} ,
                },
                { name:'date',       index:'date',       width:140, fixed:true, sortable:false, editable:true,   resize:false, align:'center', 
                  editrules:{required : true, custom:true, custom_func:datecheck, } ,
                },
            ],
            viewrecords : true, 
            altRows: true,
            hidegrid:false,
            rowNum:10,
            rowList : [ 10, 20, 30 ],
            pager : '#grid_paper_1',
            emptyrecords: "<span style='color:red'>还未添加记录</span>", 
            loadComplete: function(){  
            	//ajax数据返回失败
            	   if( $(this).getGridParam('userdata') != null ){
                      $('.Leo_question').css('width','843px')
                      $('.modal-body').html('');
                      $('.modal-body').html(
                        "<p class=\"bg-danger\" style='padding:20px;'>"+$(this).getGridParam('userdata')+"</p>"
                      );
                      $('.modal-footer').html('');
                      $('.modal-footer').html(
                        "<a href='/examinee/editinfo'><button type=\"button\" class=\"btn btn-primary\">重新获取</button></a>"
                      );
                      $('#myModal').modal({
                        keyboard:true,
                        backdrop:'static'
                      })
                    }else{
                    //加载页面翻转的按钮
                    updatePagerIcons(this);
                    }
            }, 
            setGridWidth: function(){ 
                $(".page-content").width();
            },        
            afterSubmit: function(){
            	alert('ee');
            },
            editurl: "/examinee/updateedu",
            caption: "教育经历"
        }).navGrid('#grid_paper_1',
        {  add: true,
           addicon : 'ace-icon fa fa-plus-circle purple',
           addtext:'添加',
           edit: true,
           editicon : 'ace-icon fa fa-pencil blue',
           edittext:'编辑',
           del: true,
           delicon : 'ace-icon fa fa-trash-o red',
           deltext:'删除',
           refresh: false,
           search: false,
           view: false,
        },
        edit_options,add_options,
        { //del 添加时
        top : 100,  //位置
        left: 300, //位置
        }
        );
         
        jQuery('#grid_table_2').jqGrid({
            url: "/examinee/listwork",
            datatype: "json",
            height: 'auto',
            autowidth: true,
            colNames:['序号','就职单位','部门','岗位/职务','起止时间'],
            colModel:[
                { name:'id',       index:'id',       width:60,   fixed:true, editable:false, sortable:false, resize:false, align:'center', 
                  editrules:{required : true} ,
                },
                { name:'employer', index:'employer', width:160,  fixed:true, editable:true,  sortable:false, resize:false, align:'center', 
                  editrules:{required : true} ,
                },
                { name:'unit',     index:'unit',     width:160,  fixed:true, editable:true,  sortable:false, resize:false, align:'center', 
                  editrules:{required : true} ,
                },
                { name:'duty',     index:'duty',     width:80,   fixed:true, editable:true,  sortable:false, resize:false, align:'center', 
                  editrules:{required : true} ,
                },
                { name:'date',     index:'date',     width:140,  fixed:true, editable:true,  sortable:false, resize:false, align:'center', 
                  editrules:{required : true, custom:true, custom_func:datecheck,}
                },
                ], 
            viewrecords : true, 
            altRows: true,
            hidegrid:false,
            rowNum:10,
            rowList : [ 10, 20, 30],
            pager : '#grid_paper_2',
            emptyrecords: "<span style='color:red'>还未添加记录</span>", 
            editurl: "/examinee/updatework",
            caption: "工作经历",
    
        }).navGrid('#grid_paper_2',
          {  
           add: true,
           addicon : 'ace-icon fa fa-plus-circle purple',
           addtext:'添加',
           edit: true,
           editicon : 'ace-icon fa fa-pencil blue',
           edittext:'编辑',
           del: true,
           delicon : 'ace-icon fa fa-trash-o red',
           deltext:'删除',
           refresh: false,
           search: false,
           view: false,
        },
        edit_options,add_options,
        { //del 添加时
        top : 100,  //位置
        left: 300, //位置
        }
        );
 
    }
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
</script> 
