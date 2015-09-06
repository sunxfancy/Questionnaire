<div class="Leo_question" style="overflow:hidden;">
    <div style="width:49.5%;height:90%;float:left;">
        <div style="padding:10px;text-align:center;font-size:26px;">已完成名单</div>
        <div style="width:95%;height:3px;background-color:red;margin:0 auto;"></div>
        <div style="overflow:auto;">
            <ul style="list-style:none;margin-left:150px;" id="com_list"></ul>
        </div>
    </div>

    <div style="width:49.5%;height:90%;float:right;">
        <div style="padding:10px;text-align:center;font-size:26px;">未完成名单</div>
        <div style="width:95%;height:3px;background-color:red;margin:0 auto;"></div>
        <div style="overflow:auto;">
            <ul style="list-style:none;margin-left:150px;" id="not_list"></ul>
        </div>
    </div>

    <div style="padding:10px;text-align:right;">
        <a class="btn btn-primary" href="/pm">返回</a>
    </div>
</div>

<script type="text/javascript">
    data = {{ data }};
    var length = data.length;
    if ((data.interview_com == undefined || data.interview_com == null) && (data.interview_not == undefined || data.interview_not == null)) {
        var li_dom = $("<li style='padding:3px;font-size:18px;'><span>"+"还未进行过分配！！"+"</span></li>");
        $('#not_list').append(li_dom);
    }else{
        if (data.interview_com == undefined || data.interview_com == null) {
            var li_dom = $("<li style='padding:3px;font-size:18px;'><span>"+"还没有人完成面询！"+"</span></li>");
            $('#com_list').append(li_dom);
        }else{
            for (var i = 0; i < data.interview_com.number.length; i++) {
                var li_dom = $("<li style='padding:3px;font-size:18px;'><span>"+data.interview_com.number[i]+'：'+data.interview_com.name[i]+"</span></li>");
                $('#com_list').append(li_dom);       
            }
        }
        if (data.interview_not == undefined || data.interview_not == null) {
            var li_dom = $("<li style='padding:3px;font-size:18px;'><span>"+"全部人员完成面询！"+"</span></li>");
            $('#not_list').append(li_dom); 
        }else{
            for (var i = 0; i < data.interview_not.number.length; i++) {
                var li_dom = $("<li style='padding:3px;font-size:18px;'><span>"+data.interview_not.number[i]+'：'+data.interview_not.name[i]+"</span></li>");
                $('#not_list').append(li_dom);       
            }
        }
    }
</script>