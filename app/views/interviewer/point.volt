<div class="Leo_question"  style="overflow:auto;">
    <div class="title" style="text-align:center;padding:8px;font-size:26px;">您对&nbsp;{{ name }}&nbsp;的意见及建议</div>
    <div class="point" style="text-align:center;">
        <table border="1" cellspacing="0" cellpadding="0" style="margin: 0 auto;font-size:18px;" name='{{examinee_id}}'>
            <tr>
                <td rowspan="5" style="width:100px;">优势</td>
                <td colspan="4" style="width:550px;"><input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:550px;font-size:18px;" value="1. " id="advantage1"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;"><input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:550px;font-size:18px;" value="2. " id="advantage2"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;"><input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:550px;font-size:18px;" value="3. " id="advantage3"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;"><input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:550px;font-size:18px;" value="4. " id="advantage4"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;"><input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:550px;font-size:18px;" value="5. " id="advantage5"></td>
            </tr>
            <tr>
                <td rowspan="3" style="width:100px;">改进</td>
                <td colspan="4" style="width:550px;"><input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:550px;font-size:18px;" value="1. " id="disadvantage1"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;"><input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:550px;font-size:18px;" value="2. " id="disadvantage2"></td>
            </tr>
            <tr>
                <td colspan="4" style="width:550px;"><input name="text" type="name" class="inputtxt" style="border:0px;padding:3px;width:550px;font-size:18px;" value="3. " id="disadvantage3"></td>
            </tr>
            <tr>
                <td rowspan="2" style="width:100px;">潜质</td>
                <td style="width:130px;padding:3px;">优</td>
                <td style="width:130px;padding:3px;">良</td>
                <td style="width:130px;padding:3px;">中</td>
                <td style="width:130px;padding:3px;">差</td>
            </tr>
            <tr>
                <td style="width:130px;padding:3px;">{{level1}}</td>
                <td style="width:130px;padding:3px;">{{level2}}</td>
                <td style="width:130px;padding:3px;">{{level3}}</td>
                <td style="width:130px;padding:3px;">{{level4}}</td>
            </tr>
            <tr>
                <td style="width:100px;">评价</td>
                <td style="width:550px;" colspan="4"><textarea name="text" type="name" class="inputtxt" style="border:0px;height:60px;width:550px;font-size:18px;" id="remark"></textarea></td>
            </tr>
        </table>
    </div>

    <div style="width:100%;height:40px;text-align:center;padding:10px;">
        <div class="form-group">
            <a class="btn btn-primary" href="/interviewer/index">返回</a>
            <a id="submit" class="btn btn-success">保存</a>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#submit").click(function(){
            var comment = {
                "advantage" : $("#advantage1").val()+"|"+$("#advantage2").val()+"|"+$("#advantage3").val()+"|"+$("#advantage4").val()+"|"+$("#advantage5").val(),
                "disadvantage" : $("#disadvantage1").val()+"|"+$("#disadvantage2").val()+"|"+$("#disadvantage3").val(),
                "remark" : $("#remark").val()
            };
            $.post('/interviewer/interview/'+{{examinee_id}},comment,callbk);
        });

        function callbk(data){
            data = eval("("+data+")");
            if(data['status'] == 'success'){
                // alert("评论提交成功！点击“确定”返回主页面。");
                // window.location.href = '/interviewer/index'
            }else{
                alert("评论提交失败，请重新提交！");
            }
        }
    });

    function check(){
        var ad1 = document.getElementById("advantage1").innerHTML;
        console.log(ad1);
    }
</script>