<!DOCTYPE html>
<?php
	require '../public/config.php';
	require '../public/func.php';
	webSwitch(WEBSWITCH);
?>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo TITLE; ?></title>
		<meta name="keywords" content="<?php echo KEYWORDS; ?>" />
		<meta name="description" content="<?php echo DESCRIPTION; ?>" />
		<link href="../public/home/css/reset200802.css" type="text/css" rel="stylesheet" />
		<link href="../public/home/css/csshome.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<?php 
			require './include/head.php'; 
		?>
		<div class="guide">
			<img src="../public/home/images/home.gif.png" />
			<a href="./index.php" >LAMP兄弟连</a>
			<span>&gt;</span>
			<a href="#" >技术交流</a>
			<span>&gt;</span>
			<a href="#" >发表帖子</a>
		</div>
		<!-- 框架模块开始 -->
		<div id="per">
			<div></div>
			<div>
				<div>
					<div><a href="./user/I-information.php" target="per">修改信息</a></div>
					<div><a href="./user/I-alterPassword.php" target="per">修改密码</a></div>
					<div><a href="./user/I-headPortrait.php" target="per">修改头像</a></div>
				</div>
				<div>
					<iframe src="./user/I-information.php" name="per"></iframe>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<!-- 框架模块结束 -->
		
		<?php require './include/bottom.php'; ?>
	</body>
</html>