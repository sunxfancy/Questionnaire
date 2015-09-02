<!DOCTYPE html>
<html>
<head>
<title>Test</title>
<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/js/jquery.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="progress">
 		 <div id='progress_record'class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" >
  		</div>
	 </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</body>
<script>
$('#myModal').on('shown.bs.modal', function () {
	$.post({
		
		
		
	})
  	setInterval( function(){ i++; if(i<100) {$('#progress_record').css('width',i+'%');} else{return;} }, 60);
  	
})
</script>
</html>