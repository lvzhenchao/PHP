<?php
	require '../../configDB/configdb.php';
	$userName = $_POST['userName'];
	$password = md5($_POST['passwd']);
	$rePassword = md5($_POST['rePasswd']);
	
	if(empty($userName) ||empty($password) || $password != $rePassword){
		exit('用户名为空或两次密码输入不一致，请检查后重新添加');
	}
	$auth = $_POST['auth'];
	
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	if(mysqli_connect_errno()){
		exit('链接出错啦！> < !');
	}
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "insert into user(userName,password,auth) values('{$userName}','{$password}','{$auth}')";
	mysqli_query($link,$SQL);
	if(mysqli_affected_rows($link) >= 1){
		$SQLDetail = "insert into userDetail(id,name) values((select id from user where userName='{$userName}'),'{$userName}')";
		mysqli_query($link,$SQLDetail);
		if(mysqli_affected_rows($link) >= 1){
			echo 'ok!';
		}else{
			echo 'userDetail信息录入失败，请检查数据库';
		}
		mysqli_close($link);
		exit('user添加成功！');
	}else{
		mysqli_close($link);
		header('localtion:./main_addUser.html');
		exit();
	}
?>