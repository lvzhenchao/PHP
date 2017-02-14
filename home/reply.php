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
        <link rel="stylesheet" type="text/css" href="./include/editor/styles/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="./include/editor/styles/simditor.css" />
        <link rel="stylesheet" type="text/css" href="./include/editor/styles/simditor-emoji.css" />
        <script type="text/javascript" src="./include/editor/scripts/jquery.min.js"></script>
        <script type="text/javascript" src="./include/editor/scripts/module.js"></script>
        <script type="text/javascript" src="./include/editor/scripts/uploader.js"></script>
        <script type="text/javascript" src="./include/editor/scripts/simditor.js"></script>
        <script type="text/javascript" src="./include/editor/scripts/simditor-emoji.js"></script>
        <script type="text/javascript" src="./include/editor/scripts/config.js"></script>
		<link href="../public/home/css/reset200802.css" type="text/css" rel="stylesheet" />
		<link href="../public/home/css/csshome.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<?php
			require './include/head.php';
			var_dump($_POST);
			//$tid = $_POST['tid'];
			$uid = $_SESSION['id'];
		?>
		<div class="guide">
			<img src="../public/home/images/home.gif.png" />
			<a href="./index.php" >LAMP兄弟连</a>
			<span>&gt;</span>
			<a href="#" >技术交流</a>
			<span>&gt;</span>
			<a href="#" >回复帖子</a>
		</div>
		<!-- 帖子编辑块开始 -->
		<form method="post" action="./post/doReply.php" />
			<div id="new_page">
				<div><span>分类：PHP技术交流</span></div>
				<div></div>
				<div>
					内容：
					<textarea id="editor" placeholder="这里输入内容" autofocus name='content'></textarea>
				</div>
				<div>
					<input type="hidden" name="ctime" value="<?php echo time(); ?>" />
					<input type="hidden" name="tid" value="<?php echo $tid; ?>" />
					<input type="submit" value="确认回复" />
				</div>
			</div>
		<form>
		<!-- 帖子编辑块结束 -->

		<?php
			require './include/bottom.php';
		?>
	</body>
</html>