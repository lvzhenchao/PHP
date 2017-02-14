<?php
	require '../../configDB/configdb.php';
	$userName = $_POST['userName'];
	$password = md5($_POST['passwd']);
	$rem = $_POST['rem'];
	//连接数据库查询
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	if(mysqli_connect_errno()){
		exit('连接错误，请联系管理员 > < ！');
	}

	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	//查询登录信息
	$SQL = "select id,userName from user where userName='{$userName}' and password='{$password}' and status='1'";
	$result = mysqli_query($link,$SQL);
	//判断登录是否成功
	if($info = mysqli_fetch_assoc($result)){
		//登录成功，获取用户ID
		$id = $info['id'];
		//登陆积分+2
		$SQL = "select score from user where id={$id}";
		$result = mysqli_query($link,$SQL);
		$score = current(mysqli_fetch_assoc($result)) + 2;
		$SQL = "update user set score='{$score}' where id='{$id}'";
		mysqli_query($link,$SQL);
		//判断积分是否写入成功
		/*if(mysqli_affected_rows($link)){
			//积分写入成功
		}else{
			//积分写入失败
		}*/
		//启用SESSION，记录登录状态
		session_start();
		$_SESSION['id'] = $id;
		//登录成功，返回index
		mysqli_close($link);
		header('location:../index.php');
	}else{
		//登录失败
		mysqli_close($link);
		header('location:../index.php');
		exit;
	}

?>