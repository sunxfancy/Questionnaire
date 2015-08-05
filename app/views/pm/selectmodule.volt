<div class="Leo_question" style="overflow:hidden;padding:10px;">
    <div style="width:100%;height:400px;">
        <div style="width:50%;height:400px;background-color:    #C4E1FF;float:left;">
			<div id="leibie" style="width:90%;height:90%;margin-top:5%;font-size:26px;text-align:right;margin-right:10%;float:left;"></div>
		</div>

        <div style="width:50%;height:400px;background-color:pink;float:left;">
			<div id="xifen" style="width:95%;height:90%;margin-top:5%;margin-left:5%;font-size:20px;float:left;"></div>
		</div>
    </div>

    <div style="width:100%;height:40px;text-align:center;margin:26px;">             
        <button class="btn btn-primary" onclick="Leo_selectAll()" >全选</button>        
        <button class="btn btn-primary" onclick="Leo_unselectAll()">全不选</button>
        <button class="btn btn-primary" type="submit" onclick="window.location.href='/pm/index'">确定</button>
    </div>
</div>

<script type="text/javascript">
    
    function leibie(Num,Name,xifen) {
        var div=document.createElement("div");
        div.id = "leibie_" + Num;
        div.style.width = "100%";
        div.style.height = "50px";
        div.style.cursor = "pointer";
        div.innerText = Name;
        div.onclick = new Function("Leo_mouseclick(this)");

        div.xifen_div = document.createElement("div");
        for (var i = 0; i < xifen.length; i++) {
            mk_div = document.createElement("div");
            var mk_checkbox = document.createElement("input");
            var mk_span = document.createElement("span");
            mk_checkbox.type = "checkbox";
			mk_div.appendChild(mk_checkbox);
            mk_span.innerText = xifen[i];
			mk_checkbox.style.width="6%";
			mk_checkbox.style.height="40%";
			mk_checkbox.name = div.id;
            mk_div.appendChild(mk_span);
            mk_span.onclick = new Function("this.parentNode.childNodes[0].checked=!this.parentNode.childNodes[0].checked;");
            mk_div.style.cursor = "pointer";
            mk_div.style.width = "100%";
            mk_div.style.height = "50px";
			
            div.xifen_div.appendChild(mk_div);
        }
	     return div;
    }

    var leibie_name = new Array();
    var leibie_xifen = new Array();
    
    leibie_name.push("领导力模块");
    var leibie_xifen_lidaoli = new Array();
   
    leibie_xifen_lidaoli.push("领导能力");
    leibie_xifen_lidaoli.push("职业素质");
    leibie_xifen_lidaoli.push("思维能力");
    leibie_xifen_lidaoli.push("态度品质");
    leibie_xifen_lidaoli.push("专业能力");
    leibie_xifen_lidaoli.push("个人特质");
    leibie_xifen.push(leibie_xifen_lidaoli);
   
    var newdiv = new leibie(1, leibie_name[0], leibie_xifen[0]);
	//newdiv.style.backgroundColor="pink";
    document.getElementById('leibie').appendChild(newdiv);
    document.getElementById('xifen').appendChild(newdiv.xifen_div);
   
    leibie_name.push("综合素质模块");
    var leibie_xifen_lidaoli = new Array();

    leibie_xifen_lidaoli.push("心理健康");
    leibie_xifen_lidaoli.push("素质结构");
    leibie_xifen_lidaoli.push("能力结构");
    leibie_xifen_lidaoli.push("智体结构");
    leibie_xifen.push(leibie_xifen_lidaoli);

    var newdiv = new leibie(2, leibie_name[1], leibie_xifen[1]);
    document.getElementById('leibie').appendChild(newdiv);
   
    function Leo_mouseclick(t) {
        document.getElementById('xifen').removeChild(document.getElementById('xifen').childNodes[0]);
        document.getElementById('xifen').appendChild(t.xifen_div);
		/*var length=document.getElementById('leibie').childNodes.length;
		for(var i=0;i<length;i++){
			document.getElementById('leibie').childNodes[i].style.backgroundColor="white";
		}*/
		//t.style.backgroundColor="pink";
    }
    function Leo_selectAll() {
        var length=document.getElementById('leibie').childNodes.length;
        for (var i = 0; i < length; i++) {
            for (var j = 0; j < document.getElementById('leibie').childNodes[i].xifen_div.childNodes.length; j++) {
                document.getElementById('leibie').childNodes[i].xifen_div.childNodes[j].childNodes[0].checked = true;
            }     
        }
    }
    function Leo_unselectAll() {
        var length = document.getElementById('leibie').childNodes.length;
        for (var i = 0; i < length; i++) {
            for (var j = 0; j < document.getElementById('leibie').childNodes[i].xifen_div.childNodes.length; j++) {
                document.getElementById('leibie').childNodes[i].xifen_div.childNodes[j].childNodes[0].checked = false;
            }
        }
    }
</script>