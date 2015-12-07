<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">提示信息</h4>
        </div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
           <a href='{{ url }}'><button type="button" class="btn btn-danger" >重新登录</button></a>
        </div>
    </div>
  </div>
</div>
<script>
(function(){
	$('.modal-body').html('');
            $('.modal-body').html(
                "<p class=\"bg-danger\" style='padding:20px;'>获取用户信息失败，请重新登录</p>"
            );
    $('#myModal').modal({
                keyboard:true,
                backdrop:'static'
            })
})();
</script>