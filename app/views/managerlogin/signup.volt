{#
    本页面用于显示返回用户注册的结果
#}
<div class="main-container">
    <div class="main-content" style="margin-top:150px;">
    	<div class="col-xs-8 col-sm-offset-2">
	    	<div class="visible widget-box">
	            <div class="widget-main">
	            	{% if succeed %}
	                <div class="green" style="font-size:125px;">
						<i class="glyphicon glyphicon-ok"></i>
						<span style="font-size:64px;">恭喜您，注册成功</span>
					</div>
					<div class="text-right">
					<a class="btn btn-success btn-lg" href="/managerlogin">前往登陆 <i class='glyphicon glyphicon-arrow-right'></i></a>
					</div>
					{% else %}
					<div class="red" style="font-size:125px;">
						<i class="glyphicon glyphicon-remove"></i>
						<span style="font-size:64px;">抱歉，注册失败</span>
					</div>
					<a class="btn btn-error btn-lg" href="/managerlogin"><i class='glyphicon glyphicon-arrow-left'> 返回重新注册</i></a>
					{% endif %}
	            </div>
	            <!-- /.widget-main -->
	        </div>
        </div>
	</div>
</div>
