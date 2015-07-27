<h4 class="header blue lighter">
    <ol class="breadcrumb">
      <span class='glyphicon glyphicon-home blue'></span>
	  <li><a href="#" >Home</a></li>
	  <li class="active">网站配置</li>
	</ol>
</h4>

<div class="space-6"></div>

<form action="/admin/setsettings" method="post">
	<fieldset>
		<label class="block clearfix">
	    	邮件服务器：
			<input name="host" type="text" class="form-control" 
			value="{{settings.host}}" />
	    </label>

		<label class="block clearfix">
	    	邮箱帐号：
			<input name="username" type="text" class="form-control" 
			value="{{settings.username}}" />
	    </label>

	    <label class="block clearfix">
	    	邮箱密码：
			<input name="password" type="password" class="form-control" 
			value="{{settings.password}}" />
	    </label>

	    <label class="block clearfix">
	    	From邮箱（默认空时和邮箱帐号相同）：
			<input name="from" type="text" class="form-control" 
			value="{{settings.from}}" />
	    </label>
		
		<input type="submit" class="btn btn-primary" value="保存" />
</form>	
