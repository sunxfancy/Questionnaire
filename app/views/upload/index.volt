<!DOCTYPE html>
<head>
	<title>数据库之基础数据导入步骤</title>
	<link rel='stylesheet' type='text/css' href='/bootstrap/css/bootstrap.min.css'>
	
</head>
<body>
<div class = 'container'>
<h1>基础数据导入步骤</h1>
<h1><small><strong><span style='color:red'>必须首先导入"<mark>试卷表</mark>"</span></strong>,之后导入6张试题表, 6张基础得分对照表</small></small></h1>

<h2>1.导入试卷表</h2>
<blockquote>导入之前,可先行查看试卷表是否存在,点击“点击导入数据”导入试卷信息之后,可点击“查看试卷信息”,如需修改试卷信息,务必在项目源码中修改相应内容,之后在此处点击更新</blockquote>
<p>
<a class="btn btn-success" href="/upload/checkPaper"  role="button">查看试卷信息</a>
<a class="btn btn-primary" href="/upload/uploadPaper" role="button">点击导入数据</a>
<a class="btn btn-danger"  href="/upload/updatePaper" role="button">更新试卷信息</a>
</p>

<h2>2.导入试题</h2>
<blockquote>按照名称,依次导入,题库位置：<strong>/public/相关数据/题库</strong></blockquote>
<h3>·2.1 导入SCL表数据</h3>
<form action="/upload/uploadSCL" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tableExcel" value="true">
    <table align="center" width="90%" border="0">
    <tr>
       <td>
        <input type="file" name="inputExcel">
        <input type="submit" value="导入数据">
       </td>
    </tr>
    </table>
</form>

<h3>·2.2 CPI表导入</h3>
<form action="/upload/uploadCPI" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tableExcel" value="true">
    <table align="center" width="90%" border="0">
    <tr>
       <td>
        <input type="file" name="inputExcel"><input type="submit" value="导入数据">
       </td>
    </tr>
    </table>
</form>

<h3>.2.3 EPPS表导入</h3>
<form action="/upload/uploadEPPS" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tableExcel" value="true">
    <table align="center" width="90%" border="0">
    <tr>
       <td>
        <input type="file" name="inputExcel"><input type="submit" value="导入数据">
       </td>
    </tr>
    </table>
</form>

<h3>·2.4 EPQA表导入</h3>
<form action="/upload/uploadEPQA" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tableExcel" value="true">
    <table align="center" width="90%" border="0">
    <tr>
       <td>
        <input type="file" name="inputExcel"><input type="submit" value="导入数据">
       </td>
    </tr>
    </table>
</form>

<h3>·2.5 16PF(KS)表导入</h3>
<form action="/upload/uploadKS" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tableExcel" value="true">
    <table align="center" width="90%" border="0">
    <tr>
       <td>
        <input type="file" name="inputExcel"><input type="submit" value="导入数据">
       </td>
    </tr>
    </table>
</form>

<h3>·2.6 SPM表导入</h3>
<a class="btn btn-danger"  href="/upload/uploadSPM" role="button">导入SPM数据</a>

</div>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>