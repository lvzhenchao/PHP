<!DOCTYPE html>
<?php
	require '../public/config.php';
	require '../public/func.php';
	//require '../configDB/configdb.php';
	webSwitch(WEBSWITCH);
	require './include/head.php';
	$uid = $_SESSION['id'];
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQLForType = "select name,pid from types where id={$_POST['typeId']}";
	$typeInfo = mysqli_fetch_assoc(mysqli_query($link,$SQLForType));
	$SQLForSection = "select name from types where id={$typeInfo['pid']}";
	$SectionInfo = mysqli_fetch_assoc(mysqli_query($link,$SQLForSection));
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
	<div class="guide">
		<img src="../public/home/images/home.gif.png" />
		<a href="./index.php" >LAMP兄弟连</a>
		<span>&gt;</span>
		<a href="#" ><?php echo $SectionInfo['name']; ?></a>
		<span>&gt;</span>
		<a href="#" ><?php echo $typeInfo['name']; ?></a>
		<span>&gt;</span>
		发表帖子
	</div>
	<!-- 帖子编辑块开始 -->
	<form method="post" action="./post/doAddPost.php" />
		<div id="new_page">
			<div><span>分类：<?php echo $typeInfo['name']; ?></span>
			</div>
			<div>
				标题：
				<input style="margin-top:60px;margin-bottom:20px;" type="text" name="title" />
				<input type="checkbox" name="reply" value="1"/>
				是否禁止回复
			</div>
			<textarea id="editor" placeholder="这里输入内容" autofocus name='content'></textarea>
			<div>
				<input type="hidden" name="ctime" value="<?php echo time(); ?>" />
				<input type="hidden" name="typeId" value="<?php echo $_POST['typeId']; ?>" />
				<br />
				<input type="submit" value="确认发帖" />
			</div>
			<div class="clear" ></div>
		</div>
	<form>
	<!-- 帖子编辑块结束 -->
	<?php
		require './include/bottom.php';
	?>
	</body>
</html>