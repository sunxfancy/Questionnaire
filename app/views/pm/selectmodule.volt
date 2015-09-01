<link rel="stylesheet" type="text/css" href="css/progress_styles.css">
<script src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>
<div class="Leo_question" style="overflow:hidden;padding:10px;">
    <div style="width:100%;height:400px;">
        <div style="width:50%;height:400px;background-color:    #C4E1FF;float:left;">
			<div id="leibie" style="width:90%;height:90%;margin-top:5%;font-size:26px;text-align:right;margin-right:10%;float:left;">
                <div style="width:100%;height:50px;cursor:pointer;" id='lingdaoli'>胜任力模块<span style='color:red'>>></span></div>
                <div style="width:100%;height:50px;cursor:pointer;" id='zonghe'>素质测评模块</div>
            </div>
		</div>

        <div style="width:50%;height:400px;background-color:pink;float:left;">
			<div id="xifen" style="width:95%;height:90%;margin-top:5%;margin-left:5%;font-size:20px;float:left;">
                <div id='lingdaoli_sel'>
                    <div style="width:100%;height:50px;"><input value="领导力" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >领导力</span></div>
                    <div style="width:100%;height:50px;"><input value="职业素质" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >职业素质</span></div>
                    <div style="width:100%;height:50px;"><input value="思维能力" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >思维能力</span></div>
                    <div style="width:100%;height:50px;"><input value="态度品质" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >态度品质</span></div>
                    <div style="width:100%;height:50px;"><input value="专业能力" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >专业能力</span></div>
                    <div style="width:100%;height:50px;"><input value="个人特质" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >个人特质</span></div>
                </div>
                <div id='zonghe_sel' style="display:none">
                    <div style="width:100%;height:50px;"><input value="心理健康" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >心理健康</span></div>
                    <div style="width:100%;height:50px;"><input value="素质结构" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >素质结构</span></div>
                    <div style="width:100%;height:50px;"><input value="能力结构" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >能力结构</span></div>
                    <div style="width:100%;height:50px;"><input value="智体结构" type="checkbox" style="width:6%;height:40%" /><span onclick="this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;" style="cursor:pointer;" >智体结构</span></div>
                </div>         
            </div>
		</div>
    </div>

    <div style="width:100%;height:40px;text-align:center;margin:26px;">       
        <button class="btn btn-primary" id='sel_all' >全选</button>        
        <button class="btn btn-primary" id='unsel_all'>全不选</button>
        <button class="btn btn-danger" id="submit">确定</button>          
    </div> 
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">正在存储选择模块...</h4>
            </div>
            <div class="modal-body" style="padding:40px;">
                <div class="progress" style="height:20px;width:90%;margin:auto;">
                    <b class="progress__bar">
                        <span class="progress__text"><em>0%</em></span>
                    </b>
                </div>
            </div>
        <div class="modal-footer">
            <button id="close" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

</div>

<script type="text/javascript">    
    jQuery(function(){
        $.post('/pm/disp_module',  function(data) {
            /*optional stuff to do after success */
            if(data.error){
                alert(data.error);
                return;
            }else{
                var ans=data.select.split("|");
                for (var i = 0; i <ans.length-1; i++) {
                    $("[value="+ans[i]+"]").prop("checked","checked");
                };
            }
        });

        $("#lingdaoli").click(function(){
            $("#lingdaoli").html("胜任力模块<span style='color:red'>>></span>");
            $("#zonghe").html("素质测评模块");
            $("#zonghe_sel").css('display','none');
            $("#lingdaoli_sel").css('display','');
        });
        $("#zonghe").click(function(){
            $("#lingdaoli").html("胜任力模块");
            $("#zonghe").html("素质测评模块<span style='color:red'>>></span>");
            $("#lingdaoli_sel").css('display','none');
            $("#zonghe_sel").css('display','');
        });

        $('#sel_all').click(function(){ $(":checkbox").prop('checked','checked'); console.log($(":checkbox"))});

        $('#unsel_all').click(function(){ $(":checkbox").prop('checked',false);});

        $("#submit").click(function(){
            $('.Leo_question').css('width','843px');
            $('#myModal').modal({backdrop: 'static'});
            var checks=$(":checkbox");
            var checkeds=new Array();
            var values=new Array();
            for(var i=0;i<checks.length;i++){
                checkeds[i]=checks[i].checked;
                values[i]=checks[i].value;
            }          
            $.post('/pm/writeprojectdetail',{'checkeds':checkeds,'values':values}, function(data) {
                 /*optional stuff to do after success */
                if(data.error){
                    alert(data.error);
                    return;
                }else{
                    // alert("提交成功!")
                    $('#close').window.location.href=data.url;
                }
            });
        })
    });

    var $progress = $('.progress'), $bar = $('.progress__bar'), $text = $('.progress__text'), percent = 0, update, resetColors, speed = 400, orange = 30, yellow = 55, green = 85, timer;
    resetColors = function () {
        $bar.removeClass('progress__bar--green').removeClass('progress__bar--yellow').removeClass('progress__bar--orange').removeClass('progress__bar--blue');
        $progress.removeClass('progress--complete');
    };
    update = function () {
        timer = setTimeout(function () {
            percent += Math.random() * 1.5;
            percent = parseFloat(percent.toFixed(1));
            $text.find('em').text(percent + '%');
            if (percent >= 100) {
                percent = 100;
                $progress.addClass('progress--complete');
                $bar.addClass('progress__bar--blue');
                $text.find('em').text('Complete');
            } else {
                if (percent >= green) {
                    $bar.addClass('progress__bar--green');
                } else if (percent >= yellow) {
                    $bar.addClass('progress__bar--yellow');
                } else if (percent >= orange) {
                    $bar.addClass('progress__bar--orange');
                }
                speed = Math.floor(Math.random() * 90);
                update();
            }
            $bar.css({ width: percent + '%' });
        }, speed);
    };
    setTimeout(function () {
        $progress.addClass('progress--active');
        update();
    }, 1000);
</script>

   
