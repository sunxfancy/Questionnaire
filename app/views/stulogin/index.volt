{#
    本页面用于显示学生用户登陆的界面
#}
{{ partial("shared/login") }}
<style>
    @media screen and (max-width:768px){
        #qrdiv {
            display: none;
        }
        .center span{
            font-size: x-large;
        }
    }
    @media screen and (min-width: 768px) {
        .center span{
            font-size: 28px;
        }
        .center{
            margin-top: 80px;
            margin-bottom: 40px;
        }
    }
</style>
<div id="qrdiv"
     style="position: fixed;bottom: 40px;right: 40px;width:105px;height:70px;background-color: #eee;padding: 5px;">
    <i class="fa fa-qrcode fa-5x" style="float: left"></i>

    <div style="margin-left: 55px;">扫描二维码手机答题</div>
    <div id="qrcode"
     style="display:none;position: fixed;bottom: 110px;right: 155px;padding:10px;margin:0;background-color: #007998;">
    </div>
</div>
<script>

    window.onload = function () {
        var location = window.location+"";
        $("#qrcode").qrcode({
            text: location,
            width: 192,
            height: 192
        });
        $("#qrdiv").mouseover(function () {
            $("#qrcode").css("display", "block");
        });
        $("#qrdiv").mouseout(function () {
            $("#qrcode").css("display", "none");
        });
    };
</script>