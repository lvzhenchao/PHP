<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQLDel = "delete from reply where id={$_GET['replyId']}";
	mysqli_query($link,$SQLDel);
	if(mysqli_affected_rows($link)){
		header("location:./main_postInfo.php?postId={$_GET['postId']}");
	}
?>