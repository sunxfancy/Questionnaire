{#{%  set a =  info.part_list[0] %}#}
{#{{ a.description }}#}
{#{{ info.type }}#}
{#{{ info.result_type }}#}
<script>
    $(function () {
        $(".checkbox").popover({
            'trigger':'manual',
            'placement':'bottom',
            'title':'警告',
            'content':"请至少选择一个题目类型"
        });


        $('#success-modal').modal({
            keyboard: true,
            show: false
        });
        $('#false-modal').modal({
            keyboard: true,
            show: false
        });
        $('#error-modal').modal({
            keyboard: true,
            show: false
        });

        $('#success-modal').on('hidden.bs.modal', function (e) {
            window.location = "/index";
        });

        $(".close-success-btn").click(function () {
            $('#success-modal').modal('hide');
        });
        $(".close-false-btn").click(function () {
            $('#false-modal').modal('hide');
        });
        $(".close-error-btn").click(function () {
            $('#error-modal').modal('hide');
        });

        $(':checkbox').attr('checked','checked');

        var isshow = false;
        function check(){
            var num = $(".cb:checked").length;
            if(num<=0){
                return false;
            }
            return true;
        }
        $("#add-form").submit(function (event) {
            var date = $("input[name='date']").val();
            var people = $("input[name='people']").val();
            var description = $("input[name='description']").val();
            var part = new Array();
            $(".cb:checked").each(function(index , value){
                part[index] = $(this).attr("pid");
            });
            if(check()){
                $.ajax('/index/addtest',{
                    type: "POST",
                    data: {date : date,people:people,description:description,part:part},
                    dataType: "text",
                    success:function(data){
                        var trimdata = $.trim(data);
                        if(trimdata=="true") {
                            $('#success-modal').modal('show');
                        }else{
                            $('#false-modal').modal('show');
                        }
                    },
                    error:function(){
                        $('#error-modal').modal('show');
                    }
                });
            }else{
                if(!isshow){
                    $(".checkbox").popover('show');
                    setInterval(function(){
                        $(".checkbox").popover('hide');
                        isshow=false;
                    },3000);
                    isshow=true;
                }
            }
            event.preventDefault();
        });
    });
</script>
<form method="post" id="add-form" action="/index/addtest"
      class="form-horizontal col-sm-11"
      role="form">
    <div class="form-group text-center">
        {{ partial('/shared/urllabel') }}
    </div>

    <div class="form-group">

        <label class="control-label col-sm-2" for="reservationtime">
            测评时间
        </label>

        <div class="col-sm-10">
            <div class="input-prepend input-group">
                        <span class="add-on input-group-addon">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar">
                            </i>
                        </span>
                <?php date_default_timezone_set('Asia/Shanghai') ?>
                <input required="required" type="text" name="date" id="reservationtime"
                       class="form-control" value="{{ date("Y-m-d H:i") }} - {{ date("Y-m-d H:i") }}" class="span4"/>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#reservationtime').daterangepicker({
                            timePicker: true,
                            timePickerIncrement: 30,
                            format: 'YYYY-MM-DD HH:mm'
                        },
                        function (start, end, label) {
                            console.log(start.toISOString(), end.toISOString(), label);
                        });
            });
        </script>
    </div>

    <div class="form-group">
        <label for="description" class="control-label col-sm-2">测试描述</label>

        <div class="col-sm-10">
            <input type="text" required="required" class="input-group col-sm-12" name="description" id="description">
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox-div col-lg-10 col-lg-offset-1" >
            <div class="col-lg-12 checkbox-title">
                <label class=" col-lg-offset-4 col-lg-4">
                    勾 选 题 目
                </label>
            </div>

            <div class="col-lg-12">
                <div class="checkbox">
                    {% for part in info.part_list %}
                        <label class="col-lg-4">
                            <input type="checkbox"  pid="{{ part.p_id }}" class="cb" name="part[]"> {{ part.name }}
                        </label>
                    {% endfor %}

                </div>
            </div>

            <div style="clear: both;"></div>
        </div>
    </div>


    <div class="form-group">
        <div class="col-lg-4 col-lg-offset-1" style="padding: 0">
            <button type="submit" id="btn-tmp" class="btn btn-primary col-lg-10">提交</button>
        </div>
    </div>
</form>

<div class="modal fade bs-example-modal-sm" id="success-modal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="padding: 10px;">
            <div style="border-bottom: 1px solid #E5E5E5">
                <span class="glyphicon glyphicon-th-large"></span>
                <span class="glyphicon glyphicon-remove-circle btn btn-link close-success-btn"
                      style="position: absolute;right: 0px;"></span>
            </div>
            <div style="margin-top: 10px;">
                编辑成功！
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="success-modal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="padding: 10px;">
            <div style="border-bottom: 1px solid #E5E5E5">
                <span class="glyphicon glyphicon-th-large"></span>
                <span class="glyphicon glyphicon-remove-circle btn btn-link close-success-btn"
                      style="position: absolute;right: 0px;"></span>
            </div>
            <div style="margin-top: 10px;">
                编辑失败
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="success-modal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="padding: 10px;">
            <div style="border-bottom: 1px solid #E5E5E5">
                <span class="glyphicon glyphicon-th-large"></span>
                <span class="glyphicon glyphicon-remove-circle btn btn-link close-success-btn"
                      style="position: absolute;right: 0px;"></span>
            </div>
            <div style="margin-top: 10px;">
                网络问题
            </div>
        </div>
    </div>
</div>