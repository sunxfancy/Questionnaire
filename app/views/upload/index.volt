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
<a class="btn btn-primary" href="/upload/uploadPaper" role="button">点击导入数据</a>
<a class="btn btn-success" href="/upload/checkPaper"  role="button">查看试卷信息</a>
<a class="btn btn-danger"  href="/upload/updatePaper" role="button">更新试卷信息</a>
<a class="btn btn-danger"  href="/upload/deletePaper" role="button">删除试卷信息</a>
</p>

<h2>2.导入试题</h2>
<blockquote>按照名称,依次导入,题库位置：<strong>/public/相关数据/题库</strong></blockquote>
<h3>·2.1 导入SCL表数据</h3>
<blockquote>
<form class="form-inline" action="/upload/uploadTK/SCL" method="post" enctype="multipart/form-data">
        <input class="form-control" type="file" name="inputExcel">
        <input class="form-control btn btn-primary" type="submit" value="导入SCL数据" >
        <a class="btn btn-success"  href="/upload/checkSCL" role="button">查看SCL数据</a>
	<a class="btn btn-danger" href="/upload/deleteSCL" role="button">删除SCL数据</a>
</form>
</blockquote>

<h3>·2.2 CPI表导入</h3>
<blockquote>
<form class="form-inline" action="/upload/uploadTK/CPI" method="post" enctype="multipart/form-data">
        <input class="form-control" type="file" name="inputExcel">
        <input class="form-control btn btn-primary" type="submit" value="导入CPI数据" >
        <a class="btn btn-success"  href="/upload/checkCPI" role="button">查看CPI数据</a>
	<a class="btn btn-danger" href="/upload/deleteCPI" role="button">删除CPI数据</a>
</form>
</blockquote>

<h3>.2.3 EPPS表导入</h3>
<blockquote>
<form class="form-inline" action="/upload/uploadTK/EPPS" method="post" enctype="multipart/form-data">
        <input class="form-control" type="file" name="inputExcel">
        <input class="form-control btn btn-primary" type="submit" value="导入EPPS数据" >
        <a class="btn btn-success"  href="/upload/checkEPPS" role="button">查看EPPS数据</a>
	<a class="btn btn-danger" href="/upload/deleteEPPS" role="button">删除EPPS数据</a>
</form>
</blockquote>

<h3>·2.4 EPQA表导入</h3>
<blockquote>
<form class="form-inline" action="/upload/uploadTK/EPQA" method="post" enctype="multipart/form-data">
        <input class="form-control" type="file" name="inputExcel">
        <input class="form-control btn btn-primary" type="submit" value="导入EPQA数据" >
        <a class="btn btn-success"  href="/upload/checkEPQA" role="button">查看EPQA数据</a>
	<a class="btn btn-danger" href="/upload/deleteEPQA" role="button">删除EPQA数据</a>
</form>
</blockquote>

<h3>·2.5 16PF(KS)表导入</h3>
<blockquote>
<form class="form-inline" action="/upload/uploadTK/KS" method="post" enctype="multipart/form-data">
        <input class="form-control" type="file" name="inputExcel">
        <input class="form-control btn btn-primary" type="submit" value="导入16PF数据" >
        <a class="btn btn-success"  href="/upload/checkKS" role="button">查看16PF数据</a>
	<a class="btn btn-danger" href="/upload/deleteKS" role="button">删除16PF数据</a>
</form>
</blockquote>

<h3>·2.6 SPM表导入</h3>
<blockquote>
<a class="btn btn-primary"  href="/upload/uploadSPM" role="button">导入SPM数据</a>
<a class="btn btn-success"  href="/upload/checkSPM" role="button">查看SPM数据</a>
<a class="btn btn-danger" href="/upload/deleteSPM" role="button">删除SPM数据</a>
</blockquote>

<h2>3.导入试题得分对照表</h2>
<blockquote>按照名称,依次导入,得分对照表位置：<strong>/public/相关数据/得分对照表</strong></blockquote>
<blockquote>该数据无外键约束到question表，因此由navicat导入</blockquote>

<h2>4.导入个人报告指标评语描述</h2>
<blockquote>个人报告指标评语描述表位置：<strong>/public/相关数据/个人指标描述</strong></blockquote>
<blockquote>
<form class="form-inline" action="/upload/uploadReportComment" method="post" enctype="multipart/form-data">
        <input class="form-control" type="file" name="inputExcel">
        <input class="form-control btn btn-primary" type="submit" value="导入评语数据" >
</form>
</blockquote>
<h2>5.导入胜任力指标描述</h2>
<blockquote>胜任力指标描述表位置：<strong>/public/相关数据/胜任力指标描述</strong></blockquote>
<blockquote>
<form class="form-inline" action="/upload/uploadCompetency" method="post" enctype="multipart/form-data">
        <input class="form-control" type="file" name="inputExcel">
        <input class="form-control btn btn-primary" type="submit" value="导入胜任力指标" >
</form>
</blockquote>
<h2>6.中间层json文件存入数据库</h2>
<blockquote>所有中间层数据都存在MiddleLayer.json文件中，点击下面“存入数据库”按钮即将数据存入MiddleLayer表中</blockquote>
<blockquote>
<a class="btn btn-success" href="/upload/insertMiddle" role="button">存入数据库</a>
</blockquote>

</div>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>