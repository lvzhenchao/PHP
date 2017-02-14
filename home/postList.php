<!DOCTYPE html>
<?php
	require '../public/config.php';
	require '../public/func.php';
	webSwitch(WEBSWITCH);
	//require '../configDB/configdb.php';
	require './include/head.php';
	
	date_default_timezone_set('PRC');
	if(isset($_GET['typeId'])){
		$typeId = $_GET['typeId'];
	}else{
		header('location:./index.php');
	}
	//连接数据库
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	//从post表中查询本版块基本信息，总帖数
	$SQLI = "select count(*) as count,tid from post where tid={$typeId}";
	$resultI = mysqli_query($link,$SQLI);
	$countI = mysqli_fetch_assoc($resultI);
	//检索当前板块信息，版块名，略缩图，所属父类（大区）ID
	$SQLType = "select name,ico,pid from types where id={$typeId}";
	$SQLTypeResult = mysqli_fetch_assoc(mysqli_query($link,$SQLType));
		//$SQLTypeResult['name'] 本版块名称 $SQLTypeResult['name'] 本版块略缩图 $SQLTypeResult['pid'] 当前版块所属区域ID
	//检索大区信息
	$SQLSection = "select name from types where id={$SQLTypeResult['pid']}";
	$resultSection = mysqli_fetch_assoc(mysqli_query($link,$SQLSection));
		//$resultSection['name'] 大区名
	//搜索/分页设置
		//搜索设置
	if(isset($_GET['search'])){
		//SQL语句条件配置
		$search = " and title like '%{$_GET['search']}%'";
		//字符串设置
		$url = "&search={$_GET['search']}";
	}else{
		$search = '';
		$url = '';
	}
		//检查page
	if(isset($_GET['page'])){
		$nowPage = $_GET['page'];
	}else{
		$nowPage = 1;
	}
		//设置遍历开始条数
	$items = 2;
	$startI = ($nowPage - 1) * $items;
		//上一页设置
	if($nowPage > 1){
		$prevPage = $nowPage - 1;
	}else{
		$prevPage = 1;
	}
		//下一页设置
	$SQLC = "select count(*) as count from post where recycle='0'{$search}";
	$resultC = mysqli_query($link,$SQLC);
	$infoC = mysqli_fetch_assoc($resultC);
	$iCount = $infoC['count'];
	$maxPage = ceil($iCount / $items);
	if($nowPage >= $maxPage){
		$nextPage = $maxPage;
	}else{
		$nextPage = $nowPage + 1;
	}
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
		<div class="guide">
			<img src="../public/home/images/home.gif.png" />
			<a href="./index.php" >LAMP兄弟连</a>
			<span>&gt;</span>
			<a href="#" ><?php echo $resultSection['name']; ?></a>
			<span>&gt;</span>
			<?php echo $SQLTypeResult['name']; ?>
		</div>
		<div id="tec">
			<div>
				<h6><?php echo $SQLTypeResult['name']; ?></h6>
				<div id="tecHead">
					<img style="width:57px;height:57px;border:1px solid #CCCCCC;"src="../public/update/admin/partico/<?php echo $SQLTypeResult['ico']; ?>" />
					<div>
						<span>今日:</span>
						<span>1</span>
						<span>|</span>
						<span>主题:</span>
						<span>1</span>
						<span>|</span>
						<span>贴数:</span>
						<span><?php echo $countI['count']; ?></span>
					</div>
					<div>
						<span>PHP基础编程、疑难解答、学习和开发过程中的经验总结等。</span>
					</div>
				</div>
				<div class="tecDaohang">
					<div>
						<a href="./postList.php?typeId=<?php echo $typeId ?><?php echo $url ?>&page=1">首页</a>
					</div>
					<div>
						<a href="./postList.php?typeId=<?php echo $typeId ?><?php echo $url ?>&page=<?php echo $prevPage ?>">上一页</a>
					</div>
					<div>
						<a href="./postList.php?typeId=<?php echo $typeId ?><?php echo $url ?>&page=<?php echo $nextPage ?>">下一页</a>
					</div>
					<div>
						<a href="./postList.php?typeId=<?php echo $typeId ?><?php echo $url ?>&page=<?php echo $maxPage ?>">尾页</a>
					</div>
					<form method="get" action="./postList.php" >
						<input type="text" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ; ?>" placeholder="请输入搜索内容"/>
						<input type="hidden" name="typeId" value="<?php echo $typeId ?>" />
						<input type="hidden" name="page" value="<?php echo $nowPage ?>" />
						<button type="submit" >搜索</button>
					</form>
			<?php
				if(isset($_SESSION['id'])){
			?>
					<form method="post" action="./publishPost.php" >
						<input type="hidden" name="typeId" value="<?php echo $typeId; ?>"/>
						<input type="submit" value="发帖"/>
					</form>
			<?php
				}
			?>
				
				</div>
			</div>
			<table id="iftetable">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>标题</th>
						<th>作者</th>
						<th>回复/浏览</th>
						<th>最后发表</th>
					</tr>
				</thead>
				<tbody>
				<?php
				//遍历post表下所有tid为此版块的帖子条件（不为回收站，以置顶-时间倒序排列）
				$SQL = "select * from post where tid={$typeId}{$search} and recycle='0' order by top desc,ctime desc limit {$startI},{$items}";
				$result = mysqli_query($link,$SQL);
				while($info = mysqli_fetch_assoc($result)){
					//帖子的Id
					$postId = $info['id'];
					//发帖人的ID
					$uid = $info['uid'];
					//查找此发帖人的昵称、头像
						$SQLUNameForDEeail = "select name,photo from userDetail where id={$uid}";
						$reUNameForDetail = mysqli_query($link,$SQLUNameForDEeail);
						$infoUNameForDetail = mysqli_fetch_assoc($reUNameForDetail);
						$uForPostName = $infoUNameForDetail['name'];
						$uForPostPhoto = $infoUNameForDetail['photo'];
					$title = $info['title'];
					$content = $info['content'];
					//发帖时间
					$ctime = date('Y-m-d H:i',$info['ctime']);
					$count = $info['count'];
					$elite = $info['elite'];
					$top = $info['top'];
				?>
					<tr>
						<td>
							<?php echo $elite == 0 && $top == 0 ? '<img src="../public/home/images/topicnew.gif" />' : '' ;?>
							<?php echo $elite == 0 ? ' ' : '<img src="../public/home/images/topichot.gif" />' ;?>
							<?php echo $top == 0 ? ' ' : '<img src="../public/home/images/headtopic_3.gif" />' ;?>
						</td>
						<td>
							<span><a href="./post.php?postId=<?php echo $postId; ?>&typeId=<?php echo $typeId; ?>"><?php echo $title; ?></a></span>
						</td>
						<td>
							<span><?php echo $uForPostName; ?></span> <br />
							<span><?php echo $ctime; ?></span>
						</td>
						<td>
							<span>158/239717</span>
						</td>
						<td>
							<span>leisheng</span> <br />
							<span>昨天 16:00</span>
						</td>
					</tr>
				<?php
					}
				?>
				</tbody>
			</table>
			<div class="tecDaohang">
				<div>
					<a href="./postList.php?typeId=<?php echo $typeId ?><?php echo $url ?>&page=1">首页</a>
				</div>
				<div>
					<a href="./postList.php?typeId=<?php echo $typeId ?><?php echo $url ?>&page=<?php echo $prevPage; ?>">上一页</a>
				</div>
				<div>
					<a href="./postList.php?typeId=<?php echo $typeId ?><?php echo $url ?>&page=<?php echo $nextPage; ?>">下一页</a>
				</div>
				<div>
					<a href="./postList.php?typeId=<?php echo $typeId ?><?php echo $url ?>&page=<?php echo $maxPage; ?>">尾页</a>
				</div>
			<?php
				if(isset($_SESSION['id'])){
				//echo $_SESSION['id'];
			?>
				<form method="post" action="./publishPost.php" >
					<input type="hidden" name="typeId" value="<?php echo $typeId; ?>"/>
					<input type="submit" value="发帖"/>
				</form>
			<?php
				}
			?>
			</div>
		</div>
		<?php
			require './include/bottom.php';
		?>
	</body>
</html>