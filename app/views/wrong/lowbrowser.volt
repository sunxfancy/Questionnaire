<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">提示信息</h4>
        </div>
        <div class="modal-body">
            
        </div>
    </div>
  </div>
</div>
<script>
(function(){
	$('.modal-body').html('');
            $('.modal-body').html(
                "<p class=\"bg-danger\" style='padding:20px;font-size:15px;'>您的浏览器版本过低，不支持该软件！<br /><br />您可以使用<b>360安全浏览器</b>在极速模式下（或者<b>谷歌浏览器</b>、<b>火狐浏览器</b>、<b>QQ浏览器</b>等等）打开本网站<br /><br />此处提供<a href='/360se8.0.1.256.exe'>360安全浏览器8.0版</a>下载</p>"
            );
    $('#myModal').modal({
                keyboard:true,
                backdrop:'static'
            })
})();
</script>