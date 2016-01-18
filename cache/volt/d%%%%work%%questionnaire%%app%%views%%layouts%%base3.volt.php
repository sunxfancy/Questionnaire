<!DOCTYPE html>
<html lang="ch-ZN" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <title>北京市政法系统领导干部胜任力测评系统</title>
    <link rel="stylesheet" type="text/css" href="/pagecss/admin.min.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/css/Leo_global_css.css" />
    <link rel="stylesheet" type="text/css" href="/css/css/Leo_normal_css.css" />
    <script type='text/javascript' src='/js/jquery.js'></script>
    <script type='text/javascript' src='/lib/jquery.cookie.js'></script>
    <script type='text/javascript' src='/js/spin.js'></script>
    <script type='text/javascript'  src="/bootstrap/js/bootstrap.min.js"></script>
</head>

<body style="background-image:url(/image/fcbg_blur.png);">
	<div class="Leo_title">
	    <div class="Leo_title_l"><center> <?php echo $page_title; ?> </center></div>
	    <div style="width:100%;height:2px;background-color:white;"></div>
	</div>

<div class="Leo_info">
    <div style="width:100%;height:50px;"></div>
    <div class="Leo_info_user">
        <img src="/image/user2.png" />
    </div>

    <div class="Leo_info_l">

        <div style='width:190px;text-align:center;margin:0 auto;'>
            <span style="font-size:25px;font-family:'Times New Roman';font-weight:bold;"><?php echo $name; ?></span><br/>
            <span style="font-size:25px;font-family:'Times New Roman';font-weight:bold;"><?php echo $number; ?></span><br/>
            <span style="font-size:25px;font-family:'宋体';font-weight:bold;"><?php echo $role; ?></span><br/>

        </div>
        
    </div>
</div>
	<?php echo $this->getContent(); ?>
</body>