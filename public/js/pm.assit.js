//清空文件上传
function clearFileInput(file){ 
    var form=document.createElement('form'); 
    document.body.appendChild(form); 
    //记住file在旧表单中的的位置 
    var pos=file.nextSibling; 
    form.appendChild(file); 
    form.reset(); 
    pos.parentNode.insertBefore(file,pos); 
    document.body.removeChild(form); 
} 
//错误信息显示
function showError(msg){
    $('.Leo_question').css('width','843px')
                 $('.modal-body').html('');
                 $('.modal-body').html(
                     "<p class=\"bg-danger\" style='padding:20px;'>"+msg+"</p>"
                     );
                 $('.modal-footer').html('');
                 $('.modal-footer').html(
                    "<button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">返回修改</button>"
                 );
                 $('#myModal').modal({
                    keyboard:true,
                    backdrop:'static'
                 })
}

function checkFileType(str)
{
     var strRegex = "(.xls|.xlsx)$";
     var re=new RegExp(strRegex);
     if (re.test(str.toLowerCase())){
         return true;
     }
     else{
         return false;
     }
}
