  <script type='text/javascript' src='/js/demand.js'></script>
  <div class="Leo_question_v2" id="Leo_question_v2">
        <div class="Leo_question_l" id="Leo_question_panel" style="margin-top:30px;"><div></div></div>
        <div id="Leo_control" style="width:600px;height:60px;text-align:center;">
            <table style="width:30%;height:60px;margin:0 auto;">
                <tr style="width:100%;height:100%;">
                    <td style="width:30%;">
                        <img style="height:40px;display:none;" id="Leo_pageup" src="../images/left.png" onclick="Leo_pageup()" />
                    </td>
                    <td style="width:30%;">
                        <img style="height: 40px;" id="Leo_pagedown" src="../images/right.png" onclick="Leo_pagedown()" />
                    </td>
                    <td style="width:30%;">
                        <img style="height: 40px;" id="Leo_signin" src="../images/signin.png" onclick="Leo_checkcomplete()" />
                    </td>
                </tr>
            </table>

        </div>

        
    </div>
    <div class="Leo_question_t_v2" style="height:500px;">

        <table style="width:92%;text-align:center;vertical-align:middle;table-layout:fixed;margin:0 auto;" id="Leo_question_table" cellspacing="0"></table>
    </div>



    <script type="text/javascript">
    var questionlenght=100;
    var Leo_now_index = 0;

    var data={
        'lenght':100,
        'index':12,
        'title':"您认为公司发展最需提升哪些能力(最多选三项):",
        'options':"资源整合能力|融资能力|人力资源管理能力|科研技术能力|科研技术能力|学习能力|工程建设与运营管理能力|内部管理能力|创新能力|风险控制能力",
        'is_multi':true
    }


    Leo_initPanel();
    initTitle(data);

    function initTitle(data){
        var ans=data.options.split('|');
        var q = new Leo_question(data.index, data.title, data.is_multi, ans);
        document.getElementById("Leo_question_panel").removeChild(document.getElementById("Leo_question_panel").childNodes[0]);
        document.getElementById("Leo_question_panel").appendChild(q);
    }
    

    function Leo_initPanel() {
        
        var rows_count = Math.ceil(questionlenght/ 5);
       
            for (var k = 0; k < rows_count; k++) {

                var row_now = document.getElementById("Leo_question_table").insertRow(k);

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

                    for (var i = 0; i < questionlenght- (rows_count - 1) * 5 ; i++) {
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

                    for (var i = questionlenght - (rows_count - 1) * 5; i < 5; i++) {
                        var cell_now = row_now.insertCell(i);

                    }

                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");

                }

            }

    }

/*
    function Leo_checkcomplete() {
        var badques = new Array();
        for (var i = 0; i < questionlength; i++) {
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
*/

function changepage(newpage) {
    //newpage为从0开始的计数方式
    Leo_now_index = newpage;

    if (newpage == 0) {
        $("#Leo_pageup").css('display',"none");
    } else {
        $("#Leo_pageup").css('display',"");
    }

    if (newpage == questions.length - 1) {
       
        ("#Leo_pagedown").css('display',"none");
    } else {
        $("#Leo_pagedown").css('display',"");
    }

    $("#newdiv_" + newpage).focus();


}


</script>