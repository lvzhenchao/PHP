<?php
	require '../../configDB/configdb.php';
	session_start();

	$id = $_SESSION['id'];
	$uName = empty($_POST['userName']) ? '' : ",name='{$_POST['userName']}'";
	$uEmail = empty($_POST['email']) ? '' : ",email='{$_POST['email']}'";
	$uQQ = empty($_POST['QQ']) ? '' : ",qq='{$_POST['QQ']}'";
	$uInfo = empty($_POST['info']) ? '' : ",info='{$_POST['info']}'";
	
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	if(mysqli_connect_errno()){
		exit('连接错误，请与管理员联系！ > < !');
	}
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL1 = "update userDetail set ";
	$SQL2 = "{$uName}{$uEmail}{$uQQ}{$uInfo} where id='{$id}'";
	$SQL2[0] = ' ';
	$SQL = $SQL1.$SQL2;
	mysqli_query($link,$SQL);

	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		header('location:./I-information.php');
		exit();
	}else{
		mysqli_close($link);
		header('location:./I-information.php');
		exit();
	}

?>