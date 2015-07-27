
<style>
.dashboard-layout .widget-box {
   /* padding: 0;*/
    background-color: #F7F7F7;
    -webkit-box-shadow: none;
    box-shadow: none;
    margin: 3px 10px 0 10px ;
}
</style>

<!-- <link type="text/css" rel="stylesheet" href="/jqGrid/css/ui.jqgrid.css"> -->
<!-- <link type="text/css" rel="stylesheet" href="/jqGrid/css/jquery-ui.min.css"> -->

<div class="main-container">
    <div class="main-content" style="margin-top:30px;">
    	<div class="col-xs-12 col-sm-3 col-sm-offset-1">
	    	<div class="visible widget-box">
	            <div class="widget-main">
	                <h4 class="header blue lighter bigger text-center">
	                    欢迎使用系统管理台
	                </h4>

	                <div class="space-6"></div>

	                <div class='text-center'>
	                	欢迎您，<a href='#'>{{ admin }}</a>！
	                	<br>
						<a href="/">主页</a>  <a href="/managerlogin/logout">登出</a>
	                </div>
	             
					<div class="space-6"></div>
	                <ol id="main_nav" class="nav nav-pills nav-stacked" role="tablist">
					 	<li><a href="#"><span class='glyphicon glyphicon-home'></span> DashBoard</a></li>
						<li><a href="#"><span class='glyphicon glyphicon-import'></span> 题库导入</a></li>
						<li><a href="#"><span class='glyphicon glyphicon-edit'></span> 题目编辑</a></li>
						<li><a href="#"><span class='glyphicon glyphicon-user'></span> 账户管理</a></li>
						<li><a href="#"><span class='glyphicon glyphicon-file'></span> 审核申请</a></li>
						<li><a href="#"><span class='glyphicon glyphicon-cog'></span> 网站配置</a></li>
					</ol>
	            </div>
	            <!-- /.widget-main -->
	        </div>
        </div>
        <div class="col-sm-7 col-xs-12">
	    	<div class="visible widget-box">
	            <div id="main_div" class="widget-main">
	            </div>
	            <!-- /.widget-main -->
	        </div>
        </div>
    </div>
</div>
