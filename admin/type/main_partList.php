<!DOCTYPE html>
<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>主要内容区main</title>
		<link href="../../public/admin/css/css/css.css" type="text/css" rel="stylesheet" />
		<link href="../../public/admin/css/css/main.css" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="../../public/admin/images/main/favicon.ico" />
		<style>
			body{overflow-x:hidden; background:#f2f0f5; padding:15px 0px 10px 5px;}
			#searchmain{ font-size:12px;}
			#search{ font-size:12px; background:#548fc9; margin:10px 10px 0 0; display:inline; width:100%; color:#FFF}
			#search form span{height:40px; line-height:40px; padding:0 0px 0 10px; float:left;}
			#search form input.text-word{height:24px; line-height:24px; width:180px; margin:8px 0 6px 0; padding:0 0px 0 10px; float:left; border:1px solid #FFF;}
			#search form input.text-but{height:24px; line-height:24px; width:55px; background:url(../../public/admin/images/main/list_input.jpg) no-repeat left top; border:none; cursor:pointer; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#666; float:left; margin:8px 0 0 6px; display:inline;}
			#search a.add{ background:url(../../public/admin/images/main/add.jpg) no-repeat 0px 6px; padding:0 10px 0 26px; height:40px; line-height:40px; font-size:14px; font-weight:bold; color:#FFF}
			#search a:hover.add{ text-decoration:underline; color:#d2e9ff;}
			#main-tab{ border:1px solid #eaeaea; background:#FFF; font-size:12px;}
			#main-tab th{ font-size:12px; background:url(../../public/admin/images/main/list_bg.jpg) repeat-x; height:32px; line-height:32px;}
			#main-tab td{ font-size:12px; line-height:40px;}
			#main-tab td a{ font-size:12px; color:#548fc9;}
			#main-tab td a:hover{color:#565656; text-decoration:underline;}
			.bordertop{ border-top:1px solid #ebebeb}
			.borderright{ border-right:1px solid #ebebeb}
			.borderbottom{ border-bottom:1px solid #ebebeb}
			.borderleft{ border-left:1px solid #ebebeb}
			.gray{ color:#dbdbdb;}
			td.fenye{ padding:10px 0 0 0; text-align:right;}
			.bggray{ background:#f9f9f9}
			#addinfo{ padding:0 0                                                  10px 0;}
			input.text-word{ width:50px; height:24px; line-height:20px; border:#ebebeb 1px solid; background:#FFF; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; text-align:center; color:#666}
			.tda{width:100px;}
			.tdb{ padding-left:20px;}
			td#xiugai{ padding:10px 0 0 0;}
			td#xiugai input{ width:100px; height:40px; line-height:30px; border:none; border:1px solid #cdcdcd; background:#e6e6e6; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#969696; float:left; margin:0 10px 0 0; display:inline; cursor:pointer; font-size:14px; font-weight:bold;}
		</style>
	</head>
	<body>
		<!--main_top-->
		<form method="post" action="">
			<table width="99%" border="0" cellspacing="0" cellpadding="0" id="searchmain">
				<tr>
					<td width="99%" align="left" valign="top" id="addinfo">您的位置：板块管理 &nbsp; > &nbsp; 板块列表</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
							<tr>
								<th align="center" valign="middle" class="borderright tda">绝对ID</th>
								<th align="center" valign="middle" class="borderright tda">分类树</th>
								<th align="center" valign="middle" class="borderright tda">略缩图</th>
								<th align="center" valign="middle" class="borderright">栏目名</th>
								<th align="center" valign="middle">栏目管理</th>
							</tr>
							<?php
								$SQL = "select *,concat(path,'-',id) as absPath,(select count(*) from types as t2 where t2.pid=t1.id) as sCount,(select count(*) from post as t3 where t3.tid=t1.id) as postCount from types as t1 order by absPath";
								$result = mysqli_query($link,$SQL);
								while($info = mysqli_fetch_assoc($result)){
									$id = $info['id'];
									$name = $info['name'];
									$pid = $info['pid'];
									$path = $info['path'];
									$sCount = $info['sCount'];
									//$info['ico'];
									if($pid == 0){
							?>
										<!-- 大类目录 -->
										<tr class="bggray">
											<td align="center" valign="middle" class="borderright borderbottom"><input type="text" name="" class="text-word" value="<?php echo $id; ?>"></td>
											<td align="left" valign="middle" class="borderright borderbottom tdb"><img src="../../public/admin/images/main/dirfirst.gif" width="15" height="13"></td>
											<td align="center" valign="middle" class="borderright borderbottom">
												<img src="" alt="" />
											</td>
											<td align="left" valign="middle" class="borderright borderbottom tdb"><?php echo $name; ?></td>
											<td align="center" valign="middle" class="borderbottom">
												<a href="./main_addPart.php?pid=<?php echo $id; ?>&pname=<?php echo $name; ?>" target="mainFrame" onFocus="this.blur()" class="add">添加子板块</a>
												<span class="gray">&nbsp;|&nbsp;</span>
												<a href="./main_modifySection.php?id=<?php echo $id; ?>&name=<?php echo $name; ?>" target="mainFrame" onFocus="this.blur()" class="add">修改</a>
												<?php 
													if($sCount > 0){
													
													}else{
												?>
													<span class="gray">&nbsp;|&nbsp;</span>
													<a href="./doDelType.php?id=<?php echo $id ?>" target="mainFrame" onFocus="this.blur()" class="add">删除</a>
												<?php
													}
												?>
											</td>
										</tr>
								  <?php
									}else{
								  ?>			
										<!-- 子类目录 -->
										<tr>
											<td align="center" valign="middle" class="borderright borderbottom"><input type="text" name="" class="text-word" value="<?php echo $id; ?>"></td>
											<td align="left" valign="middle" class="borderright borderbottom tdb"><img src="../../public/admin/images/main/dirsecond.gif" width="29" height="29"></td>
											<td align="center" valign="middle" class="borderright borderbottom">
												<img src="../../public/update/admin/partico/<?php echo $info['ico'];?>" alt="" style="width:50px;height:50px;"/>
											</td>
											<td align="left" valign="middle" class="borderright borderbottom tdb"><?php echo $name; ?></td>
											<td align="center" valign="middle" class="borderbottom">
												<a href="../post/main_postList.php?typeId=<?php echo $id; ?>" target="mainFrame" onFocus="this.blur()" class="add">查看帖子<?php echo empty($info['postCount']) ?  '' : "({$info['postCount']})" ;?></a>
												<!--<span class="gray">&nbsp;|&nbsp;</span>
												<a href="add.html" target="mainFrame" onFocus="this.blur()" class="add">修改</a>-->
											<?php
												if($info['postCount'] > 0){
												
												}else{
											?>
												<span class="gray">&nbsp;|&nbsp;</span>
												<a href="./doDelType.php?id=<?php echo $id ?>" target="mainFrame" onFocus="this.blur()" class="add">删除</a>
											<?php
												}
											?>
											</td>
										</tr>
							<?php
					  
									}  
								}
							?>
						</table>	
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>