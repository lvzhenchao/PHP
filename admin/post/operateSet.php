<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	if($_GET['op'] == 'del'){
		$SQL = "delete from post where id={$_GET['id']}";
	}else{
		$SQLS = "select {$_GET['op']} from post where id={$_GET['id']}";
		$SResult = mysqli_query($link,$SQLS);
		$SInfo = mysqli_fetch_assoc($SResult)["{$_GET['op']}"];
		$Change = array('0' => '1','1' => '0');
		$SInfo = $Change[$SInfo];
		$SQL = "update post set {$_GET['op']}='{$SInfo}' where id={$_GET['id']}";
	}
	if(isset($_GET['page'])){
		$page = 'page='.$_GET['page'];
	}else{
		$page = 'page=1';
	}
	if(isset($_GET['search'])){
		$search = '&search='.$_GET['search'];
	}else{
		$search = '';
	}
	mysqli_query($link,$SQL);
	echo mysqli_error($link);
	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		//判断页面跳回到哪个页面
		if(isset($_GET['mark'])){
			$_GET['mark'] = 0;
		}
		if($_GET['op'] == 'recycle' || $_GET['mark'] == 'recycle'){
			header("location:./main_recycleList.php?{$page}{$search}");
		}else{
			header("location:./main_postList.php?{$page}{$search}");
		}
		exit();
	}else{
		mysqli_close($link);
		header("location:./main_postList.php?{$page}{$search}");
		exit();
	}
?>