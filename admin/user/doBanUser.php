<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$id = $_GET['id'];
	$Status = $_GET['status'] == '1' ? '0' : '1' ;
	$SQL = "update user set status='{$Status}' where id='{$id}'";
	mysqli_query($link,$SQL);
	mysqli_close($link);
	header('location:./main_userList.php');
	exit();
?>