<?php
	require '../../configDB/configdb.php';
	$password = md5($_POST['password']);
	$rePassword = md5($_POST['repassword']);
	if($password !== $rePassword){
		exit('两次密码不一致！> < !');
	}else{
		$nPassword = empty($_POST['password']) ? '' : ",password='{$password}'";
	}
	$nAuth = ",auth='{$_POST['auth']}'";
	$id = $_POST['id'];

	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL1 = "update user set ";
	$SQL2 = "{$nPassword}{$nAuth} where id='{$id}'";
	$SQL2[0] = ' ';
	$SQL = $SQL1.$SQL2;
	mysqli_query($link,$SQL);
	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		header('location:./main_userList.php');
		exit();
	}else{
		mysqli_close($link);
		exit('操作失败或与原密码一致');
	}
?>