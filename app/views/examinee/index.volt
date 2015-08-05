<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title>测评系统</title>
    <link rel="stylesheet" type="text/css" href="/css/css/Leo_global_css.css" />
    <link rel="stylesheet" type="text/css" href="/css/css/Leo_normal_css.css" />
    <script src="/js/Leo_global_script.js" type="text/javascript"></script>
    <script src="/js/demand.js" type="text/javascript"></script>
    <script src="/js/excel_model1.js" type="text/javascript"></script>


</head>

<body>
    <div class="Leo_title">

        <div class="Leo_title_l" >需求调查问卷系统</div>
        <div style="width:100%;height:2px;background-color:white;"></div>
    </div>

    <div class="Leo_info">
        <div style="width:100%;height:50px;"></div>
        <div class="Leo_info_user">
            <img src="/images/user2.png" />

        </div>
        <div class="Leo_info_l">
            <table cellspacing="0">
                <tr><td>姓名</td><td style="text-align:left;">{{user['name']}}</td></tr>
                <tr><td>编号</td><td style="text-align:left;">{{paper[0].id}}</td></tr>
                <tr><td>角色</td><td style="text-align:left;">被试人员</td></tr>
                

            </table>
        </div>
        
    </div>

    <div class="Leo_question_v2" id="Leo_question_v2">
        
        <div class="Leo_question_l" id="Leo_question_panel" style="margin-top:30px;"></div>
        <div id="Leo_control" style="width:600px;height:60px;text-align:center;">
            <table style="width:30%;height:60px;margin:0 auto;">
                <tr style="width:100%;height:100%;">
                    <td style="width:30%;">
                        <img style="height:40px;display:none;" id="Leo_pageup" src="/images/left.png" onclick="Leo_pageup()" />
                    </td>
                    <td style="width:30%;">
                        <img style="height: 40px;" id="Leo_pagedown" src="/images/right.png" onclick="Leo_pagedown()" />
                    </td>
                    <td style="width:30%;">
                        <img style="height: 40px;" id="Leo_signin" src="/images/signin.png" onclick="Leo_checkcomplete()" />
                    </td>
                </tr>
            </table>

        </div>

        
    </div>
    <div class="Leo_question_t_v2" style="height:500px;">

        <table style="width:92%;text-align:center;vertical-align:middle;table-layout:fixed;margin:0 auto;" id="Leo_question_table" cellspacing="0"></table>
    </div>
   <!-- <div class="Leo_Timer_v2">
        <table style="width:145px;height:120px;text-align:center;vertical-align:middle;margin:0 auto;table-layout:fixed;" cellspacing="0">
            <tr style="width:245px;height:50px;"><td colspan="5">已用时</td></tr>
            <tr><td id="hour">00</td><td>:</td><td id="minute">00</td><td>:</td><td id="second">00</td></tr>
        </table>
    </div>
    <div class="Leo_question" style="overflow:hidden;">
        <table style="height:100%;width:100%;border:0px;table-layout:fixed;" cellspacing="0">
            <tr style="width:100%;">
                <td style="width:70%;height:100%;">

                    <table style="width:100%;height:100%;border:0px;" cellspacing="0">
                    <tr style="height:85%;"><td>
                        <div style="width:100%;height:30px;background-color:#eeed6a;text-align:center;font-size:20px;font-family:'Microsoft YaHei';" ><table style="width:100%;height:100%;text-align:center;vertical-align:middle;"><tr style="width:100%;height:100%;"><td style="width:100%;height:100%;" id="classInfo"></td></tr></table></div>
                        <div style="width:100%;height:7%;"></div>
                         <div class="Leo_question_l" id="Leo_question_panel"></div>
                        </td></tr>
                    <tr style="height:1%;"><td style="background-color: #b9e5d6;"></td></tr>
                    <tr style="height:15%"><td>
                            <div id="Leo_control" style="width:100%;height:100%;text-align:center;margin-top:15px;">
                                <img style="height:70px;" src="images/left.png" onclick="Leo_pageup()"/>
                                <img style="height: 70px; display: none;" id="Leo_pagedown" src="images/signin.png" onclick="Leo_pagedown()" />

                            </div>
                        </td></tr>
                    </table>

                </td>
                <td style="width: 0.5%; height: 100%; background-color: #b9e5d6;" ></td>
                <td style="width:29.5%;height:100%;" >
                   <table style="width:100%;height:100%;border:0px;table-layout:fixed;margin:0 auto;" cellspacing="0">
                        <tr style="height:200px;width:100%;">
                             <td style="overflow:auto;white-space:nowrap;">
                               <div id="Leo_question_t" class="Leo_question_t" ><table style="width:92%;text-align:center;vertical-align:middle;table-layout:fixed;" id="Leo_question_table" cellspacing="0"></table></div>
                            </td>
                        </tr>
                        <tr style="height:1%;"><td style="background-color: #b9e5d6;"></td></tr>
                        <tr style="height:25%;width:100%">
                            <td style="width:100%;">
                                <div id="Leo_timer" style="width:100%;height:20px;text-align:center;">
                                    <table style="width:100%;height:100%;border:1px solid black;" cellspacing="0">
                                        <tr style="width:100%;height:100%;"><td rowspan="2"></td><td colspan="6">已用时</td></tr>
                                        <tr style="width:100%;height:100%;"><td></td><td>时</td><td></td><td>分</td><td></td><td>秒</td></tr>
                                    </table>

                                </div>

                            </td>
                        </tr>
                    </table>

                </td>
            </tr>



        </table>
        <div id="Leo_hiden" class="Leo_hiden" style="top:-500px;display:none;" onclick="Leo_doques()"><table style="height:100%;width:100%;text-align:center;vertical-align:middle;"><tr><td id="Leo_hiden_td"><br /></td></tr></table></div>


    </div>-->
    <footer>
        <div class="Leo_foot">
            Leonardo&S
        </div>

    </footer>
