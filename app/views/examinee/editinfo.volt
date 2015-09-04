<script type="text/javascript" src="/jqGrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="/jqGrid/js/i18n/grid.locale-cn.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>
<script type="text/javascript" src="/datepicker/js/kit.js"></script>
        <!--[if IE]>
        <script src="/datepicker/js/ieFix.js"></script>
        <![endif]-->
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-30210234-1']);
            _gaq.push(['_trackPageview']); (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

        </script>
        <script src="/datepicker/js/array.js"></script>
        <script src="/datepicker/js/date.js"></script>
        <script src="/datepicker/js/dom.js"></script>
        <script src="/datepicker/js/selector.js"></script>
<!--widget-->
<script src="/datepicker/js/datepicker.js"></script>
<link rel="stylesheet" href="/datepicker/css/datepicker.css" />


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
                        <div class="input-append date form_datetime">
                            <input id="birthday" type="text" style="width:178px;height:31px;color:black;" placeholder='格式:1970-8-18'>
                        </div>
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
                    <td colspan="3" style="font-size: 16px;"><input id="team" type="text"  style="width:478px;font-size:16px;color:black;"></td>
                </tr>
            </table>

            <div style="width:600px;margin:0 auto;overflow:hidden;padding:10px 0;">
                <table id="grid-table1"></table>
            </div>
            <div style="width:600px;margin:0 auto;overflow:hidden;">
                <table id="grid-table2"></table>
            </div>
            
            <div style="width:600px;margin:0 auto;padding:10px;">
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
                    "&nbsp;&nbsp;<a href='/'><button type=\"button\" class=\"btn btn-primary\">退出</button></a>"
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
     	         $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回修改</button>"+
                    "&nbsp;&nbsp;<a href='/'><button type=\"button\" class=\"btn btn-primary\">退出</button></a>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
     }else{
     	        $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-success\" style='padding:20px;'>提交成功！点击确定跳转到答题页面！</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<a href='/examinee/doexam'><button type=\"button\" class=\"btn btn-success\">确认</button></a>"
                   
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
     }     	
    });
});
// 时间控件
$kit.$(function() {
                //默认日历
                var picker = new $kit.ui.DatePicker();
                picker.init();
                $kit.el('#birthday').appendChild(picker.picker);
                picker.show();
                picker.ev({
                    ev : 'change',
                    fn : function(e) {
                        // alert(picker.getValue());
                    }
                })
                //输入框下拉
                $kit.ev({
                    el : '#birthday',
                    ev : 'focus',
                    fn : function(e) {
                        var d, ipt = e.target;
                        d = e.target[$kit.ui.DatePicker.defaultConfig.kitWidgetName];
                        if(d) {
                            d.show();
                        } else {
                            d = new $kit.ui.DatePicker({
                                date : ipt.value
                            }).init();
                            d.adhere($kit.el('#birthday'));
                            d.show();
                        }
                    }
                });     

})

</script> 
