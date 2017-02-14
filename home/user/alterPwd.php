<?php
	require '../../configDB/configdb.php';
	session_start();

	$id = $_SESSION['id'];
	$oldPassword = md5($_POST['oldPasswd']);
	$newPassword = md5($_POST['newPasswd']);
	$reNewPassword = md5($_POST['renewPasswd']);
	
	if(empty($newPassword) || $newPassword !== $reNewPassword){
		$_SESSION['p-alterp'] = 'false';
		mysqli_close($link);
		header('location:./p-password.php');
		exit();
	}
	
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	if(mysqli_connect_errno()){
		exit('链接错误，请联系管理员 > < ！');
	}
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
		$SQL = "update user set password='{$newPassword}' where id={$id} and password='{$oldPassword}'";
		mysqli_query($link,$SQL);
		
		if(mysqli_affected_rows($link) >= 1){
			mysqli_close($link);
			exit('<a href="./I-alterPassword.php" >修改成功！，点击这里跳转到个人信息主页！</a>');
			
		}else{
			$_SESSION['p-alterp'] = 'false';
			mysqli_close($link);
			header('location:./I-alterPassword.php');
			exit('失败');
		}

	
	
?>