<?php
	
	session_start();
	if($_POST['code'] !== $_SESSION['code']){
		exit('验证码错误');
		header('location:./login.php');
	}
	require '../configDB/configdb.php';
	$password = md5($_POST['password']);
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "select * from user where userName='{$_POST['userName']}' and password='{$password}' and auth='1' and status='1'";
	$result = mysqli_query($link,$SQL);
	if($info = mysqli_fetch_assoc($result)){
		$_SESSION['id'] = $info['id'];
		mysqli_close($link);
		header('location:./index.php');
	}else{
		mysqli_close($link);
		header('location:./login.php');
	}
?>