<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$id = $_GET['id'];
	$SQL = "delete from user where id={$id}";
	mysqli_query($link,$SQL);
	$SQL = "delete from userDetail where id={$id}";
	mysqli_query($link,$SQL);
	$SQL = "delete from post where uid={$id}";
	mysqli_query($link,$SQL);
	$SQL = "delete from reply where uid={$id}";
	mysqli_query($link,$SQL);
	mysqli_close($link);
	header('location:./main_userList.php');
?>