

<div class="request-form col-sm-6 col-sm-offset-3 col-xs-12">
    <form action="/index/check" method="post" class="form-horizontal" role="form">
       

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 col-xs-12 control-label">大学名称</label>
            <input type="text" name="district" id="province" style="display: none;">
            <input type="text" name="name" id="school-name" value="请选择大学" onclick="pop()">
            
        </div>

        <div class="form-group">
            <div class="col-sm-offset-8 col-sm-3 hidden-xs">
                <button type="submit" class="btn btn-primary col-sm-12">提 交</button>
            </div>
            <div class="hidden-sm hidden-md hidden-lg">
                <button type="submit" class="btn btn-primary btn-block">提 交</button>
            </div>
        </div>
    </form>
</div>




<script type="text/javascript" src="/js/school.js"></script>
<div id="choose-box-wrapper">
  <div id="choose-box">
    <div id="choose-box-title">
        <span>选择学校</span>
    </div>
    <div id="choose-a-province">
    </div>
    <div id="choose-a-school">
    </div>
    <div id="choose-box-bottom">
        <input type="botton" onclick="hide()" value="关闭" />
    </div>
  </div>
</div>
  
  <script type="text/javascript">
    //弹出窗口
    function pop(){
        //将窗口居中
        makeCenter();

        //初始化省份列表
        initProvince();

        //默认情况下, 给第一个省份添加choosen样式
        $('[province-id="1"]').addClass('choosen');

        //初始化大学列表
        initSchool(1);
    }
    //隐藏窗口
    function hide()
    {
        $('#choose-box-wrapper').css("display","none");
    }

    function initProvince()
    {
        $('#province').val('北京');
        //原先的省份列表清空
        $('#choose-a-province').html('');
        for(i=0;i<schoolList.length;i++)
        {
            $('#choose-a-province').append('<a class="province-item" province-id="'+schoolList[i].id+'">'+schoolList[i].name+'</a>');
        }
        //添加省份列表项的click事件
        $('.province-item').bind('click', function(){
                var item=$(this);
                var province = item.attr('province-id');
                $('#province').val(item.text());
                var choosenItem = item.parent().find('.choosen');
                if(choosenItem)
                    $(choosenItem).removeClass('choosen');
                item.addClass('choosen');
                //更新大学列表
                initSchool(province);
            }
        );
    }

    function initSchool(provinceID)
    {
        //原先的学校列表清空
        $('#choose-a-school').html('');
        var schools = schoolList[provinceID-1].school;
        for(i=0;i<schools.length;i++)
        {
            $('#choose-a-school').append('<a class="school-item" school-id="'+schools[i].id+'">'+schools[i].name+'</a>');
        }
        //添加大学列表项的click事件
        $('.school-item').bind('click', function(){
                var item=$(this);
                var school = item.attr('school-id');
                //更新选择大学文本框中的值
                $('#school-name').val(item.text());
                //关闭弹窗
                hide();
                $('#school-name').focus();
            }
        );
    }

    function makeCenter()
    {
        $('#choose-box-wrapper').css("display","block");
        $('#choose-box-wrapper').css("position","absolute");
        $('#choose-box-wrapper').css("top", Math.max(0, (($(window).height() - $('#choose-box-wrapper').outerHeight()) / 2) + $(window).scrollTop()) + "px");
        $('#choose-box-wrapper').css("left", Math.max(0, (($(window).width() - $('#choose-box-wrapper').outerWidth()) / 2) + $(window).scrollLeft()) + "px");
    }

  </script>
    
  <style type="text/css">
    #choose-box-wrapper{
        width: 770px;
        background-color:#000;
        filter:alpha(opacity=50);
        background-color: rgba(0, 0, 0, 0.5);
        padding:10px;
        border-radius:5px;
        display:none;
    }
    #choose-box{
        border: 1px solid #005EAC;
        width:750px;
        background-color:white;
    }
    #choose-box-title{
        background:#3777BC;
        color: white;
        padding: 4px 10px 5px;
        font-size: 14px;
        font-weight: 700;
        margin: 0;
    }
    #choose-box-title span{
        font-family: Tahoma, Verdana, STHeiTi, simsun, sans-serif;
    }

    #choose-a-province, #choose-a-school{
        margin:5px 8px 10px 8px;
        border: 1px solid #C3C3C3;
    }
    #choose-a-province a{
        display:inline-block;
        height: 18px;
        line-height: 18px;
        color:#005EAC;
        text-decoration: none;
        font-size: 9pt;
        font-family: Tahoma, Verdana, STHeiTi, simsun, sans-serif;
        margin:2px 5px;
        padding: 1px;
        text-align: center;
    }
    #choose-a-province a:hover{
        text-decoration:underline;
        cursor:pointer;
    }
    #choose-a-province .choosen{
        background-color: #005EAC;
        color:white;
    }
    
    #choose-a-school{
        overflow-x: hidden;
        overflow-y: auto;
        height: 200px;
    }
    #choose-a-school a{
        height: 18px;
        line-height: 18px;
        color:#005EAC;
        text-decoration: none;
        font-size: 9pt;
        font-family: Tahoma, Verdana, STHeiTi, simsun, sans-serif;
        float: left;
        width: 200px;
        margin: 4px 12px;
        padding-left:10px;
        background:url(http://pic002.cnblogs.com/images/2012/70278/2012072500060712.gif) no-repeat 0 9px;
    }
    #choose-a-school a:hover{
        background-color:#005EAC;
        color:white;
        cursor:pointer;
    }
    
    #choose-box-bottom{
        background: #F0F5F8;
        padding: 8px;
        text-align: right;
        border-top: 1px solid #CCC;
        height:40px;
    }
    #choose-box-bottom input{
        vertical-align: middle;
        text-align: center;
        background-color:#005EAC;
        color:white;
        border-top: 1px solid #B8D4E8;
        border-left: 1px solid #B8D4E8;
        border-right: 1px solid #114680;
        border-bottom: 1px solid #114680;
        cursor: pointer;
        width: 60px;
        height: 25px;
        margin-top: 6px;
        margin-right: 6px;
    }
  </style>

<!-- <script type="text/javascript" src="/js/location.min.js"></script> -->
   <!-- <div class="form-group">
            <label for="inputLocation" class="col-sm-3 col-xs-12 control-label">学校地区</label>
            <div class="input-group col-sm-8 col-xs-12">
            <select id="province" name="province" onchange="setCity(this.value);getArea();" style="width: 120px">  
            <option value="">--请选择省份--</option>  
            </select>  

            <select id="city" onchange="setCounty(this.value);getArea();" name="city" style="width: 120px">  
                <option value="" selected="selected">--请选择城市--</option>  
            </select>  

            <select id="county" name="county" style="width: 120px" onchange="getArea();">  
                <option value="" selected="selected">--请选择地区--</option>  
            </select>  
            <input type="hidden" name="area" id="area" value="什么都没有" />  
            <input type="hidden" name="area1" id="area1" value="什么都没有" />  
            <input type="hidden" name="area2" id="area2" value="什么都没有" />  
            </div>
        </div> -->