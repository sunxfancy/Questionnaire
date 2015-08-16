<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>政府评测系统登陆</title>
    <link rel="stylesheet" type="text/css" href="/css/css/Leo_global_css.css" />
    <link rel="stylesheet" type="text/css" href="/css/css/Leo_login_css.css" />
    <script type='text/javascript' src='/js/jquery.js'></script>
</head>

<body style="background-image:url(/image/fcbg.png);" >
	{{ content()}}

<script type="text/javascript">
	$(function(){
		$("body").keypress(function(event) {
			/* Act on the event */
			
			if(event.which==13){
           		 var login_info ={
	                "username" :$("#username").val(),
	                "password" :$("#password").val()
          		  }

          	 	 $.post('/managerlogin/login', login_info, callbk);

    			}
		});

		function callbk(data){
        if(data.url){
            window.location.href = data.url;
        }else{
            alert(data.error);
        }
}
	})


</script>
</body>
</html>