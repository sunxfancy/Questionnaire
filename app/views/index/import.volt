
<h4 class="header blue lighter">
    <ol class="breadcrumb">
        <span class='glyphicon glyphicon-upload text-primary'></span>
        <li><a href="#">编辑</a></li>
        <li class="active">导入学生信息</li>
    </ol>
</h4>

<div class="space-6"></div>

<form action="/index/upload" method="post" enctype="multipart/form-data" class="dropzone" id="dropzone">
    <div class="fallback">
        <input name="file" type="file" multiple=""/>
    </div>
</form>
<a href="/template/students.xls" class="btn btn-success">模板下载</a>


<script type="text/javascript">

    function upload() {
        document.getElementById('dropzone').submit();
    }

    jQuery(function ($) {

        Dropzone.autoDiscover = false;
        try {
            var myDropzone = new Dropzone("#dropzone", {
                paramName: "file", // The name that will be used to transfer the file
                url: '/index/upload/{{ test_id }}',
                maxFilesize: 5, // MB
                acceptedFiles:'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.xls,.xlsx',
                addRemoveLinks: true,
                dictDefaultMessage: '<span class="h1"><span class="glyphicon glyphicon-share-alt"></span> Drop files</span><span class="h4"> to upload \
                        (or click)</span> <br /> \
                       <span class="text-primary" style="margin-top: 10px;font-size: 100px"> <span class="glyphicon glyphicon-cloud"></span></span>',
                dictResponseError: 'Error while uploading file!',

                //change the previewTemplate to use Bootstrap progress bars
                previewTemplate: "<div class='dz-preview dz-file-preview'>\n  <div class='dz-details'>\n    <div class='dz-filename'><span data-dz-name></span></div>\n    <div class='dz-size' data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class='progress progress-small progress-striped active'><div class='progress-bar progress-bar-success' data-dz-uploadprogress></div></div>\n  <div class='glyphicon glyphicon-ok text-success' style='position: absolute;right: -10px; top: -10px;width: 40px;height: 40px;font-size: 30px;opacity: 1;background-color: rgba(255,255,255,0.8);border-radius: 100%;text-align: center;line-height: 35px;'><span></span></div>\n  <div class='dz-error-mark'><span></span></div>\n  <div class='dz-error-message' style='position: absolute;top:-5px;left: -20px;min-width: 140px;max-width: 500px;opacity: 0;'><span data-dz-errormessage></span></div>\n</div>"
            });

        } catch (e) {
            alert('Dropzone.js does not support older browsers!');
        }

    });
</script>
</div>