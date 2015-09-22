<script src='/ichart/ichart.latest.min.js'></script>
<div class="Leo_question">
    <div style="margin:0 auto;width:100%;padding:10px 10px 0 10px;text-align:center;">
    	<span style="font-size:30px;font-family:'Microsoft YaHei UI'">{{project_name}}</span>
    </div>
    <hr size="2" color="#FF0000" style="width:90%;"/>
    <div style='text-align:center;'>
        <div id="ichart-render-ceping" style='display:inline-block;'></div>
        <div style='display:inline-block;width:10px;'></div>
        <div id='ichart-render-mianxun' style='display:inline-block;'></div>
    </div>
    <div style="width:100%;padding:10px;">
        <div style="margin-left:30px;padding:10px;font-size:26px;color:red;">项目时间计划</div>       
        <div style="width:90%; margin:0 auto;">
            <table style="width:100%"><tr><td id="begintime" style="width:20%;text-align:left;">{{ begintime }}</td><td id="now" style="width:60%; text-align:center;">{{ now }}</td><td id="endtime" style="width:20%;text-align:right;">{{ endtime }}</td></tr></table>
        </div> 
        <div class="progress" style="width:90%; margin:0 auto;">
            <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:{{ width }};">
            </div>
        </div>
        <div style="width:90%; margin:0 auto;">
            <table style="width:100%"><tr><td style="width:20%;text-align:left;">开始时间</td><td style="width:60%; text-align:center;">现在时间</td><td style="width:20%;text-align:right;">截止时间</td></tr></table>
        </div> 
    </div>
    <div style="width:100%;padding:0 60px;text-align:right; ">
        <div class="form-group">
            <button class="btn btn-primary" onclick='history.go(-1);'>返回首页</button>
        </div>
    </div>
</div>


<script type='text/javascript'>
$(function(){
	var examinee = {{detail}}.examinee_percent;
    var interview = {{detail}}.interview_percent;
            var data_ceping = [
                 {
                  name:"未完成",
                  value:1-examinee,
                  color:"#aa4643"
            },{
                  name:"已完成",
                  value:examinee,
                  color:"#89a54e"
            }
            ];
             var data_mianxun= [
                 {
                  name:"未完成",
                  value:1-interview,
                  color:"#aa4643"
            },{
                  name:"已完成",
                  value:interview,
                  color:"#89a54e"
            }
            ];
            ichartDraw('ichart-render-ceping', data_ceping, '测评完成度');    
            ichartDraw('ichart-render-mianxun', data_mianxun,'面巡完成度');  
            });
function ichartDraw( container, data, title){
	new iChart.Pie2D({
                    render : container,
                    data: data,
                    title : title,
                    legend : {
                        enable : false,
                    },
                    sub_option : {
                        label : {
                            background_color:null,
                            sign:true,//设置禁用label的小图标
                            padding:'0 4',
                            border:{
                                enable:false,
                                color:'#666666'
                            },
                            fontsize:12,
                            fontweight:600,
                            color : '#4572a7'
                        },
                        border : {
                            width : 1,
                            color : '#ffffff'
                        }
                    },
                    animation:true,
                    showpercent:true,
                    decimalsnum:2,
                    radius:50,
                    height:200,
                    width:380,
                }).draw();
	
}        
</script>