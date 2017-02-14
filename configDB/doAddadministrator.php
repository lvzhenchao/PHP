<?php
	require '../configDB/configdb.php';
	if(empty($_POST)){
		header('location:./adminUser.php');
	}
	$userName = $_POST['userName'];
	$password = md5($_POST['passwd']);
	$rePassword = md5($_POST['rePasswd']);
	
	if(empty($userName) ||empty($password) || $password != $rePassword){
		exit('用户名为空或两次密码输入不一致，请检查后重新添加');
	}
	
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	if(mysqli_connect_errno()){
		exit('链接出错啦！> < !');
	}
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "insert into user(userName,password,auth) values('{$userName}','{$password}','1')";
	mysqli_query($link,$SQL);
	if(mysqli_affected_rows($link) >= 1){
		$SQLDetail = "insert into userDetail(id,name) values((select id from user where userName='{$userName}'),'{$userName}')";
		mysqli_query($link,$SQLDetail);
		if(mysqli_affected_rows($link) >= 1){
			echo 'ok!';
		}else{
			echo 'userDetail信息录入失败，请检查数据库';
		}
		mysqli_close($link);\
		file_put_contents('./succeed.lock','ok');
		exit("
		<h1>管理员账号信息录入成功！BBS论坛可以正常使用:)</h1>
		<h2><a href='../home/index.php'>点击此处进入bbs主页</h2>
		<h2><a href='../admin/index.php'>点击此处进入后台管理主页</h2>
		");
	}else{
		mysqli_close($link);
		exit('error:#0151');
	} 
?>