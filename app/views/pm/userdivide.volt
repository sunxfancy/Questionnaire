<div class="Leo_question" style="overflow:hidden;">
        <div style="height:5px;"></div>
        <div style="margin:0 auto;text-align:center;">分配人员</div>
        <div style="width:95%;height:3px;background-color:red;margin:0 auto;"></div>
        <div style="width:50%;height:450px;float:left;">
            <ul style="list-style:none;margin-left:150px;" id="examinee_list">

            </ul>

        </div>

        <div style="width:50%;height:300px;float:left;margin-top:100px;">
            <div style="margin:0 auto;text-align:center;">
                <input type="text" style="width:100px;height:30px;" />
                <input type="button" value="添加绿色通道人员" />
                <input type="button" value="删除绿色通道人员" />
            </div>
            <div style="width:100%;height:50px;margin-top:100px;">
                <div style="width: 60%; height: 80%; text-align: center; margin: 0 auto; background-color: green; background-repeat: no-repeat; border-radius: 5px;cursor:pointer;" id="submit">提交</div>

            </div>
        </div>





       <!--<div style="width:500px;height:500px;float:left;">
            <div style="width:500px;height:150px;background-color:white;text-align:center;">
                <div style="margin:0 auto;font-size:18px;height:20px;">可供选择的人员编号为:</div>
                <div id="accessPeo" style="height:75px;overflow:auto;">
                    <table></table>
                </div>
            </div>
            <div style="width:500px;height:250px;background-color:silver;">
                <table style="margin:0 auto;text-align:center;" cellspacing="10">
                    <tr style="height:50px;"><td></td></tr>
                    <tr style="height:30px;"><td><input style="height:30px;" type="text" id="begin" /></td><td>~</td><td><input style="height:30px;" type="text" id="end"/></td></tr>
                    <tr style="height:30px;"><td style="background-color:blue;" onmousedown="this.style.backgroundColor = 'green';" onmouseup="this.style.backgroundColor='blue'" onclick="Leo_clickButton(this);">+</td><td></td><td style="background-color:red;" onmousedown="this.style.backgroundColor = 'green';" onmouseup="this.style.backgroundColor='red'">-</td></tr>
                </table>
            </div>
            <div style="width:500px;height:100px;"><input style="width:100%;height:100%;" value="确认" type="button" onclick="window.location.href='../Leo_Manager.html'"/></div>
        </div>
        <div style="width:360px;height:500px;background-color:silver;float:left;">

            <table style="width:100%;height:100%;text-align:center;" ><tr style="width:100%;height:100%;"><td style="width:100%;height:100%;">
                <textarea id="readyPeo" style="width:300px;height:400px;margin:0 auto;background-color:white;text-align:center;text-align:center" disabled="disabled">已选人员名单</textarea>
                </td></tr></table>

        </div>

        -->
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
                //alert('hello');
                $.post('/examinee/dividepeo/{{manager_id}}','',callbk);

                function callbk(data){
                    //alert(data);
                    data = eval("("+data+")");
                    jsonLength = getJsonLength(data);

                    var count = (jsonLength)%10 == 0 ? (jsonLength+1)/10:Math.ceil((jsonLength+1)/10);

                    for(var i=0;i<count-1;i++){
                        var min_number = data[i*10].number;
                        //alert(min_number);
                        min_number = min_number-min_number%10+1;
                        var max_number = parseInt(min_number)+9;
                        var li_value = min_number+'~'+max_number;
                        var li_dom = $("<li><input type='checkbox' name='items' value="+li_value+"><span>"+li_value+"</span></li>");
                        //alert(li_dom);
                        $('ul').append(li_dom);
                    }
                    var min = data[(count-1)*10].number;
                    var max = data[jsonLength-1].number;
                    var li_value = min + '~' + max;
                    var li_dom = $("<li><input type='checkbox' name='items' value="+li_value+"><span>"+li_value+"</span></li>");
                    $('ul').append(li_dom);
                }

                $('#submit').click(function(){
                            $('input[type=checkbox]:checked').each(function(){
                                var json = {
                                    'divide_examinee' : $(this).val()
                                }
                                $.post('/interviewer/divide/{{manager_id}}',json,function(data){
                                    data = eval("("+data+")");
                                    if(data.status == 'success'){
                                        alert('提交成功!');
                                    }else{
                                        alert('提交失败');
                                    }
                                });
                            });
                        });

                function getJsonLength(jsonData){
                    var jsonLength = 0;
                    for(var item in jsonData){
                        jsonLength++;
                    }
                    return jsonLength;
                }
            })

        var accessPeo = new Array();
        accessPeo.push("0,28");
        accessPeo.push("35,40");
        accessPeo.push("47,47");
        accessPeo.push("60,82");
        initaccessPeo();



        function initaccessPeo() {
            $("accessPeo").removeChild($("accessPeo").childNodes[0]);

            var ntable = document.createElement("table");
            ntable.style.textAlign = "center";
            ntable.style.fontSize = "12px";
            ntable.style.margin = "0 auto";
            $("accessPeo").appendChild(ntable);
            for (var i = 0; i < accessPeo.length; i++) {
                var ntr=ntable.insertRow(i);
                var ntd = ntr.insertCell(0);
                var s = accessPeo[i].split(",");
                ntd.innerText = s[0] + "~" + s[1];
            }
        }

        var readyPeo = new Array();
        readyPeo.push("29,32");

        function initreadyPeo() {
            $("readyPeo").value = "已选人员名单\n";

            for (var i = 0; i < readyPeo.length; i++) {
                var s = readyPeo[i].split(",");
                $("readyPeo").value+=s[0]+"~"+s[1]+"\n";
            }

        }

        initreadyPeo();

        function Leo_clickButton(t) {
            switch(t.innerText){
                case "+": addReady(); break;
                case "-": delReady(); break;
                default: alert("Something was wrong!");
            }
        }
        function addReady(){
            /*if(checkInput(1)){
            var jud1 = parseInt($("begin").innerText);
            var jud2 = parseInt($("end").innerText);
            var ed=Math.max(jud2,parseInt(accessPeo[accessPeo.length-1].split(",")[1]));
            var tem = new Array();

            for (var i = 0; i < ed;i++){

            }
                }*/

            $("readyPeo").value += $("begin").value + "~" + $("end").value + "\n";
        }

        function delReady() {

        }

        function checkInput(n) {
            var jud1 = parseInt($("begin").innerText);
            var jud2 = parseInt($("end").innerText);
            if (isNaN(jud1) || isNaN(jud2) || (jud1 < 0) || jud1 > 999 || jud2 < 0 || jud2 > 999||jud1>jud2) {
                alert("您的输入非法！");
                return false;
            }
            var bo = true;
            if (n) {

                for (var i = jud1; i <= jud2; i++) {
                    bo = judge(i, accessPeo);
                }
            } else {

                for (var i = jud1; i <= jud2; i++) {
                    bo = judge(i, readyPeo);
                }
            }
            return bo;
            function judge(num,x)
            {
                var b = true;
                for (var j = 0; j < x.length; j++) {
                    var s=x[i].split(",")
                    if (num > parseInt(s[0]) && num < parseInt(s[1])) {
                        continue;
                    } else {
                        b = false;
                        break;

                    }
                }
                return b;

            }
        }


    </script>