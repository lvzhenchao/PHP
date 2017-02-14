<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$str = $_POST['content'];
	$SQLModify = "update post set title='{$_POST['title']}',content='{$str}' where id={$_POST['postId']}";
	mysqli_query($link,$SQLModify);
	mysqli_close($link); 
	header('location:./main_postList.php');
?>