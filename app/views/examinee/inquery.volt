  <script type='text/javascript' src='/js/demand.js'></script>
   <script type='text/javascript' src='/lib/jquery.cookie.js'></script>
  <div class="Leo_question_v2" id="Leo_question_v2">
        <div class="Leo_question_l" id="Leo_question_panel" style="margin-top:30px;"><div></div></div>
        <div id="Leo_control" style="width:600px;height:60px;text-align:center;">
            <table style="width:30%;height:60px;margin:0 auto;">
                <tr style="width:100%;height:100%;">
                    <td style="width:30%;">
                        <img style="height:40px;display:none;" id="Leo_pageup" src="../images/left.png" onclick="Leo_pageup_f()" />
                    </td>
                    <td style="width:30%;">
                        <img style="height: 40px;" id="Leo_pagedown" src="../images/right.png" onclick="Leo_pagedown_f()" />
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


    var questionlength=0;
    var Leo_now_index = 0;

    var data={
        'ques_length':20,
        'index':11,
        'title':"您认为公司发展最需提升哪些能力(最多选三项):",
        'options':"资源整合能力|融资能力|人力资源管理能力|科研技术能力|科研技术能力|学习能力|工程建设与运营管理能力|内部管理能力|创新能力|风险控制能力",
        'is_multi':true
    }

    init();
    function init(){
        Leo_initPanel();
        initTitle(data);
        initCookie(data.ques_length);
    }

    function initCookie(q_length){
        var ans_cookie=$.cookie('ans_cookie'+'{{ number }}'); 



        if(!ans_cookie){
            var ans_array=new Array(q_length);
            for(var i=0;i<q_length;i++){
                ans_array[i]='0';
            }
            $.cookie('ans_cookie'+'{{ number }}',ans_array.join("|"),{experies:7});
        }else{
            var ans_array=ans_cookie.split("|");

            var flag=true;
            for(var i=0;i<ans_array.length;i++){

                if(ans_array[i]=='0'){
                    if(flag){
                        changepage(i,false);
                        flag=false;
                    }
                    
                }else{
                     $("#newdiv_" + i).css('background-color',"green");
                }
            }

            if(flag){
                changepage(ans_array.length-1,false);
            }
        }
    }

    //将cookie中储存的第index个答案更新为new_ans, index 从0开始
    function refreshCookie(index,new_ans){

         var ans_cookie=$.cookie('ans_cookie'+'{{ number }}');
         var ans_array=ans_cookie.split('|');
         ans_array[index]=new_ans;
         ans_str=ans_array.join("|");
         $.cookie('ans_cookie'+'{{ number }}',ans_str,{expires:7});


    }
    //显示题目
    function initTitle(data){
        var ans=data.options.split('|');
        var q = new Leo_question(data.index, data.title, data.is_multi, ans);
        document.getElementById("Leo_question_panel").removeChild(document.getElementById("Leo_question_panel").childNodes[0]);
        document.getElementById("Leo_question_panel").appendChild(q);
        if(questionlength!=data.ques_length){
            questionlength=data.ques_length;
            Leo_initPanel();
        }
        
    }
    

    function Leo_initPanel() {
        var rows_count = Math.ceil(questionlength/ 5);
       
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
                        newdiv.onclick = new Function("changepage(parseInt(this.innerText)-1,true)");
                        
                    }
                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");

                } else {

                    for (var i = 0; i < questionlength- (rows_count - 1) * 5 ; i++) {
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
                        newdiv.onclick = new Function("changepage(parseInt(this.innerText)-1,true)");
                    
                    }

                    for (var i = questionlength - (rows_count - 1) * 5; i < 5; i++) {
                        var cell_now = row_now.insertCell(i);

                    }

                    //newdiv.onclick =new Function( "changepage(parseInt(this.innerText)-1)");

                }

            }

    }

function get_ans_str(index){
    var ans_ori=document.getElementsByName(index);
        var ans_str="";
        for(var i=0;i<ans_ori.length;i++){
            if(ans_ori[i].checked){
                ans_str+=String.fromCharCode(i+97);
            }
        }
        if(ans_str==""){
            ans_str="0";
        }
        return ans_str;
}

function get_ans_array_from_cookie(index){
    var ans_cookie=$.cookie('ans_cookie'+'{{ number }}');
    var ans_array=ans_cookie.split("|");
    var ans_ori=ans_array[index].split("");
    var ans_ori_array=new Array();
    if(ans_ori[0]!="0"){
        for(var i=0;i<ans_ori.length;i++){
            ans_ori_array[i]=ans_ori[i].charCodeAt()-97;
        }
    }
    return ans_ori_array;
}  

function changepage(newpage,isCookie) {
    //newpage为从0开始的计数方式

    var newpagejson={'index':newpage};
    $.post('/Examinee/getques',newpagejson,function(data) {
        /*optional stuff to do after success */
       if(!data.title){
        alert("服务器不理我们了 0_0!");
       }

        

       if(isCookie){
            var now_ans=get_ans_str(Leo_now_index);
            refreshCookie(Leo_now_index,now_ans);
            Leo_now_index = newpage;
            initTitle(data);
            var ans=get_ans_array_from_cookie(newpage);
            var ans_ori=document.getElementsByName(newpage);
            for(var i=0;i<ans.length;i++){
                ans_ori[ans[i]].checked=true;
            }
        }else{
            Leo_now_index = newpage;
            initTitle(data);
        }


        

        if (newpage == 0) {
            $("#Leo_pageup").css('display',"none");
        } else {
            $("#Leo_pageup").css('display',"");
        }

        if (newpage == questionlength - 1) {
           
            $("#Leo_pagedown").css('display',"none");
        } else {
            $("#Leo_pagedown").css('display',"");
        }

        $("#newdiv_" + newpage).focus();


    });

}

    
</script>