<?php
	require '../../configDB/configdb.php';
	$name = $_POST['secName'];
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "insert into types(name,pid,path) values('{$name}','0','0')";
	mysqli_query($link,$SQL);
	echo mysqli_error($link);
	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		header('location:./main_partList.php');
	}else{
		mysqli_close($link);
		header('location:./main_addSection.html');
	}
?>