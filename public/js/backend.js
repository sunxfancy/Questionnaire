/**
 * Created by vvliebe on 2014/10/21.
 */

$(function () {
    //ajax获取相应页面
    function getpage(path) {
        console.log(path);
        $.ajax({
            type: "get",
            url: path,
            dataType: "html",
            success: function (data) {
                $(".content-div").html(data);
                // $(".content-div").html($(data));

            },
            error: function () {
                alert("error");
            }
        });
    }

    getpage("/index/surveylist");



    $(".menu-li").click(function () {
            $(this).addClass("active").siblings().removeClass("active");
            var url_path = "/index/" + $(this).attr("targetpage");
            getpage(url_path);
        }
    );

});
