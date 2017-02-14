<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "update types set name='{$_POST['name']}' where id='{$_POST['id']}'";
	mysqli_query($link,$SQL);
	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		header('location:./main_partList.php');
		exit();
	}else{
		mysqli_close($link);
		header("location:./main_modifySection.php?id={$_POST['id']}&name={$_POST['name']}");
		exit();
	}
?>