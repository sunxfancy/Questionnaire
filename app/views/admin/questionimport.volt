<h4 class="header blue lighter">
    <ol class="breadcrumb">
      <span class='glyphicon glyphicon-home blue'></span>
	  <li><a href="#" >Home</a></li>
	  <li class="active">题库导入</li>
	</ol>
</h4>

<div class="space-6"></div>

<!-- <div class="dashboard-layout">
	<div class="row">
		<div class="widget-box transparent visible">
			<div class="widget-header widget-header-flat">
				<h4 class="widget-title lighter">
					<i class="ace-icon fa fa-cloud-upload"></i>
					批量导入题目
				</h4>

				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main padding-4" > -->
				
					<form action="/admin/upload" method="post" enctype="multipart/form-data" class="dropzone" id="dropzone">
						<div class="fallback">
							<input name="file" type="file" multiple="" />
						</div>
					</form>
					<!-- <button class="btn btn-primary " onclick="upload();" >上传文件</button> -->
					<a href="/template/questions.xls" class="btn btn-success">模板下载</a>
			<!-- 	</div>
			</div>
		</div>
	</div> -->

	<script type="text/javascript">

		function upload() {
			document.getElementById('dropzone').submit();
		}

		jQuery(function($){
		
		Dropzone.autoDiscover = false;
		try {
		  var myDropzone = new Dropzone("#dropzone" , {
		    paramName: "file", // The name that will be used to transfer the file
		    url: '/admin/upload',
		    maxFilesize: 5, // MB
		    maxFiles: 10,
		    acceptedFiles:'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.xls,.xlsx',
			// acceptedFiles:'application/vnd.openxmlformats.officedocument.spreadsheetml.sheet',
			addRemoveLinks : true,
			dictDefaultMessage :
			'<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Drop files</span> to upload \
			<span class="smaller-80 grey">(or click)</span> <br /> \
			<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>',
			dictResponseError: 'Error while uploading file!',
			
			//change the previewTemplate to use Bootstrap progress bars
			previewTemplate: "<div class='dz-preview dz-file-preview'>\n  <div class='dz-details'>\n    <div class='dz-filename'><span data-dz-name></span></div>\n    <div class='dz-size' data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class='progress progress-small progress-striped active'><div class='progress-bar progress-bar-success' data-dz-uploadprogress></div></div>\n  <div class='dz-success-mark'><span></span></div>\n  <div class='dz-error-mark'><span></span></div>\n  <div class='dz-error-message'><span data-dz-errormessage></span></div>\n</div>"
		  });
		} catch(e) {
		  alert('Dropzone.js does not support older browsers!');
		}
		
		});
	</script>
</div>