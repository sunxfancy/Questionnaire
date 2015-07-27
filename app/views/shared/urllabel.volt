<label class="col-lg-12">学生登录url：{{url}} <a id="copy_btn" href="javascript:;" onClick="copy_url('{{url}}')">复制链接</a></label>

<script language="JavaScript">
    // 复制功能
var clip;
$(function() {
    //ZeroClipboard.setMoviePath( '/swf/ZeroClipboard.swf' );  //和html不在同一目录需设置setMoviePath
    ZeroClipboard.setMoviePath( '/swf/ZeroClipboard10.swf' );
    if (typeof(clip)!="undefined") {
      clip.destroy(); 
    }
    clip = new ZeroClipboard.Client();   //创建新的Zero Clipboard对象
    clip.setText( '' ); // will be set later on mouseDown   //清空剪贴板
    clip.setHandCursor( true );      //设置鼠标移到复制框时的形状
    clip.setCSSEffects( true );          //启用css
    clip.addEventListener( 'complete', function(client, text) {     //复制完成后的监听事件
          alert("复制成功！");      
          // clip.hide();                                          // 复制一次后，hide()使复制按钮失效，防止重复计算使用次数
     } );
    clip.addEventListener( 'mouseDown', function(client) {
          clip.setText('{{url}}');
    } );
    
    clip.glue( 'copy_btn' );
});
</script>