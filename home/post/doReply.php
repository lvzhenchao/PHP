<?php
	require '../../configDB/configdb.php';
	$content = $_POST['content'];
	$replyCTime = $_POST['replyCTime'];
	$postId = $_POST['postId'];
	$typeId = $_POST['typeId'];
	session_start();
	$uid = $_SESSION['id'];
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "insert into reply(uid,pid,content,ctime) values({$uid},{$postId},'{$content}',{$replyCTime})";
	mysqli_query($link,$SQL);
	echo mysqli_error($link);
	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		header("location:../post.php?postId={$postId}&typeId={$typeId}");
		exit();
	}else{
		exit('回复失败');
	}
?>