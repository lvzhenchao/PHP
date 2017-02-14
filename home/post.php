<!DOCTYPE html>
<?php
	require '../public/config.php';
	require '../public/func.php';
	webSwitch(WEBSWITCH);
	//require '../configDB/configdb.php';
	//获得此贴id
	if(isset($_GET['postId']) && isset($_GET['typeId'])){
		$postId = $_GET['postId'];
		$typeId = $_GET['typeId'];
	}else{
		header('location:./index.php');
	}
	//设置时区
	date_default_timezone_set('PRC');
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
		//数据库设置
	//require '../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	//检索帖子基本信息
	$SQLPostBase = "select *,(select count(*) from reply where pid={$postId}) as replyCount,(select name from types as t2 where t2.id=t1.tid) as typeName,(select pid from types as t3 where t3.id=t1.tid) as sectionId from post as t1 where id={$postId}";
	$baseInfoPost = mysqli_fetch_assoc(mysqli_query($link,$SQLPostBase));
		//查询结果
		//$baseInfoPost['id'] 帖子ID
		//$baseInfoPost['uid'] 发帖人ID(楼主)
		//$baseInfoPost['tid'] 帖子所属板块ID
		//$baseInfoPost['title'] 帖子标题
		//$baseInfoPost['content'] 帖子内容
		//$baseInfoPost['ctime'] 帖子发表时间
			$postDate = date('Y-m-d H:i',$baseInfoPost['ctime']);
		//$baseInfoPost['count'] 阅读量
		//$baseInfoPost['elite'] 是否精华
			$elites = array('普通','精华');
		//$baseInfoPost['top'] 是否置顶
			$tops = array('普通','置顶');
		//$baseInfoPost['recycle']	是否回收站
			$recycles = array('普通','回收');
		//$baseInfoPost['reply'] 是否允许回复
			$reply = array('允许回复','不允许回复');
		//$baseInfoPost['replyCount'] 回复数量
		//$baseInfoPost['typeName']	所属板块名
		//$baseInfoPost['sectionId'] 所属大区ID
		//查询所属大区名
		$SQLForSectionName = "select name from types where id={$baseInfoPost['sectionId']}";
		$SectionInfo = mysqli_fetch_assoc(mysqli_query($link,$SQLForSectionName));
		//echo $SectionInfo['name']; 所属大区名
		//检索用户相关信息
		$SQLForPostHostUser = "select *,(select score from user as t2 where t2.id=t1.id) as score,(select auth from user where id={$baseInfoPost['uid']}) as PostHostAuth from userDetail as t1 where id={$baseInfoPost['uid']}";
		$PostHostUserInfo = mysqli_fetch_assoc(mysqli_query($link,$SQLForPostHostUser));
		//查询结果
		//$PostHostUserInfo['id'] 发帖人ID
		//$PostHostUserInfo['name']	发帖人昵称
		//$PostHostUserInfo['email'] 发帖人邮箱
		//$PostHostUserInfo['qq'] 发帖人qq
		//$PostHostUserInfo['photo'] 发帖人头像
		//$PostHostUserInfo['info']	发帖人个人签名
		//$PostHostUserInfo['score'] 发帖人积分
		//$PostHostUserInfo['PostHostAuth']	发帖人权限
			$auths = array('会员','管理员');
	//分页设置	
		/*//搜索设置
	if(isset($_GET['search'])){
		//SQL语句条件配置
		$search = " and title like '%{$_GET['search']}%'";
		//字符串设置
		$url = "&search={$_GET['search']}";
	}else{
		$search = '';
		$url = '';
	}*/
		//检查page
	if(isset($_GET['page'])){
		$nowPage = $_GET['page'];
	}else{
		$nowPage = 1;
	}
		//设置遍历开始条数
	$items = 5;
	$startI = ($nowPage - 1) * $items;
		//上一页设置
	if($nowPage > 1){
		$prevPage = $nowPage - 1;
	}else{
		$prevPage = 1;
	}
		//下一页设置
	$SQLC = "select count(*) as count from reply where pid={$postId}";
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
		<a name="top"><div class="guide">
			<img src="../public/home/images/home.gif.png" />
			<a href="./index.php" >LAMP兄弟连</a>
			<span>&gt;</span>
			<a href="./postList.php?typeId=<?php echo $typeId; ?>" ><?php echo $SectionInfo['name']; ?></a>
			<span>&gt;</span>
			<?php echo $baseInfoPost['typeName']; ?>
		</div></a>
		<!-- 主贴开始 -->
		<div id='main_page'>
			<div class="postDaohang">
				<div>
					<a href="./post.php?postId=<?php echo $postId; ?>&page=1&typeId=<?php echo $typeId?>">首页</a>
				</div>
				<div>
					<a href="./post.php?postId=<?php echo $postId; ?>&page=<?php echo $prevPage; ?>&typeId=<?php echo $typeId?>">上一页</a>
				</div>
				<div>
					<a href="./post.php?postId=<?php echo $postId; ?>&page=<?php echo $nextPage; ?>&typeId=<?php echo $typeId?>">下一页</a>
				</div>
				<div>
					<a href="./post.php?postId=<?php echo $postId; ?>&page=<?php echo $maxPage; ?>&typeId=<?php echo $typeId?>">尾页</a>
				</div>
				<?php
					if(isset($_SESSION['id'])){
				?>
				<form action="./publishPost.php" method="post" >
					<input type="hidden" name="typeId" value="<?php echo $baseInfoPost['tid'] ?>" />
					<button type="submit">发帖</button>
					<button type="button" onclick="window.location='#reply'">回复</button>
				</form>
				<?php
					}else{}
				?>
			</div>
			<div id="postTitle">
				<div><?php echo $baseInfoPost['count']; ?><br />阅读</div>
				<div><?php echo $baseInfoPost['replyCount']; ?><br />回复</div>
				<div>
					<span><?php echo $baseInfoPost['top'] == 1 ? '<span style="clocr:red;">[置顶]</span>' : '' ; echo $baseInfoPost['elite'] == 1 ? '<span style="clocr:red;">[精华]</span>' : '' ;  echo $baseInfoPost['title'] ;echo $baseInfoPost['reply'] == 0 ? '' : '<span style="clocr:red;">[此贴禁止回复]</span>' ;?></span>
				</div>
			</div>
			<!-- 帖子正文 -->
		<?php
			
			if($nowPage == 1){
		?>
			<div class="posts">
				<div>
					<div><?php echo $PostHostUserInfo['name']; ?></div>
					<div><img style="width:133px;height:133px;" src="../public/update/home/images/<?php echo $PostHostUserInfo['photo']; ?>" alt="头像"/></div>
					<div>
						身份：<?php echo $auths[$PostHostUserInfo['PostHostAuth']]; ?><br />积分：<?php echo $PostHostUserInfo['score']; ?>
					</div>
				</div>
				<div>
					<div>
						<span>楼主</span>
						<span>发表于:<?php echo date('Y-m-d H:i:s',$baseInfoPost['ctime']); ?></span>
					</div>
					<span><?php echo $baseInfoPost['content']; ?></span>
					<span><?php echo $PostHostUserInfo['info']; ?></span>
				</div>
			</div>
		<?php
			}
		?>
			<!-- 回复遍历 -->
		<?php
			//获得回复贴的信息和回复用户的信息
			$SQLReply = "select *,(select name from userDetail as t2 where t2.id=t1.uid) as reUserName,(select photo from userDetail as t3 where t3.id=t1.uid) as reUserPhoto,(select info from userDetail as t4 where t4.id=t1.uid) as reUserInfo,(select auth from user as t5 where t5.id=t1.uid) as reUserAuth,(select score from user as t6 where t6.id=t1.uid) as reUserScore from reply as t1 where pid={$postId} order by ctime limit {$startI},{$items}";
			$replyResult = mysqli_query($link,$SQLReply);
			$num = $startI;
			//遍历回复贴
			while($replyInfo = mysqli_fetch_assoc($replyResult)){
			//$replyInfo['id'] 回复帖子的ID
			//$replyInfo['uid'] 回复人的ID
			//$replyInfo['pid'] 被回复帖子ID
			//$replyInfo['content'] 回复内容
			//$replyInfo['ctime'] 回复时间
				$replyCTime = date('Y-m-d H:i',$replyInfo['ctime']);
			//$replyInfo['reUserName'] 回复人昵称
			//$replyInfo['reUserPhoto'] 回复人头像
			//$replyInfo['reUserInfo'] 回复人签名
			//$replyInfo['reUserAuth'] 回复人权限
			//$replyInfo['reUserScore'] 回复人积分
		?>
			<div class="posts">
				<div>
					<div><?php echo $replyInfo['uid'] == $baseInfoPost['uid'] ? '<strong style="color:#F60;">[楼主]</strong>'.$replyInfo['reUserName'] : $replyInfo['reUserName'] ; ?></div>
					<div><img style="width:133px;height:133px;" src="../public/update/home/images/<?php echo $replyInfo['reUserPhoto']; ?>" alt="头像"/></div>
					<div>身份：<?php echo $auths[$replyInfo['reUserAuth']]; ?><br />积分：<?php echo $replyInfo['reUserScore'] ?></div>
				</div>
				<div>
					<div>
						<span><?php 
							if($num==0){
								$num++;
							}
							switch($num){
								case 1:
								echo '沙发';
								break;
								case 2:
								echo '板凳';
								break;
								case 3:
								echo '地板';
								break;
								default:
								echo $num."楼";
								break;
							}
							$num++;
						?></span>
						<span>发表于:<?php echo $replyCTime; ?></span>
					</div>
					<span><?php echo $replyInfo['content']; ?></span>
					<span><?php echo $replyInfo['reUserInfo']; ?></span>
				</div>
			</div>
		<?php
			}
		?>
			<div class="postDaohang">
				<div>
					<a href="./post.php?postId=<?php echo $postId; ?>&page=1&typeId=<?php echo $typeId?>">首页</a>
				</div>
				<div>
					<a href="./post.php?postId=<?php echo $postId; ?>&page=<?php echo $prevPage; ?>&typeId=<?php echo $typeId?>">上一页</a>
				</div>
				<div>
					<a href="./post.php?postId=<?php echo $postId; ?>&page=<?php echo $nextPage; ?>&typeId=<?php echo $typeId?>">下一页</a>
				</div>
				<div>
					<a href="./post.php?postId=<?php echo $postId; ?>&page=<?php echo $maxPage; ?>&typeId=<?php echo $typeId?>">尾页</a>
				</div>
				<?php
					if(isset($_SESSION['id'])){
				?>
				<form action="./publishPost.php" method="post" >
					<input type="hidden" name="typeId" value="<?php echo $baseInfoPost['tid'] ?>" />
					<button type="submit">发帖</button>
					<button type="button" onclick="window.location='#reply'">回复</button>
				</form>
				<?php
					}else{}
				?>
			</div>
			<div class="clear"></div>
		</div>
		<!-- 主贴结束 -->
		<?php
			if(isset($_SESSION['id']) && $baseInfoPost['reply'] == 0){
		?>
		<div style="margin:0 auto;width:960px;margin-top:10px;font-size:18px;"><strong>发表回复：</strong></div>
		<!-- 帖子回复编辑块开始 -->
		<a id="reply" >
		<form method="post" action="./post/doReply.php" />
			<div id="postReply">
				
				<div>
					<textarea id="editor" placeholder="这里输入内容" name='content'></textarea>
				</div>
				<div>
					<input type="hidden" name="replyCTime" value="<?php echo time()?>" />
					<input type="hidden" name="postId" value="<?php echo $postId?>" />
					<input type="hidden" name="typeId" value="<?php echo $typeId?>" />
					<br />
					<input type="submit" value="发表回复" />
				</div>
			</div>
		<form>
		</a>
		<a href="#top" ><strong style="position:fixed;right:0px;bottom:200px;border-radius:20px 0 0 20px;padding:20px;text-align:center;font-size:110%;background-color:#E6E9EE;color:#444;box-shadow:0px 0px 6px #757575;">Top</strong></a>
		<!-- 帖子回复编辑块结束 -->
		<?php
			}
			require './include/bottom.php';
		?>
	</body>
</html>