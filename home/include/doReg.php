<?php
	require '../../configDB/configdb.php';
	//判断并显示POST所有值
	if(empty($_POST['userName']) || empty($_POST['passwd']) || empty($_POST['repasswd']) || empty($_POST['email']) || empty($_POST['read']) || empty($_POST['code'])){
		header('location:../register.php');
		exit();
	}
	$vcode = $_POST['code'];
	//使用SESSION获取验证码
	session_start();
	$code = $_SESSION['code'];
	//判断验证码
	if($code !== $vcode){
		header('location:../register.php');
		exit();
	}
	//获取注册信息
	$userName = $_POST['userName'];
	$password = md5($_POST['passwd']);
	$repassword = md5($_POST['repasswd']);
	
	if($password !== $repassword){
		header('location:../register.html');
		exit();
	}
	//写入数据库
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	if(mysqli_connect_errno()){
		exit('连接错误，请联系管理员 > < !');
	}

	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "insert into user(userName,password) values('{$userName}','{$password}')";
	mysqli_query($link,$SQL);
	//查询用户是否可以注册，是否重名
	if(mysqli_affected_rows($link) >= 1){
		//查询此用户注册ID
		$SQL = "select id from user where userName='{$userName}'";
		$result = mysqli_query($link,$SQL);
		if($info = mysqli_fetch_assoc($result)){
			//获取此用户注册ID
			$id = $info['id'];
			//获取email地址并将email和userName写入userDetail表
			$email = $_POST['email'];
			$SQL = "insert into userDetail(id,name,email) values('{$id}','{$userName}','{$email}')";
			mysqli_query($link,$SQL);
			//判断email是否写入成功
			if(mysqli_affected_rows($link) >= 1){
				//注册成功，可以登陆了
				mysqli_close($link);
				header('location:../index.php');
				exit();
			}else{
				//写入Detail表出错
				mysqli_close($link);
				exit('连接错误，请联系管理员 > < !!!');
			}
		}else{
			//查询用户注册ID出错
			mysqli_close($link);
			exit('连接错误，请联系管理员 > < !!');
		}		
	}else{
		//用户名重名或数据库错误
		mysqli_close($link);
		header('location:../register.php');
		exit();
	}
	
?>