<script type="text/javascript" src= '/datetimepicker/bootstrap.min.js'></script>

<div class="Leo_question"  style="overflow:auto;">
    <div class="title" style="text-align:center;padding:8px;font-size:26px;">您对&nbsp;{{ name }}&nbsp;的意见及建议</div>
    <div class="point" style="text-align:center;">
        <table border="1" cellspacing="0" cellpadding="0" style="margin: 0 auto;font-size:18px;" name='{{examinee_id}}'>
            <tr>
                <td rowspan="5" style="width:100px;">优势</td>
                <td colspan="4" style="width:550px;">1. <input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:520px;font-size:18px;" id="advantage1"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;">2. <input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:520px;font-size:18px;" id="advantage2"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;">3. <input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:520px;font-size:18px;" id="advantage3"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;">4. <input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:520px;font-size:18px;" id="advantage4"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;">5. <input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:520px;font-size:18px;" id="advantage5"></td>
            </tr>
            <tr>
                <td rowspan="3" style="width:100px;">改进</td>
                <td colspan="4" style="width:550px;">1. <input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:520px;font-size:18px;" id="disadvantage1"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;">2. <input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:520px;font-size:18px;" id="disadvantage2"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;">3. <input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:520px;font-size:18px;" id="disadvantage3"></td>
            </tr>
            <tr>
                <td rowspan="2" style="width:100px;">潜质</td>
                <td style="width:130px;padding:3px;">优</td>
                <td style="width:130px;padding:3px;">良</td>
                <td style="width:130px;padding:3px;">中</td>
                <td style="width:130px;padding:3px;">差</td>
            </tr>
            <tr>
                <td id="level1" style="width:130px;padding:3px;color:red;"></td>
                <td id="level2" style="width:130px;padding:3px;color:red;"></td>
                <td id="level3" style="width:130px;padding:3px;color:red;"></td>
                <td id="level4" style="width:130px;padding:3px;color:red;"></td>
            </tr>
            <tr>
                <td style="width:100px;">评价</td>
                <td style="width:550px;" colspan="4"><textarea name="text" type="name" class="inputtxt" style="border:0px;height:60px;width:550px;font-size:18px;" id="remark"></textarea></td>
            </tr>
        </table>
    </div>

    <div style="width:100%;height:40px;text-align:center;padding:10px;">
        <div class="form-group">
            <a class="btn btn-primary" href="/interviewer/index">
            <i class="glyphicon glyphicon-home"></i>&nbsp;返回</a>
            <a id="submit" class="btn btn-success">
            <i class="glyphicon glyphicon-pencil"></i>&nbsp;保存</a>
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

<script type="text/javascript">
    $('#myModal').on('hidden.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
    });
    $('#myModal').on('hide.bs.modal', function (e) {
        $('.Leo_question').css('width','860px')
    });

    $(function(){
        $.post('/interviewer/getPoint/'+{{examinee_id}}, function(data){
            if (data.error) {
                 $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<a href='/managerlogin'><button type=\"button\" class=\"btn btn-primary\">重新登录</button></a>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
            }else{
                $('#advantage1').val(data.point.advantage1);
                $('#advantage2').val(data.point.advantage2);
                $('#advantage3').val(data.point.advantage3);
                $('#advantage4').val(data.point.advantage4);
                $('#advantage5').val(data.point.advantage5);
                $('#disadvantage1').val(data.point.disadvantage1);
                $('#disadvantage2').val(data.point.disadvantage2);
                $('#disadvantage3').val(data.point.disadvantage3);
                $('#remark').val(data.point.remark);
                if (data.point.level == 1) {
                    document.getElementById('level1').innerHTML = "&radic;";
                }else if (data.point.level == 2) {
                    document.getElementById('level2').innerHTML = "&radic;";
                }else if (data.point.level == 3) {
                    document.getElementById('level3').innerHTML = "&radic;";
                }else{
                    document.getElementById('level4').innerHTML = "&radic;";
                }
            }
        });
    });

    $("#submit").click(function(){
    	var comment = {
            "advantage1" : $("#advantage1").val(),
            "advantage2" : $("#advantage2").val(),
            "advantage3" : $("#advantage3").val(),
            "advantage4" : $("#advantage4").val(),
            "advantage5" : $("#advantage5").val(),
            "disadvantage1" : $("#disadvantage1").val(),
            "disadvantage2" : $("#disadvantage2").val(),
            "disadvantage3" : $("#disadvantage3").val(),
            "remark" : $("#remark").val(),
        };
        if($("#advantage1").val() == '' && $("#advantage2").val() == '' && $("#advantage3").val() == '' && $("#advantage4").val() == '' && $("#advantage5").val() == '' && $("#disadvantage1").val() == '' && $("#disadvantage2").val() == '' && $("#disadvantage3").val() == '' && $("#remark").val() == '' ){
            $('.Leo_question').css('width','843px')
            $('.modal-body').html('');
            $('.modal-body').html(
                "<p class=\"bg-danger\" style='padding:20px;'>"+"评论为空，不能提交！"+ "</p>"
                );
            $('.modal-footer').html('');
            $('.modal-footer').html(
                "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">关闭提示</button>"
            );
            $('#myModal').modal({
                keyboard:true,
                backdrop:'static'
            })
        }else{
    	   $.post('/interviewer/interview/'+{{examinee_id}},comment,callbk);
        }
    })
        
        function callbk(data){
            if(data.success){
                $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-success\" style='padding:20px;'>"+"评论提交成功！"+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">留在本页</button>"+"<span>&nbsp;&nbsp;</span>"+"<a href='/interviewer/index'><button type=\"button\" class=\"btn btn-primary\"  onclick=\"check();\">返回主页面</button></a>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
                //window.location.href = '/interviewer/index';
            }else{
                 $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+data.error+ "</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">关闭提示</button>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
            }
        }

</script>