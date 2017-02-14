<!DOCTYPE html>
<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQLForPost = "select * from post where id={$_GET['postId']}";
	$resultForPost = mysqli_fetch_assoc(mysqli_query($link,$SQLForPost));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="../../public/admin/css/css/css.css" type="text/css" rel="stylesheet" />
<link href="../../public/admin/css/css/main.css" type="text/css" rel="stylesheet" />
<link rel="shortcut icon" href="../../public/admin/images/main/favicon.ico" />
<link rel="stylesheet" type="text/css" href="./include/editor/styles/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="./include/editor/styles/simditor.css" />
<link rel="stylesheet" type="text/css" href="./include/editor/styles/simditor-emoji.css" />
<script type="text/javascript" src="./include/editor/scripts/jquery.min.js"></script>
<script type="text/javascript" src="./include/editor/scripts/module.js"></script>
<script type="text/javascript" src="./include/editor/scripts/uploader.js"></script>
<script type="text/javascript" src="./include/editor/scripts/simditor.js"></script>
<script type="text/javascript" src="./include/editor/scripts/simditor-emoji.js"></script>
<script type="text/javascript" src="./include/editor/scripts/config.js"></script>
<style>
body{overflow-x:hidden; background:#f2f0f5; padding:15px 0px 10px 5px;}
#searchmain{ font-size:12px;}
#search{ font-size:12px; background:#548fc9; margin:10px 10px 0 0; display:inline; width:100%; color:#FFF}
#search form span{height:40px; line-height:40px; padding:0 0px 0 10px; float:left;}
#search form input.text-word{height:24px; line-height:24px; width:180px; margin:8px 0 6px 0; padding:0 0px 0 10px; float:left; border:1px solid #FFF;}
#search form input.text-but{height:24px; line-height:24px; width:55px; background:url(images/main/list_input.jpg) no-repeat left top; border:none; cursor:pointer; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#666; float:left; margin:8px 0 0 6px; display:inline;}
#search a.add{ background:url(images/main/add.jpg) no-repeat 0px 6px; padding:0 10px 0 26px; height:40px; line-height:40px; font-size:14px; font-weight:bold; color:#FFF}
#search a:hover.add{ text-decoration:underline; color:#d2e9ff;}
#main-tab{ border:1px solid #eaeaea; background:#FFF; font-size:12px;}
#main-tab th{ font-size:12px; background:url(images/main/list_bg.jpg) repeat-x; height:32px; line-height:32px;}
#main-tab td{ font-size:12px; line-height:40px;}
#main-tab td a{ font-size:12px; color:#548fc9;}
#main-tab td a:hover{color:#565656; text-decoration:underline;}
.bordertop{ border-top:1px solid #ebebeb}
.borderright{ border-right:1px solid #ebebeb}
.borderbottom{ border-bottom:1px solid #ebebeb}
.borderleft{ border-left:1px solid #ebebeb}
.gray{ color:#dbdbdb;}
td.fenye{ padding:10px 0 0 0; text-align:right;}
.bggray{ background:#f9f9f9; font-size:14px; font-weight:bold; padding:10px 10px 10px 0; width:120px;}
.main-for{ padding:10px;}
.main-for input.text-word{ width:310px; height:36px; line-height:36px; border:#ebebeb 1px solid; background:#FFF; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; padding:0 10px;}
.main-for select{ width:310px; height:36px; line-height:36px; border:#ebebeb 1px solid; background:#FFF; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#666;}
.main-for input.text-but{ width:100px; height:40px; line-height:30px; border: 1px solid #cdcdcd; background:#e6e6e6; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#969696; float:left; margin:0 10px 0 0; display:inline; cursor:pointer; font-size:14px; font-weight:bold;}
.main-for textarea{ width:100%; height:150px; line-height:24px; border:#ebebeb 1px solid; background:#FFF; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; padding:10px; color:#666}
#addinfo a{ font-size:14px; font-weight:bold; background:url(images/main/replayblack.jpg) no-repeat 0 0px; padding:0px 0 0px 20px; line-height:45px;}
#addinfo a:hover{ background:url(images/main/replayblue.jpg) no-repeat 0 0px;}
</style>
</head>
<body>
<!--main_top-->
<table width="99%" border="0" cellspacing="0" cellpadding="0" id="searchmain">
  <tr>
    <td width="99%" align="left" valign="top">您的位置：帖子列表&nbsp;&nbsp;>&nbsp;&nbsp;帖子修改</td>
  </tr>
  <tr>
    <td align="left" valign="top" id="addinfo">
    <!--<a href="add.html" target="mainFrame" onFocus="this.blur()" class="add">返回上一级</a>-->
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <form method="post" action="doModifyPost.php">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
      <!--<tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">留言id：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">1</td>
        </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">使用者id：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">0</td>
        </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">留言类型：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">留言测试</td>
        </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">邮箱：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">admin@sina.com</td>
        </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">留言时间：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">2013-04-19 15:35:13</td>
      </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">留言标题：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">留言测试留言测试留言测试留言测试内容</td>
      </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">留言内容：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for" style="line-height:24px;">留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容</td>
      </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">回复时间：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">2013-04-27 10:05:56&nbsp;&nbsp;<a href="add.html" target="mainFrame" onFocus="this.blur()" class="add">删除</a></td>
      </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">回复内容：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容</td>
      </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">回复时间：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">2013-04-27 10:05:56&nbsp;&nbsp;<a href="add.html" target="mainFrame" onFocus="this.blur()" class="add">删除</a></td>
      </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">回复内容：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容留言测试留言测试留言测试留言测试内容</td>
      </tr>-->
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">帖子标题：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">
		<input type="text" name="title" value="<?php echo $resultForPost['title']; ?>" class="text-word"></td>
      </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">帖子内容：</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for">
		<textarea id="editor" name="content" cols="" rows=""><?php echo $resultForPost['content']; ?></textarea>
		<input type="hidden" name="postId" value="<?php echo $_GET['postId']; ?>" />
		</td>
      </tr>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="right" valign="middle" class="borderright borderbottom bggray">&nbsp;</td>
        <td align="left" valign="middle" class="borderright borderbottom main-for"><input name="" type="submit" value="确定修改" class="text-but">
        <!--<input name="" type="reset" value="重置" class="text-but">--></td>
      </tr>
    </table>
    </form>
    </td>
    </tr>
</table>
</body>
</html>