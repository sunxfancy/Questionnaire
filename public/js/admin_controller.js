(function() {
  var jumpto, updata, url;

  updata = function(url) {
    return $.get(url, function(data) {
      return $("#main_div").html(data);
    });
  };

  updata('/admin/dashboard');

  $('#main_nav li').first().attr('class', 'active');

  $('#main_nav li').each(function(index, value) {
    return $(this).attr('index', index);
  });

  url = ['/admin/dashboard', '/admin/questionimport', '/admin/questioneditor', '/admin/authmanager', '/admin/checkrequest', '/admin/setting'];

  $('#main_nav li').click(function() {
    $(this).siblings().attr('class', '');
    $(this).attr('class', 'active');
    return updata(url[$(this).index()]);
  });

  jumpto = function(p) {
    $('#main_nav li').attr('class', '');
    $('#main_nav').index(p).attr('class', 'active');
    return updata(url[p]);
  };

}).call(this);
