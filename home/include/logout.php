<?php
	//开启SESSION
	session_start();
	unset($_SESSION);
	session_destroy();
	setcookie(session_name(),'',time()-1);
	header('location:../index.php');
	exit;
?>