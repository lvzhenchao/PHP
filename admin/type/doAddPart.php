<?php
	//引用文件内以调用上传函数myUplode($upFileName);
	include '../../public/func.php';
	require '../../configDB/configdb.php';
	$pid = $_POST['pid'];
	$name = $_POST['name'];
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$filesKey = 'ico';
	$icoPath = '../../public/update/admin/partico';
	$upImgName = myUplod($filesKey,$icoPath)['uplodeImageName'];
	$SQL = "insert into types(name,pid,path,ico) values('{$name}',{$pid},'0-{$pid}','{$upImgName}')";
	mysqli_query($link,$SQL);
	if(mysqli_affected_rows($link) >= 1){
		mysqli_close($link);
		header('location:./main_partList.php');
	}else{
		mysqli_close($link);
		header('location:./main_partList.php');
	}
?>