<div class="Leo_question" style="overflow:hidden;padding:10px;">
    <div style="width:100%;height:400px;">
        <div style="width:50%;height:400px;background-color:    #C4E1FF;float:left;">
			<div id="leibie" style="width:90%;height:90%;margin-top:5%;font-size:26px;text-align:right;margin-right:10%;float:left;">
                <div style="width:100%;height:50px;cursor:pointer;" id='lingdaoli'>领导力模块<span style='color:red'>-></span></div>
                <div style="width:100%;height:50px;cursor:pointer;" id='zonghe'>综合素质模块</div>
            </div>
		</div>

        <div style="width:50%;height:400px;background-color:pink;float:left;">
			<div id="xifen" style="width:95%;height:90%;margin-top:5%;margin-left:5%;font-size:20px;float:left;">
                <div id='lingdaoli_sel'>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >领导能力</span></div>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >职业素质</span></div>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >思维能力</span></div>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >态度品质</span></div>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >专业能力</span></div>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >个人特质</span></div>
                </div>
                <div id='zonghe_sel' style="display:none">
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >心理健康</span></div>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >素质结构</span></div>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >能力结构</span></div>
                    <div style="width:100%;height:50px;"><input name="aaa" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >智体结构</span></div>
                </div>         
            </div>
		</div>
    </div>

    <div style="width:100%;height:40px;text-align:center;margin:26px;">             
        <button class="btn btn-primary" id='sel_all' >全选</button>        
        <button class="btn btn-primary" id='unsel_all'>全不选</button>
        <button class="btn btn-primary" type="submit">确定</button>
    </div>
</div>

<script type="text/javascript">
    
    jQuery(function(){
        

        $("#lingdaoli").click(function(){
            $("#lingdaoli").html("领导力模块<span style='color:red'>-></span>");
            $("#zonghe").html("综合素质模块");
            $("#zonghe_sel").css('display','none');
            $("#lingdaoli_sel").css('display','');
        });
        $("#zonghe").click(function(){
            $("#lingdaoli").html("领导力模块");
            $("#zonghe").html("综合素质模块<span style='color:red'>-></span>");
            $("#lingdaoli_sel").css('display','none');
            $("#zonghe_sel").css('display','');
        });

        $('#sel_all').click(function(){ $(":checkbox").prop('checked','checked'); console.log($(":checkbox"))});

        $('#unsel_all').click(function(){ $(":checkbox").prop('checked',false);});


       

    })
</script>

   
