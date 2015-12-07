
<div style="font-size:65px;color:white;margin-top:195px;margin-left:-55px;font-family:'华文中宋';">北京市政法系统领导干部<br /><span style='visibility: hidden;'>欢迎页&nbsp;</span>胜任力测评系统</div>
<div class="Leo_login" style='position:absolute;top:180px;right:150px;'>
    <div style='font-size:40px;color:purple;text-align:center;padding:30px 0;color:white;'>欢&nbsp;迎&nbsp;登&nbsp;录</div>
    <div style='text-align:center'>
        <label for='username'><span style='font-size:25px;font-family: Microsoft YaHei UI; font-weight:normal;'>账&nbsp;号&nbsp;&nbsp;</span></label>
        <input autofocus required class='form-control' id='username' style='display:inline-block;height:36px;width:180px;font-size:20px;padding:2px 10px;'/>
    </div>
    <div style='text-align:center;margin-top:10px;'>
        <label for='password'><span style='font-size:25px;font-family: Microsoft YaHei UI; font-weight:normal;'>密&nbsp;码&nbsp;&nbsp;</span></label>
        <input required type='password' class='form-control' id='password' style='display:inline-block;height:36px;padding:2px 10px;font-size:20px;width:180px;'/>
    </div>
    <div style="height:30px;"></div>
    <div style="text-align:center">
         <button type="submit" id='submit' class='btn btn-warning' style='color:#000;border:0; width:75%; background-color:rgba(229,100,25,0.7); font-size:20px; padding:5px;font-family: Microsoft YaHei;' onmouseover= "this.style.backgroundColor = 'rgba(229,100,25,0.5)' ;this.style.color='#FFF' ;" onmouseout  ="this.style.backgroundColor = 'rgba(229,100,25,0.7)' ;this.style.color='#000' ">登&nbsp;&nbsp;录</button>
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
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">关闭提示</button>
        </div>
    </div>
  </div>
</div>

<script type='text/javascript'>
var target = document.getElementById('submit');
var spinner = null;

$(document).ready(function() {
    $("body").keypress(function(event) {
      /* Act on the event */
      if(event.which==13){
      	    if( $('.modal-body').html() != '' ){
      	    	$('.modal-body').html(''); 
      	    	$('#myModal').modal('hide')
      	    }else if ( $("#username").val() != '' && $("#password").val() != ''){
                spinner = new Spinner().spin(target);
                checkup_login(spinner);
            }else{
                if($("#username").val() == ''){
                     $("#username").focus();
                }else{
                     $("#password").focus();
                }
            }
      }

});
$("#submit").click(function(){
    if( $("#username").val() != '' && $("#password").val() != ''){
    	spinner = new Spinner().spin(target);
        checkup_login(spinner);
    }else{
   	    $('.modal-body').html('');
        $('.modal-body').html(
             "<p class=\"bg-danger\" style='padding:20px;'>输入不能为空</p>"
        );
        $('#myModal').modal({
            keyboard:true,
        })
    }
    });
    
});
function checkup_login(spinner){
    var login_info ={
                "username" :$("#username").val(),
                "password" :$("#password").val()
            }
            
    $.post('/Index/login', login_info, checkup_login_callbk);
}
function checkup_login_callbk(data){
        if(data.url){
            window.location.href = data.url;
        }else{
        	spinner.stop();
        	$('.modal-body').html('');
        	$('.modal-body').html(
        		"<p class=\"bg-danger\" style='padding:20px;'>"+data.error+"</p>"
        	);
        	$('#myModal').modal({
        		keyboard:true,
        	})
            // alert(data.error);

        }
}
</script>
