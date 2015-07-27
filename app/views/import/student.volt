<h1>学生信息上传</h1>
<form action="/import/uploadstudent" method="post" enctype="multipart/form-data" class="dropzone" id="dropzone">
	<div class="fallback">
		<input name="file" type="file" multiple="" />
	</div>
</form>

<script type="text/javascript">

	function upload() {
		document.getElementById('dropzone').submit();
	}

	jQuery(function($){
	
	Dropzone.autoDiscover = false;
	try {
	  var myDropzone = new Dropzone("#dropzone" , {
	    paramName: "file", // The name that will be used to transfer the file
	    url: '/import/uploadstudent',
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
