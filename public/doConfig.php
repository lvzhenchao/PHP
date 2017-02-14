<?php
	require './func.php';
	//写入文字配置及网站开关
	$config = file_get_contents('./config.php');
	foreach($_POST as $keys => $values){
		$config = preg_replace("/define\(\'{$keys}\'\,\'(.*)\'\)/","define('{$keys}','{$values}')",$config);
	}
	//获取图像配置
	$upFileName = 'webLogo';
	$icoPath = './update/admin/webico';
	//判断网站LOGO是否上传
	if(!empty($_FILES['webLogo']['name'])){
		//写入配置文件
		$webIcoName = myUplod($upFileName,$icoPath)['uplodeImageName'];
		$config = preg_replace("/define\(\'WEBLOGO\'\,\'(.*)\'\)/","define('WEBLOGO','{$webIcoName}')",$config);
	}
	$fp = fopen('./config.php','w+');
	fwrite($fp,$config);
	fclose($fp);
	header('location:../admin/config/main_config.php');
?>