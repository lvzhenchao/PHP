<?php
	require '../../configDB/configdb.php';
	session_start();
	$uid = $_SESSION['id'];
	require '../../public/func.php';
	$upFileName = 'hP';
	$icoPath = '../../public/update/home/images';
	$resultUplode = myUplod($upFileName,$icoPath);
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "update userDetail set photo='{$resultUplode['uplodeImageName']}' where id={$uid}";
	mysqli_query($link,$SQL);
	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		header('location:./I-headPortrait.php');
		exit();
	}else{
		mysqli_close($link);
		header('location:./I-headPortrait.php');
		exit();
	}
	
?>