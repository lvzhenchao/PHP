<!DOCTYPE html>
<?php
	session_start();
	if($_SESSION['id'] != 1){
		header('location:../login.php');
	}
	require '../../configDB/configdb.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="../../public/admin/css/css/css.css" type="text/css" rel="stylesheet" />
<link href="../../public/admin/css/css/main.css" type="text/css" rel="stylesheet" />
<link rel="shortcut icon" href="../../public/admin/images/main/favicon.ico" />
<style>
body{overflow-x:hidden; background:#f2f0f5; padding:15px 0px 10px 5px;}
#searchmain{ font-size:12px;}
#search{ font-size:12px; background:#548fc9; margin:10px 10px 0 0; display:inline; width:100%; color:#FFF; float:left}
#search form span{height:40px; line-height:40px; padding:0 0px 0 10px; float:left;}
#search form input.text-word{height:24px; line-height:24px; width:180px; margin:8px 0 6px 0; padding:0 0px 0 10px; float:left; border:1px solid #FFF;}
#search form input.text-but{height:24px; line-height:24px; width:55px; background:url(../../public/admin/images/main/list_input.jpg) no-repeat left top; border:none; cursor:pointer; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#666; float:left; margin:8px 0 0 6px; display:inline;}
#search a.add{ background:url(../../public/admin/images/main/add.jpg) no-repeat -3px 7px #548fc9; padding:0 10px 0 26px; height:40px; line-height:40px; font-size:14px; font-weight:bold; color:#FFF; float:right}
#search a:hover.add{ text-decoration:underline; color:#d2e9ff;}
#main-tab{ border:1px solid #eaeaea; background:#FFF; font-size:12px;}
#main-tab th{ font-size:12px; background:url(../../public/admin/images/main/list_bg.jpg) repeat-x; height:32px; line-height:32px;}
#main-tab td{ font-size:12px; line-height:40px;}
#main-tab td a{ font-size:12px; color:#548fc9;}
#main-tab td a:hover{color:#565656; text-decoration:underline;}
.bordertop{ border-top:1px solid #ebebeb}
.borderright{ border-right:1px solid #ebebeb}
.borderbottom{ border-bottom:1px solid #ebebeb}
.borderleft{ border-left:1px solid #ebebeb}
.gray{ color:#dbdbdb;}
td.fenye{ padding:10px 0 0 0; text-align:right;}
.bggray{ background:#f9f9f9}
</style>
</head>
<body>
<!--main_top-->
<table width="99%" border="0" cellspacing="0" cellpadding="0" id="searchmain">
  <tr>
    <td width="99%" align="left" valign="top">您的位置：用户管理&nbsp;&nbsp;>&nbsp;&nbsp;用户列表</td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="search">
  		<tr>
   		 <td width="90%" align="left" valign="middle">
	         <form method="get" action="./main_userList.php">
	         <span>用户：</span>
	         <input type="text" name="search" value="" class="text-word"/>
	         <input name="" type="submit" value="查询" class="text-but"/>
	         <input name="" type="reset" value="清空" class="text-but"/>
	         </form>
         </td>
			<td width="10%" align="center" valign="middle" style="text-align:right; width:150px;">
				<a href="./main_addUser.html" target="mainFrame" onFocus="this.blur()" class="add">新增用户</a>
			</td>
  		</tr>
	</table>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
      <tr>
        <th align="center" valign="middle" class="borderright">编号</th>
        <th align="center" valign="middle" class="borderright">管理帐号</th>
        <th align="center" valign="middle" class="borderright">身份</th>
        <th align="center" valign="middle" class="borderright">状态</th>
        <th align="center" valign="middle" class="borderright">最后登录</th>
        <th align="center" valign="middle">操作</th>
      </tr>
	  <?php
	
		if(isset($_GET['page'])){
			$nowPage = $_GET['page'];
		}else{
			$nowPage = 1;
		}
		$items = 8;
		$startI = ($nowPage - 1) * $items;
		$limit = "limit {$startI},{$items}";
		
		$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
		mysqli_select_db($link,DATABASE);
		mysqli_set_charset($link,CHARSET);
		
		if(isset($_GET['search'])){
			$search = $_GET['search'];
		}else{
			$search = '';
		}

		include '../../public/func.php';
		$pandS = pagesAndSearch($link,'user',8,$nowPage,$search,'userName','id');
		$prevPage = $pandS['prevPage'];
		$nextPage = $pandS['nextPage'];
		$url = $pandS['addUrl'];
		$iCount = $pandS['iCount'];
		$maxPage = $pandS['maxPage'];
		$SQL = $pandS['SQL'];
		$num = 1;
		$auths = array('普通用户','管理员');
		$status1 = array('禁用','开启');
		$status2 = array('开启用户','禁用用户');
		$result = mysqli_query($link,$SQL);
		while($info = mysqli_fetch_assoc($result)){
		$id = $info['id'];
	  ?>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $num++ ?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $info['userName']; ?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $auths[$info['auth']]; ?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $status1[$info['status']]; ?></td>
        <td align="center" valign="middle" class="borderright borderbottom">2088-08-28 18:58:58</td>
        <td align="center" valign="middle" class="borderbottom">
		<a href="./main_mydifyUser.php?id=<?php echo $id ?>&userName=<?php echo $info['userName'] ?>&auth=<?php echo $info['auth'] ?>" target="mainFrame" onFocus="this.blur()" class="add">修改</a>
		<span class="gray">&nbsp;|&nbsp;</span>
		<a href="./doDelUser.php?id=<?php echo $id ?>" target="mainFrame" onFocus="this.blur()" class="add">删除</a>
		<span class="gray">&nbsp;|&nbsp;</span>
		<a href="./doBanUser.php?id=<?php echo $id ?>&status=<?php echo $info['status'] ?>" target="mainFrame" onFocus="this.blur()" class="add"><?php echo $status2[$info['status']]; ?></a>
		<!--<span class="gray">&nbsp;|&nbsp;</span>
		<a href="../user/main_postInfo.php?uid=<?php echo $id; ?><?php //echo ?>" target="mainFrame" onFocus="this.blur()" class="add">管理帖子</a>
		<span class="gray">&nbsp;|&nbsp;</span>
		<a href="add.html" target="mainFrame" onFocus="this.blur()" class="add">管理回复</a>-->
		</td>
      </tr>
	  <?php
		}		
	  ?>
    </table></td>
    </tr>
  <tr>
    <td align="left" valign="top" class="fenye"><?php echo $iCount ?> 条数据 <?php echo $nowPage.'/'.$maxPage; ?> 页&nbsp;&nbsp;
	<a href="./main_userList.php?page=<?php echo '1'.$url ?>" target="mainFrame" onFocus="this.blur()">首页</a>&nbsp;&nbsp;
	<a href="./main_userList.php?page=<?php echo $prevPage.$url ?>" target="mainFrame" onFocus="this.blur()">上一页</a>&nbsp;&nbsp;
	<a href="./main_userList.php?page=<?php echo $nextPage.$url ?>" target="mainFrame" onFocus="this.blur()">下一页</a>&nbsp;&nbsp;
	<a href="./main_userList.php?page=<?php echo $maxPage.$url  ?>" target="mainFrame" onFocus="this.blur()">尾页</a></td>
  </tr>
</table>
</body>
</html>