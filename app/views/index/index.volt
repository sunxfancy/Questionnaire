{#
    本文件用于学校管理员用户后台管理页面(申请学校成功后)
        管理功能           页面           子页面
        测评              test.volt       import.volt
#}



<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2 col-sm-offset-1 navbar-div">
            <div class="title-div">
                学校后台管理页面
            </div>
            <div class="space-6"></div>
            <div class='text-center'>
                欢迎您，<a href='#'>{{ admin }}</a>！
                <br>
                <a href="/">主页</a> <a href="/managerlogin/logout">登出</a>
            </div>
            <div class="space-6"></div>
            <ul class="nav nav-pills nav-stacked" role="tablist">
                <li role="presentation" targetpage="surveylist" class="menu-li active"><a href="javascript:void(0);">查看测评列表</a></li>
                <li role="presentation" targetpage="test/0" class="menu-li"><a href="javascript:void(0);">添加新测评</a></li>
            </ul>
        </div>

        <div class="col-sm-8 content-div">

        </div>
    </div>
</div>

