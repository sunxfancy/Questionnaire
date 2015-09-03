
<div style="font-size:80px;color:white;margin-top:80px;font-family:'华文行楷';">政府部门测评系统</div>

<div class="Leo_login">
    <div style='font-size:40px;color:purple;text-align:center;padding:30px 0;'>欢&nbsp;迎&nbsp;登&nbsp;录</div>
    <div style='text-align:center'>
    <label for='username'><span style='font-size:25px;font-family: Microsoft YaHei UI; font-weight:normal;'>账&nbsp;号&nbsp;&nbsp;</span></label>
    <input autofocus required class='form-control' id='username' style='display:inline-block;height:36px;font-size:20px;width:180px;'/>
    </div>
    <div style='text-align:center;margin-top:10px;'>
    <label for='password'><span style='font-size:25px;font-family: Microsoft YaHei UI; font-weight:normal;'>密&nbsp;码&nbsp;&nbsp;</span></label>
    <input required type='password' class='form-control' id='password' style='display:inline-block;height:36px;font-size:20px;width:180px;'/>
    </div>
    <div style="height:30px;"></div>
    <div style="text-align:center">
         <button type="submit" id='submit' class='btn btn-warning' style='color:#000;border:0; width:75%; background-color:#d49a3e; font-size:20px; padding:5px;font-family: Microsoft YaHei;'
         onmouseover ="this.style.backgroundColor = '#e56419' ;this.style.color='#FFF' ;this.style.fontSize='21px' ;this.style.paddingTop='4px';" 
         onmouseout  ="this.style.backgroundColor = '#d49a3e' ;this.style.color='#000' ;this.style.fontSize='20px' ;this.style.paddingTop='5px';"
         >登&nbsp;&nbsp;录</button>
    </div>          
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">提示信息</h4>
        </div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">关闭提示</button>
        </div>
    </div>
  </div>
</div>

<script type='text/javascript'>
<!--
var opts = {
  lines: 10 // The number of lines to draw
, length: 4 // The length of each line
, width: 1 // The line thickness
, radius: 5 // The radius of the inner circle
, scale: 1.25 // Scales overall size of the spinner
, corners: 0.75 // Corner roundness (0..1)
, color: '#d49a3e' // #rgb or #rrggbb or array of colors
, opacity: 0.1 // Opacity of the lines
, rotate: 10 // The rotation offset
, direction: 1 // 1: clockwise, -1: counterclockwise
, speed: 2 // Rounds per second
, trail: 60 // Afterglow percentage
, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
, zIndex: 2e9 // The z-index (defaults to 2000000000)
, className: 'spinner' // The CSS class to assign to the spinner
, top: '49%' // Top position relative to parent
, left: '49%' // Left position relative to parent
, shadow: true // Whether to render a shadow
, hwaccel: false // Whether to use hardware acceleration
, position: 'absolute' // Element positioning
}


$("body").keypress(function(event) {
      /* Act on the event */
      
      if(event.which==13){
      	if( $("#username").val() != '' && $("#password").val() != ''){
      		spinner = new Spinner(opts).spin(target);
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
var target = document.getElementById('submit');
var spinner = null;
$(document).ready(function() {

    $("#submit").click(function(){
    	   if( $("#username").val() != '' && $("#password").val() != ''){
    	         spinner = new Spinner(opts).spin(target);
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
            
            $.post('/Examinee/login', login_info, callbk);
}

    function callbk(data){
        
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
//-->

</script>
