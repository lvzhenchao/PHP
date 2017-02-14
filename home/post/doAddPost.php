<?php
	require '../../configDB/configdb.php';
	session_start();
	$typeId = $_POST['typeId'];
	if(empty($_POST['content']) || empty($_POST['title'])){
		exit("<a href='../postList.php?typeId={$typeId}'><h4>发表失败，请点击返回</h4></a>");
	}else{
		$content = $_POST['content'];
		$title = $_POST['title'];
	}
	$ctime = $_POST['ctime'];
	$uid = $_SESSION['id'];
	if(isset($_POST['reply'])){
		$reply = $_POST['reply'];
	}else{
		$reply = 0;
	}
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "insert into post(uid,tid,title,content,ctime,reply) value({$uid},{$typeId},'{$title}','{$content}',{$ctime},'{$reply}')";
	mysqli_query($link,$SQL);
	echo mysqli_error($link);
	if(mysqli_affected_rows($link) >= 1){
		//发帖增加30积分
		$SQLSelectScore = "select score from user where id={$uid}";
		$Nscore = mysqli_fetch_assoc(mysqli_query($link,$SQLSelectScore))['score']+20;
		$SQLUpdateScore = "update user set score={$Nscore} where id={$uid}";
		mysqli_query($link,$SQLUpdateScore);
		mysqli_close($link);
		header("location:../postList.php?typeId={$typeId}");
		exit('');
	}else{
		echo '失败';
	}
?>