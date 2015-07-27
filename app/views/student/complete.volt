<script>
    function deleteAllCookies() {
        var cookies = document.cookie.split(";");
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }

    function btnConfirm(){
        deleteAllCookies();
        var url = "{{ url }}";
        window.location = url;
    }
</script>

<div style="width: 80%;margin: 120px auto;font-family: 微软雅黑;">
    <div class="jumbotron" style="padding:48px 15px">
        <h1>恭喜你答完所有试题</h1>
        <p>点击“确认”按钮以完成您的答题</p>
        <p><a class="btn btn-primary btn-lg" onclick="btnConfirm()" href="javascript:void(0);" role="button">确认</a></p>
    </div>
</div>
