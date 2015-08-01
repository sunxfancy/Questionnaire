 <div style="width:auto;height:100px;font-size:80px;color:white;margin-left:40px;margin-top:50px;font-family:'华文行楷';">
    <table cellspacing="0"  style="width:100%;height:100%;vertical-align:middle;">
        <tr style="width:100%;height:100%;">
            <td style="width:100%;height:100%;">政府部门测评系统</td>
        </tr>
    </table>
</div>

<div class="Leo_login">
 <div style="height:10px;"></div>
 <table>
     <tr style="height:100px;"><td style="width:500px;font-size:40px;color:purple;">欢 迎 登 录</td></tr>
       </table>
            <form action="/managerlogin/login" method="POST">
            <table>
                <tr>
                    <td style="width:100px; font-family:'Microsoft YaHei' ">帐号</td>
                    <td>
                        <input onfocus="this.style.backgroundColor = 'white';" onblur="    this.style.backgroundColor='#F3F3F3';" dir="ltr" type="text" id="username" name="username" style=" font-size:20px; height: 36px;line-height: 36px;outline: none;font-size: 20px;width: 180px;border: 1px solid #C7C7C7;background: #F3F3F3;border-radius: 2px;padding: 0 5px;font-family:'Microsoft YaHei UI'">
                    </td>
                </tr>

                <tr>
                    <td style="width: 100px; font-family: 'Microsoft YaHei' ">密码</td><td>
                    <input onfocus="getfocus(this);" onblur="getblur(this);" type="text" dir="ltr" id="password" name="password" style="font-size:20px; height: 36px;line-height: 36px;outline: none;font-size: 20px;width: 180px;border: 1px solid #C7C7C7;background: #F3F3F3;border-radius: 2px;padding: 0 5px;font-family:'Microsoft YaHei';color:silver;">
                    </td>
                </tr>
            </table>

            <div style="height:20px;"></div>
            <table style="width:90%;margin:0 auto;">
                 <tr>
                   <td style="width:100%;text-align:center;">
                     <div onmousedown="    this.style.backgroundColor = '#e56419'" onmouseup="    this.style.backgroundColor = '#d49a3e'" style="width:100%;height:40px;background-color:#d49a3e;font-family:'Microsoft YaHei';font-size:21px;text-align:center;cursor:pointer;"  >
                         <table style="width:100%;height:100%" cellspacing="0">
                            <tr style="width:100%;height:100%;">
                                  <td style="width:100%;height:100%;vertical-align:middle"><input style='width:100%;height:100%;background-color:' type='submit' value='登录'/></td>
                             </tr>
                        </table>
                     </div>
                 </td>
            </tr>
            </table>
            </form>
                
</div>

function getfocus(t) {
        t.style.backgroundColor = 'white';
        t.value = "";
        t.type = "password";
        t.style.color = "black";
    }

    function getblur(t) {
        t.style.backgroundColor = '#F3F3F3';
        if (t.value == "") {
            t.type = "text";
            t.style.color = "silver";
            t.value="初始密码为123456"
        }
    }