<?php
	//写入数据库配置
	$config = file_get_contents('./configdb.php');
	foreach($_POST as $keys => $values){
		$config = preg_replace("/define\(\'{$keys}\'\,\'(.*)\'\)/","define('{$keys}','{$values}')",$config);
	}
	$fp = fopen('./configdb.php','w+');
	fwrite($fp,$config);
	fclose($fp);
	if($_POST['toLead'] == 1){
		require './configdb.php';
		$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
		if(mysqli_connect_errno()){
			echo '数据库连接失败'.mysqli_connect_error();
		}
		$SQLDB = "create database if not exists ".DATABASE;
		if(!mysqli_query($link,$SQLDB)){exit('数据库创建失败');}
		//库创建成功
		//选择库  创建表
		if(!mysqli_select_db($link,DATABASE)){
			echo '数据库选择失败';
		}
		mysqli_set_charset($link,CHARSET);
		
		//读建表文件 
		$sqlstr = file_get_contents('./Simver.sql');
		$sqlarr = explode(';',$sqlstr);
		array_pop($sqlarr);
		foreach($sqlarr as $key => $val){
			if(mysqli_query($link,$val)){
				echo '<h3>第'.($key+1).'个表>>>>>>>>>>>>>>>>>>>>创建成功</h3><br>';
			}else{
				echo '第'.($key+1).'个表>>>>>>>>>>>>>>>>>>>>创建失败</h3><br>';
			}
		}

			mysqli_close($link);
			exit('<h2>所有表创建成功!</h2><br />
			<h2><a href="./adminUser.php">请点击这里进入下一步</a></h2>');
		}else{
			exit('<h2>error:#0015</h2>');
		}

?>