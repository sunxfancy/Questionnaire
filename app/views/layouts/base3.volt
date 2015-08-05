<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta charset="utf-8" />
    <title>政府评测系统</title>
    <link rel="stylesheet" type="text/css" href="/pagecss/admin.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/css/Leo_global_css.css" />
    <link rel="stylesheet" type="text/css" href="/css/css/Leo_normal_css.css" />
    <script type='text/javascript' src='/js/jquery.js'></script>
    <script type='text/javascript' src='/lib/bootstrap-datetimepicker.js'></script>
</head>

<body style="background-image:url(/image/fcbg_blur.png);">
	<div class="Leo_title">
	    <div class="Leo_title_l"><center> {{ page_title }} </center></div>
	    <div style="width:100%;height:2px;background-color:white;"></div>
	</div>

<div class="Leo_info">
    <div style="width:100%;height:50px;"></div>
    <div class="Leo_info_user">
        <img src="/image/user2.png" />
    </div>

    <div class="Leo_info_l">

        <div style='width:190px;text-align:center;margin:0 auto;'>
            <span style="font-size:25px;font-family:'Times New Roman';font-weight:bold;">{{user_name}}</span><br/>
            <span style="font-size:25px;font-family:'Times New Roman';font-weight:bold;">{{user_id}}</span><br/>
            <span style="font-size:25px;font-family:'宋体';font-weight:bold;">{{user_role}}</span><br/>

        </div>
        
    </div>
</div>
	{{ content() }}
</body>