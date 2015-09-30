<script type="text/javascript" src="/js/bootstrap.js"></script>
<script src='/fileupload/ajaxfileupload.js'></script>
<div class="Leo_question" style="overflow:hidden;padding:10px;">
    <div class="form-group">
            <div style="display:inline-block;margin-left:40px;font-size:26px;color:red;">绿色通道</div>
            <span class="label" id='inquery_state'></span>
    </div>  
    <hr size="2" color="#FF0000" style="width:90%;"/>

      <hr size="2" color="#FF0000" style="width:90%;"/>
   <div style='display:inline-block;'>
                <form action='/pm' class="form-inline" method='post'>
                    <input id='page' value='1' name='page' type='hidden'/>
                    <button type='submit' class='btn btn-success' style='width:80px;'>返回上层</button>
                </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">提示信息</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

