<head>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	{{ get_title() }}
	{{ assets.outputCss() }}
	{{ assets.outputJs('header') }}
	<!--[if lte IE 9]>
	{{ assets.outputCss('header-ie9-css') }}
	{{ assets.outputJs('header-ie9') }}
	<![endif]-->
	<script>
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "//hm.baidu.com/hm.js?0739e2659c63e5d8cc53c0420c9e3e7a";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
	</script>

 </head>
<body class="blur-login">
	
	{{ flash.output() }}

	<div class="main-container">
	    <div class="main-content">
	    	<div class="col-xs-12 col-sm-3 col-sm-offset-1">
		    	<div class="visible widget-box">
		            <div class="widget-main">
		                <h4 class="header blue lighter bigger">
		                    欢迎使用系统管理台
		                </h4>

		                <div class="space-6"></div>

		                <ol class="nav nav-pills nav-stacked" role="tablist">
							<li><a href="#"><span class='glyphicon glyphicon-home'></span> DashBoard</a></li>
							<li><a href="#"><span class='glyphicon glyphicon-user'></span> 账户分配</a></li>
							<li><a href="#"><span class='glyphicon glyphicon-file'></span> 审核申请</a></li>
							<li><a href="#"><span class='glyphicon glyphicon-cog' ></span> 网站配置</a></li>
						</ol>
		            </div>
		            <!-- /.widget-main -->
		        </div>
	        </div>
	        <div class="col-sm-7 col-xs-12">
		    	<div class="visible widget-box">
		            <div class="widget-main">
		                <h4 class="header blue lighter">
		                    <ol class="breadcrumb">
		                      <span class='glyphicon glyphicon-home blue'></span>
							  <li><a href="#">Home</a></li>
							  <li class="active">DashBoard</li>
							</ol>
		                </h4>

		                <div class="space-6"></div>

		                <div>
		                	
		                </div>
		            </div>
		            <!-- /.widget-main -->
		        </div>
	        </div>
	    </div>
	</div>
	
	<!-- javascript -->
	{{ assets.outputJs('footer') }}	

</body>