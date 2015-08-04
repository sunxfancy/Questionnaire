<div class="Leo_question" style="overflow:hidden;background-color:white;" >

       <div style="width:100%;height:50px;background-color:blue;">
           
           <table id="labels" style="text-align: center;width:100%; height: 100%;cursor:pointer;background-color:white; " cellspacing="0" cellpadding="0" border="0">
           <tr style="width:100%;height:inherit;margin:0px;">
               <td id="label_detail" style=" width: 20%; height: 100%; background-image: url(../images/label5.png); " onclick="Leo_switch(this)">项目详情</td>
               <td id="label_users" style="width: 20%; height: 100%; background-image: url(../images/label1.png); " onclick="Leo_switch(this)">被试人员</td>
               <td id="label_experts" style="width: 20%; height: 100%; background-image: url(../images/label1.png); " onclick="Leo_switch(this)">面询专家</td>
				<td id="label_leaders" style="width: 20%; height: 100%; background-image: url(../images/label1.png);" onclick="Leo_switch(this)">领导列表</td>
               <td id="label_results" style="width: 20%; height: 100%; background-image: url(../images/label1.png); " onclick="Leo_switch(this)">查看结果</td>

               </tr></table>

       </div>
        
        <div class="Leo_scroll_panel" style="margin:0 auto;top:0px;" id="Leo_manager_home">
           <div style="margin:0 auto;width:100%;height:45px;text-align:center;"><span style="font-size:30px;font-family:'Microsoft YaHei UI'">我的项目详情(p001)</span></div>
            <table style="width:100%;height:220px;margin:0 auto;text-align:center;"><tr style="width:100%;margin:0 auto;"><td style="width:50%;"><img style="height:220px;margin:0 auto;" src="../images/ZhangXiaoyu/people.png" /></td><td><img style="height:220px;" src="../images/ZhangXiaoyu/zhuanjia.png" /></td></tr></table>
            <div style="width:100%;height:100px;">
               <span style="font-size:26px;color:red;"> 项目时间计划</span><br />
                <table style="width: 100%; font-size: 18px;text-align:center;">
                    <tr style="width:100%;height:25px"><td style="width:20%;height:25px">2014-03-14</td><td style="width:20%;height:25px"></td><td style="width:20%;height:25px"></td><td id="now" style="width:20%;height:25px">当前</td><td style="width:20%;height:25px">2014-07-28</td></tr>

                    <tr style="width:100%;height:25px"><td colspan="5" style="text-align:center;vertical-align:middle;">
                        <div style="width:85%;height:20px;margin:0 auto;">
                                 <table cellspacing="0" style="width:100%;height:100%;">
                            <tr><td style="width:74%;height:100%;background-color:gray;"></td><td style="width:26%;height:100%;background-color:green;"></td></tr>

                                 </table>
                        </div></td></tr>
                    <tr style="width:100%;height:25px"><td style="width:20%;height:25px">起始时间</td><td style="width:20%;height:25px"></td><td style="width:20%;height:25px"></td><td style="width:20%;height:25px">当前</td><td style="width:20%;height:25px">截止时间</td></tr>
                    <tr style="width:100%;"><td style="width:100%;" colspan="5" ><input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="fileSelect" style="margin-right:10px;height:30px;color:silver;"><input type="button" value="上传需求量表" onclick="alert('上传成功');" style="margin-right: 10px; height: 30px;" /><input type="button" style="margin-right: 10px; height: 30px;" onclick="window.location.href = 'Leo_setTitle.html'" value="配置测试题目模块" /></td></tr>
                </table>
            </div>

        </div>
</div>