</body>

</html>

<script type="text/javascript">
    var url = "inquery.xlsx";
    url = ABSurl(url);

    var Leo_now_index = 0;


    var questions = new Array();
    var Leo_title = new Array();
    var Leo_ans = new Array();
    var Leo_type = new Array();

    initTitles(url,1,-1);
    function initTitles(url, start, length) {
        var tem = new Array();
        tem=excel_excute(url,false);
        var count=tem[0].WorkSheets(1).UsedRange.Cells.Rows.Count;
        if (length != -1) {
            if (length > count - 1) {
                alert("Something was wrong! Error Code=ox001F");
            } else {
                count = start + length - 1;
            }
        }
        for (var i = start+1; i <= count; i++) {
            Leo_title.push(tem[1].Cells(i, 2).value);
            
            switch (tem[1].Cells(i, 3).value) {
                case "是":
                    Leo_type.push(true);
                    break;
                case "否":
                    Leo_type.push(false);
                    break;
                default: alert("Something was wrong!Error Code=0x001E");
            }
            

            var ans = new Array();
            for (var j = 4; 1; j++) {
                
                
                if (!tem[1].Cells(i, j).value) {
                    break;
                } else {
                    ans.push(tem[1].Cells(i,j).value);
                }
            }
            Leo_ans.push(ans);
        }


        tem[0].Close(savechanges = false);
        
    }




    /*
    Leo_title.push("您认为中青年骨干应继续提升哪些方面的职业能力(最多选三项):");
    var ans = new Array();
  

    ans.push("战略规划能力");
    ans.push("团队领导能力");
    ans.push("决策能力");
    ans.push("独立工作能力");
    ans.push("创新能力");
  ans.push("应变能力");
    ans.push("自控能力");
    ans.push("学习能力");
    ans.push("影响力");
    ans.push("执行力");
  ans.push("组织管理能力");
    ans.push("社交能力");

    Leo_ans.push(ans);
    Leo_type.push(false);

    Leo_title.push("您认为中青年骨干应继续提升哪些方面的职业素质(最多选三项):");
                                                                       

    var ans = new Array();
    ans.push("责任心");
    ans.push("诚信正直");
    ans.push("团队精神");
    ans.push("工作态度");
    ans.push("坚持不懈");
  ans.push("善于自律");
    ans.push("宽容大度");
    ans.push("价值观");
    ans.push("人际关系协调");
    
    Leo_ans.push(ans);
    Leo_type.push(false);

    Leo_title.push("您目前最需要的是(最多选三项)");
    var ans = new Array();
  

    ans.push("接受培训");
    ans.push("增加收入");
    ans.push("改善福利和社会保障");
    ans.push("提升职务");
    ans.push("晋升职称");
  ans.push("调整岗位");
    ans.push("调换单位");
    ans.push("改善人际关系");
    ans.push("改善身体状况");
    ans.push("职业生涯设计");
  
    Leo_ans.push(ans);
    Leo_type.push(false);


    Leo_title.push("您目前最希望学习的内容(最多选三项):");
    var ans = new Array();
  

    ans.push("管理");
    ans.push("外语");
    ans.push("沟通技巧");
    ans.push("获得更高学位");
    ans.push("专业知识");
    ans.push("计算机");
    ans.push("财务");
   ans.push("战略");
   
    Leo_ans.push(ans);
    Leo_type.push(false);

    Leo_title.push("您计划在接下一年里继续提升哪些方面的能力(最多选三项):");
    var ans = new Array();
  

    ans.push("战略规划能力");
    ans.push("团队领导能力");
    ans.push("决策能力");
    ans.push("责任心");
    ans.push("创新能力");
    ans.push("应变能力");
    ans.push("自控能力");
    ans.push("学习能力");
    ans.push("敬业精神");
    ans.push("坚持不懈");
    
    Leo_ans.push(ans);
    Leo_type.push(false);

    Leo_title.push("您认为您胜任现岗位的优势是(最多选三项):");
    var ans = new Array();

     ans.push("年龄");
    ans.push("性别");
    ans.push("工作经验");
    ans.push("人际关系");
    ans.push("所学专业");
    ans.push("兴趣爱好");
    ans.push("工作年限");
    ans.push("创新力");
    ans.push("沟通能力");
    ans.push("领导能力");
   ans.push("抗压能力");
    ans.push("思考能力");
    ans.push("亲和力");
    ans.push("组织管理能力");
    ans.push("其他");
   
    Leo_ans.push(ans);
    Leo_type.push(false);

    Leo_title.push("集团应该在如下哪些方面加以增强，以留住优秀人才(最多选三项):");
    var ans = new Array();
  

    ans.push("公开公平选拔人才");
    ans.push("创造良好的工作环境");
    ans.push("进行职业生涯规划");
    ans.push("知人善任用人所长");
    ans.push("提供挑战性高的工作");
    ans.push("提供个性化的培训");
    Leo_ans.push(ans);
    Leo_type.push(false);

    
    Leo_title.push("您期望通过参加培训获得什么(最多选三项):");
    var ans = new Array();
    ans.push("提升工作能力");
    ans.push("拓宽眼界思路");
    ans.push("增强党性修养");
    ans.push("相互借鉴交流");
    ans.push("补充更新知识");
    ans.push("统一思想认识");
    
    Leo_ans.push(ans);
    Leo_type.push(false);


   Leo_title.push("您认为公司人力资源建设中最急需的是(最多选三项):");
    var ans = new Array();

  
    ans.push("优化员工专业结构，大幅度提升专业技术人才的比例");
    ans.push("引进市场化的高级管理人员");
    ans.push("优化员工年龄结构");
    ans.push("加大教育培训力度");
    ans.push("提高员工学历和职称层次");
    ans.push("提高绩效管理与考核的科学性");
  ans.push("优化薪酬结构和比例");
    ans.push("完善人力资源管理信息系统的建设");
    ans.push("加强人力资源规划力度");
    
    
    Leo_ans.push(ans);
    Leo_type.push(false);


  Leo_title.push("您认为您胜任现岗位的优势是(最多选三项):");
    var ans = new Array();

    ans.push("工作经验");
    ans.push("团队领导能力");
    ans.push("决策能力");
    ans.push("责任心");
    ans.push("创新能力");
    ans.push("应变能力");
  ans.push("自控能力");
    ans.push("学习能力");
    ans.push("敬业精神");
    ans.push("坚持不懈");
    ans.push("战略规划能力");
    
    
    Leo_ans.push(ans);
    Leo_type.push(false);

  Leo_title.push("您参加公司培训的目的是什么(最多选三项):");
    var ans = new Array();


    ans.push("提升工作技能");
    ans.push("改善工作方法");
    ans.push("转变工作态度");
    ans.push("拓展思维");
    ans.push("更新知识");
    ans.push("其他");
  
    
    
    Leo_ans.push(ans);
    Leo_type.push(false);

  Leo_title.push("您认为公司发展最需提升哪些能力(最多选三项):");
    var ans = new Array();


    ans.push("土地资源获取能力");
    ans.push("融资能力");
    ans.push("品牌发展能力");
    ans.push("人力资源管理能力");
    ans.push("项目策划能力");
    ans.push("设计管理能力");
  ans.push("项目管理能力");
    ans.push("营销管理能力");
    ans.push("领导决策能力");
    ans.push("人际交往能力");
    ans.push("文字或语言表达能力");
   ans.push("抗压能力");
    ans.push("学习能力");
     ans.push("创新能力");
      ans.push("其他");
    
    
    Leo_ans.push(ans);
    Leo_type.push(false);


Leo_title.push("您认为公司发展最需提升哪些能力(最多选三项):");
    var ans = new Array();

    ans.push("市场开拓能力");
    ans.push("资源整合能力");
    ans.push("融资能力");
    ans.push("人力资源管理能力");
    ans.push("科研技术能力");
    ans.push("学习能力");
  ans.push("工程建设与运营管理能力");
    ans.push("内部管理能力");
    ans.push("创新能力");
    ans.push("风险控制能力");
    ans.push("政府公关能力");
   ans.push("抗压能力");
   
    
    Leo_ans.push(ans);
    Leo_type.push(false);


    */

    for (var i = 0; i < Leo_title.length; i++) {
        var q = new Leo_question(i, Leo_title[i], Leo_type[i], Leo_ans[i]);
        questions.push(q);
    }


   


   
    

    Leo_initPanel();


    function Leo_initPanel() {
        
        var rows_count = Math.ceil( questions.length/ 5);
       
            for (var k = 0; k < rows_count; k++) {

                var row_now = $("Leo_question_table").insertRow( k);

                if (k < rows_count - 1) {

                    for (var i = 0; i < 5; i++) {
                        var cell_now = row_now.insertCell(i);

                        var newdiv = document.createElement("div");
                        newdiv.style.float = "left";


                        newdiv.style.margin = "5px";
                        newdiv.style.width = "40px";
                        newdiv.style.height = "40px";
                        newdiv.id = "newdiv_" + (5 * k + i);
                        newdiv.style.textAlign = "center";
                        newdiv.style.cursor = "pointer";
                        newdiv.style.backgroundColor = "gray";
                        newdiv.innerText = ( 5 * k + i) + 1 + "";
                        newdiv.style.fontSize = "21px";
                        newdiv.tabIndex = "0";
                        cell_now.appendChild(newdiv);
                        
                            newdiv.onclick = new Function("changepage(parseInt(this.innerText)-1)");
                        
                    }
                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");

                } else {

                    for (var i = 0; i < questions.length- (rows_count - 1) * 5 ; i++) {
                        var cell_now = row_now.insertCell(i);

                        var newdiv = document.createElement("div");
                        newdiv.style.float = "left";

                        newdiv.style.margin = "5px";
                        newdiv.style.width = "40px";
                        newdiv.style.height = "40px";
                        newdiv.id = "newdiv_" + ( 5 * k + i);
                        newdiv.style.textAlign = "center";
                        newdiv.style.cursor = "pointer";
                        newdiv.style.backgroundColor = "gray";
                        newdiv.innerText = ( 5 * k + i) + 1 + "";
                        newdiv.style.fontSize = "21px";
                        newdiv.tabIndex = "0";
                        cell_now.appendChild(newdiv);
                       
                            newdiv.onclick = new Function("changepage(parseInt(this.innerText)-1)");
                    
                    }

                    for (var i = questions.length - (rows_count - 1) * 5; i < 5; i++) {
                        var cell_now = row_now.insertCell(i);

                    }

                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");

                }

            }
          

      

        
       

        $("Leo_question_panel").appendChild(questions[Leo_now_index]);

    }


    function Leo_checkcomplete() {
        var badques = new Array();
        for (var i = 0; i < questions.length; i++) {
            if ($("newdiv_" + i).style.backgroundColor == "gray") {
                badques.push((i + 1));
            }
        }
        if (badques.length != 0) {
            alert("您的答题是不完整的，其中第" + badques + "题缺少必要的答案！请继续答题！");

            changepage(badques[0] - 1);
        } else {
            var t = confirm("您确定要提交吗？");
            if (t) {
                
                alert("感谢您的配合，我们将在答案提交完毕后，进入问卷调查");
                window.location.href = "testinfo.html";
            }
        }
    }




</script>