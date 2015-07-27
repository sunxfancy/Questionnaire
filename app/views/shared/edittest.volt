{#{%  set a =  info.part_list[0] %}#}
{#{{ a.description }}#}
{#{{ info.test['people'] }}#}
<script>
    $(function () {

        $(".checkbox").popover({
            'trigger': 'manual',
            'placement': 'bottom',
            'title': '警告',
            'content': "请至少选择一个题目类型"
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

        {% for partid in info.parts %}
        $(".cb[pid={{ partid }}]").attr("checked", "checked");
        {% endfor %}

        var test_id ={{ info.test['test_id'] }};
        var people ={{ info.test['people'] }};
        var description = "{{ info.test['description'] }}";
        var isshow = false;

        function check() {
            var num = $(".cb:checked").length;
            if (num <= 0) {
                return false;
            }
            return true;
        }

        $("#update-form").submit(function (event) {
            var date = $("input[name='date']").val();
            var part = new Array();
            $(".cb:checked").each(function (index, value) {
                part[index] = $(this).attr("pid");
                console.log($(this).attr("pid"));
            });
            if (check()) {
                $.ajax('/index/updatetest', {
                    type: "POST",
                    cache: false,
                    data: {date: date, part: part, test_id: test_id, description: description, people: people},
                    dataType: "text",
                    success: function (data) {
                        var trimdata = $.trim(data);
                        if (trimdata == "true") {
                            $('#success-modal').modal('show');
                        } else {
                            $('#false-modal').modal('show');
                        }
                    },
                    error: function () {
                        $('#error-modal').modal('show');
                    }
                });
            } else {
                if (!isshow) {
                    $(".checkbox").popover('show');
                    setInterval(function () {
                        $(".checkbox").popover('hide');
                        isshow = false;
                    }, 3000);
                    isshow = true;
                }
            }
            event.preventDefault();
        });

    });
</script>
<ol class="breadcrumb">
    <li><a href="#">编辑测评</a></li>
    <li class="active">编辑</li>
    <li class="active">{{ info.test['description'] }}</li>
</ol>
<form id="update-form" action="/index/updatetest" method="post"
      class="form-horizontal"
      role="form">
      <div class="form-group text-center">
        {{ partial('/shared/urllabel') }}
      </div>
    <div class="form-group">
        <label class="control-label col-lg-2" for="reservationtime">
            测评时间
        </label>

        <div class="controls col-lg-9">
            <div class="input-prepend input-group">
                        <span class="add-on input-group-addon">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar">
                            </i>
                        </span>
                <input required="required" type="text" name="date" id="reservationtime"
                       class="form-control" value="{{ info.test['begin'] }} - {{ info.test['end'] }}"/>
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
        <div class="checkbox-div col-lg-10 col-lg-offset-1" style="padding: 0">
            <div class="col-lg-12 checkbox-title">
                <label class=" col-lg-offset-4 col-lg-4">
                    勾 选 题 目
                </label>
            </div>

            <div class="col-lg-12">
                <div class="checkbox">
                    {% for part in info.part_list %}
                        <label class="col-lg-4">
                            <input type="checkbox" class="cb" pid="{{ part.p_id }}"
                                   name="part[]"> {{ part.name }}
                        </label>
                    {% endfor %}

                </div>
            </div>

            <div style="clear: both;"></div>
        </div>
    </div>

    <div class="form-group">

        <div class="col-lg-4 col-lg-offset-1" style="padding: 0">
            <button type="submit" class="btn btn-primary col-lg-10">提交</button>
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


