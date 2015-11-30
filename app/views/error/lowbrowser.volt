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
         
        </div>
    </div>
  </div>
</div>
<script>
(function(){
	$('.modal-body').html('');
            $('.modal-body').html(
                "<p class=\"bg-danger\" style='padding:20px;'>您的浏览器版本过低，不支持该软件！</p>"
            );
    $('#myModal').modal({
                keyboard:true,
                backdrop:'static',
            })
})();
</script>