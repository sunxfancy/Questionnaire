updata = (url) ->
	$.get(url,(data) ->
		$("#main_div").html(data)
	)

updata('/admin/dashboard')
$('#main_nav li').first().attr('class','active')

$('#main_nav li').each((index,value)->
	$(this).attr('index',index);
)

url = [
	#'/admin/dashboard'
	'/admin/questionimport'
	'/admin/questioneditor'
	'/admin/authmanager'
	'/admin/checkrequest'
	'/admin/setting'
]

$('#main_nav li').click(()->
	$(this).siblings().attr('class','')
	$(this).attr('class','active')
	updata(url[$(this).index()])
)

jumpto = (p) ->
	$('#main_nav li').attr('class','')
	$('#main_nav').index(p).attr('class','active')
	updata(url[p])
