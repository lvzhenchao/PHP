<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左侧导航menu</title>
<link href="../public/admin/css/css/css.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../public/admin/js/sdmenu.js"></script>
<script type="text/javascript">
	// <![CDATA[
	var myMenu;
	window.onload = function() {
		myMenu = new SDMenu("my_menu");
		myMenu.init();
	};
	// ]]>
</script>
<style type=text/css>
html{ SCROLLBAR-FACE-COLOR: #538ec6; SCROLLBAR-HIGHLIGHT-COLOR: #dce5f0; SCROLLBAR-SHADOW-COLOR: #2c6daa; SCROLLBAR-3DLIGHT-COLOR: #dce5f0; SCROLLBAR-ARROW-COLOR: #2c6daa;  SCROLLBAR-TRACK-COLOR: #dce5f0;  SCROLLBAR-DARKSHADOW-COLOR: #dce5f0; overflow-x:hidden;}
body{overflow-x:hidden; background:url(../public/admin/images/main/leftbg.jpg) left top repeat-y #f2f0f5; width:194px;}
</style>
</head>
<body onselectstart="return false;" ondragstart="return false;" oncontextmenu="return false;">
<div id="left-top">
<?php
	require '../configDB/configdb.php';
	session_start();
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "select * from userDetail where id={$_SESSION['id']}";
	$result = mysqli_fetch_assoc(mysqli_query($link,$SQL));
?>
	<div><img src="../public/update/home/images/<?php echo $result['photo'];?>" width="44" height="44" /></div>
    <span>用户：<?php echo $result['name']; ?><br>角色：管理员</span>
</div>
    <div style="float: left" id="my_menu" class="sdmenu">
      <div class="collapsed">
        <span>用户管理</span>
        <a href="./user/main_userList.php" target="mainFrame" onFocus="this.blur()">用户列表</a>
        <a href="./user/main_addUser.html" target="mainFrame" onFocus="this.blur()">添加用户</a>
        <!--<a href="main_info.html" target="mainFrame" onFocus="this.blur()">列表详细页</a>
        <a href="main_message.html" target="mainFrame" onFocus="this.blur()">留言页</a>
        <a href="main_menu.html" target="mainFrame" onFocus="this.blur()">栏目管理</a>-->
      </div>
      <div>
        <span>板块管理</span>
        <a href="./type/main_partList.php" target="mainFrame" onFocus="this.blur()">板块列表</a>
        <a href="./type/main_addSection.html" target="mainFrame" onFocus="this.blur()">添加分区</a>
<!--    <a href="main_info.html" target="mainFrame" onFocus="this.blur()">角色管理</a>
        <a href="main.html" target="mainFrame" onFocus="this.blur()">自定义权限</a> -->
      </div>
      <div>
        <span>帖子管理</span>
        <a href="./post/main_postList.php" target="mainFrame" onFocus="this.blur()">帖子列表</a>
        <a href="./post/main_recycleList.php" target="mainFrame" onFocus="this.blur()">回收站</a>
        <!--<a href="main_info.html" target="mainFrame" onFocus="this.blur()">角色管理</a>
        <a href="main.html" target="mainFrame" onFocus="this.blur()">自定义权限</a>-->
      </div>
      <div>
        <span>站点管理</span>
        <a href="./config/main_config.php" target="mainFrame" onFocus="this.blur()">配置网站</a>
        <!--<a href="main_list.html" target="mainFrame" onFocus="this.blur()">级别权限</a>
        <a href="main_info.html" target="mainFrame" onFocus="this.blur()">角色管理</a>
        <a href="main.html" target="mainFrame" onFocus="this.blur()">自定义权限</a>-->
      </div>
    </div>
</body>
</html>