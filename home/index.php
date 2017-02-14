<!DOCTYPE html>
<?php
	require '../public/config.php';
	require '../public/func.php';
	webSwitch(WEBSWITCH);
	//require '../configDB/configdb.php';
?>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo TITLE; ?></title>
		<meta name="keywords" content="<?php echo KEYWORDS; ?>" />
		<meta name="description" content="<?php echo DESCRIPTION; ?>" />
		<link href="../public/home/css/reset200802.css" type="text/css" rel="stylesheet" />
		<link href="../public/home/css/csshome.css" type="text/css" rel="stylesheet" />
		<style>
			body{
				background-color:#F1F2F6;
			}
		</style>
	</head>
	<body>
		<?php
			require './include/head.php';
		?>
		<!-- 大图大块开始 -->
		<div id="bigp">
			<div>
				<a href="#">
					<img src="../public/home/images/20150710055301.jpg" />
				</a>
			</div>
			<div>
				<a href="#">
					<img src="../public/home/images/lampt_1_20140529.jpg" />
				</a>
				<a href="#">
					<img src="../public/home/images/lampt_2_201405291.png" />
				</a>
			</div>
			<div>
				<a href="#">
					<img src="../public/home/images/lampt_3.png.jpg" />
				</a>
				<a href="#">
					<img src="../public/home/images/lampt_4.png.jpg" />
				</a>
			</div>
		</div>
		<!-- 大图大块结束 -->
		
		<!-- 内容大类开始 -->
		<div id="main">
			<!-- 模块子类开始 -->
		<?php
			$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
			mysqli_select_db($link,DATABASE);
			mysqli_set_charset($link,CHARSET);
			$SQL = "select *,concat(path,'-',id) as count,(select count(*) from types as t2 where t2.pid=t1.id) as nSubtype,(select count(*) from post as t3 where t3.tid=t1.id) as postCount from types as t1 order by count";
			$result = mysqli_query($link,$SQL);
			while($info = mysqli_fetch_assoc($result)){
				$sectionId = $info['pid'];
				$name = $info['name'];
				if($sectionId == 0){
					$nSubtype = $info['nSubtype'];
		?>
			<div class="types">
				<div>
					<div>:::.<?php echo $name ?>.:::</div>
				</div>
		<?php
				}else{
				$typeId = $info['id'];
		?>	
				<div class="type">
					<div><img style="width:57px;height:57px;border:1px solid #CCCCCC;"src="../public/update/admin/partico/<?php echo $info['ico']; ?>" /></div>
					<div >
						<div>
							<a href="./postList.php?typeId=<?php echo $typeId; ?>" ><?php echo $name ?></a>
						</div>
						<div class="small">
							<div>帖子 <?php echo $info['postCount']; ?></div>
							<div>主题 10598</div>
							<div>最后发帖:2015-08-21 22:22:22</div>
						</div>
					</div>
				</div>
		<?php
					$nSubtype--;
					if($nSubtype == 0){
		?>
				<div class="clear"></div>
			</div>
		<?php
					}
				}
			}
		?>	
			<!-- 模块子类结束 -->
			<!-- 连接子块开始 -->
			<div id="lian">
				<div>
					<div>友情链接</div>
				</div>
				<div>
					<ul>
						<li>
							<a href="#" >PHP培训</a>
						</li>
						<li>
							<a href="#" >PHP门户</a>
						</li>
						<li>
							<a href="#" >蓝色理想</a>
						</li>
						<li>
							<a href="#" >PHPCMS</a>
						</li>
						<li>
							<a href="#" >五四陈科学院</a>
						</li>
						<li>
							<a href="#" >PS教程网</a>
						</li>
						<li>
							<a href="#" >华章培训</a>
						</li>
						<li>
							<a href="#" >东莞招聘</a>
						</li>
						<li>
							<a href="#" >KING PHP</a>
						</li>
						<li>
							<a href="#" >出国留学</a>
						</li>
						<li>
							<a href="#" >中国网管论坛</a>
						</li>
						<li>
							<a href="#" >PHP know</a>
						</li>
						<li>
							<a href="#" >PHP friend</a>
						</li>
						<li>
							<a href="#" >PHP 美国主机</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- 连接子块结束 -->
			<div id="clear-all"></div>
		</div>
		<!-- 内容大类结束 -->
		<?php
			require './include/bottom.php';
		?>
	</body>
</html>