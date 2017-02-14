<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "delete from types where id='{$_GET['id']}'";
	mysqli_query($link,$SQL);
	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		header('location:./main_partList.php');
	}else{
		mysqli_close($link);
		exit('出错了！> < !');
	}
?>