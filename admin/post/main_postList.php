<!DOCTYPE html>
<?php
	require '../../configDB/configdb.php';
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	date_default_timezone_set('PRC');
	//对应板块列表中的链接
	if(isset($_GET['typeId'])){
		$TypeId = $_GET['typeId'];
	}else{
		$TypeId = '';
	}
	if(isset($_GET['search'])){
			$search = "{$_GET['search']}";
		}else{
			$search = '';
		}
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
#search{ font-size:12px; background:#548fc9; margin:10px 10px 0 0; display:inline; width:100%; color:#FFF; float:left}
#search form span{height:40px; line-height:40px; padding:0 0px 0 10px; float:left;}
#search form input.text-word{height:24px; line-height:24px; width:180px; margin:8px 0 6px 0; padding:0 0px 0 10px; float:left; border:1px solid #FFF;}
#search form input.text-but{height:24px; line-height:24px; width:55px; background:url(../../public/admin/images/main/list_input.jpg) no-repeat left top; border:none; cursor:pointer; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#666; float:left; margin:8px 0 0 6px; display:inline;}
#search a.add{ background:url(../../public/admin/images/main/add.jpg) no-repeat -3px 7px #548fc9; padding:0 10px 0 26px; height:40px; line-height:40px; font-size:14px; font-weight:bold; color:#FFF; float:right}
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
</style>
</head>
<body>
<!--main_top-->
<table width="99%" border="0" cellspacing="0" cellpadding="0" id="searchmain">
  <tr>
    <td width="99%" align="left" valign="top">您的位置：帖子管理&nbsp;&nbsp;>&nbsp;&nbsp;帖子列表</td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="search">
  		<tr>
   		 <td width="90%" align="left" valign="middle">
	         <form method="get" action="./main_postList.php">
	         <span>帖子题目：</span>
	         <input type="text" name="search" value="<?php echo $search; ?>" class="text-word">
	         <input name="" type="submit" value="查询" class="text-but">
	         <input name="" type="reset" value="清空" class="text-but">
	         </form>
         </td>
  		  <td width="10%" align="center" valign="middle" style="text-align:right; width:150px;">&nbsp;</td>
  		</tr>
	</table>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
      <tr>
        <th align="center" valign="middle" class="borderright">编号</th>
        <th align="center" valign="middle" class="borderright">主题</th>
        <th align="center" valign="middle" class="borderright">发帖人</th>
        <th align="center" valign="middle" class="borderright">发表时间</th>
        <th align="center" valign="middle" class="borderright">状态</th>
        <th align="center" valign="middle">操作</th>
      </tr>
	 <?php

		if(isset($_GET['page'])){
			$nowPage = $_GET['page'];
		}else{
			$nowPage = 1;
		}
		function pagesAndSearch($link,$table,$items=8,$nowPage=1,$searchContent='',$searchField='',$order,$TypeId){
			// 从多少条数据开始取值
			$startI = ($nowPage - 1) * $items;
			//组成限制语句
			$limit = "limit {$startI},{$items}";
			//条件
			if(!empty($TypeId)){
				if(!empty($searchContent) && !empty($searchField)){
					$where = "where tid={$TypeId} and {$searchField} like '%{$searchContent}%' and recycle='0'";
					$url = "&search={$searchContent}&typeId={$TypeId}";
				}else{
					$where = "where tid={$TypeId} and recycle='0'";
					$url = "&typeId={$TypeId}";
				}
				
			}else{
				if(!empty($searchContent) && !empty($searchField)){
					$where = "where {$searchField} like '%{$searchContent}%' and recycle='0'";
					$url = "&search={$searchContent}";
				}else{
					$where = "where recycle='0'";
					$url = '';
				}
			}
			//分页/搜索语句拼接
			$SQL =  "select * from {$table} {$where} order by {$order} {$limit}";
			//上一页设置
			if($nowPage > 1){
				$prevPage = $nowPage - 1;
			}else{
				$prevPage = 1;
			}
			//下一页设置
			$SQLC = "select count(*) as count from {$table} {$where}";
			$resultC = mysqli_query($link,$SQLC);
			$infoC = mysqli_fetch_assoc($resultC);
			$iCount = $infoC['count'];
			$maxPage = ceil($iCount / $items);
			if($maxPage == 0){
				$maxPage = 1;
			}
			if($nowPage >= $maxPage){
				$nextPage = $maxPage;
			}else{
				$nextPage = $nowPage + 1;
			}
			//                    上一页页码               下一页页码           搜索的字符串段       总条目数            最大页数           遍历语句   
			$return = array('prevPage' => $prevPage , 'nextPage' => $nextPage , 'addUrl' => $url , 'iCount' => $iCount , 'maxPage' => $maxPage , 'SQL' => $SQL);
			//返回结果数组
			return $return;
		}
		
		$urlPass = "&page={$nowPage}";
		$pageInfo = pagesAndSearch($link,'post',8,$nowPage,$search,'title','ctime desc',$TypeId);
		$SQL = $pageInfo['SQL'];
		$result = mysqli_query($link,$SQL);
		$num = 1;
		$recycles = array('放入回收站','从回收站还原');
		$tops = array('未置顶','已置顶');
		$elites = array('未加精','已加精');
		$replys = array('回复正常','回复已禁止');
		//查询帖子发表人昵称
		while($info = mysqli_fetch_assoc($result)){
			$SQLSU = "select name,(select count(*) from reply as t2 where t2.pid={$info['id']}) as replyCount from userDetail as t1 where id={$info['uid']}";
			$REUname = mysqli_query($link,$SQLSU);
			$Postreply = mysqli_fetch_assoc($REUname);
			$PostUserName = $Postreply['name'];
			$PostreplyCount = $Postreply['replyCount'];
	?>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $num++; ?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $info['title']; ?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $PostUserName; ?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo date('Y/m/d H:i:s',$info['ctime']) ?></td>
        <td align="center" valign="middle" class="borderright borderbottom">
		<a href="./operateSet.php?id=<?php echo $info['id'].'&op=elite'.$urlPass.$pageInfo['addUrl'] ?>" target="mainFrame" onFocus="this.blur()" class="add"><?php echo $elites[$info['elite']] ?></a>
		<span class="gray">&nbsp;|&nbsp;</span>
		<a href="./operateSet.php?id=<?php echo $info['id'].'&op=top'.$urlPass.$pageInfo['addUrl'] ?>" target="mainFrame" onFocus="this.blur()" class="add"><?php echo $tops[$info['top']] ?></a>
		<span class="gray">&nbsp;|&nbsp;</span>
		<a href="./operateSet.php?id=<?php echo $info['id'].'&op=reply'.$urlPass.$pageInfo['addUrl'] ?>" target="mainFrame" onFocus="this.blur()" class="add"><?php echo $replys[$info['reply']] ?></a>
		</td>
        <td align="center" valign="middle" class="borderbottom">
		<a href="main_postModify.php?postId=<?php echo $info['id'].$urlPass.$pageInfo['addUrl'] ?>" target="mainFrame" onFocus="this.blur()" class="add">修改</a>
		<span class="gray">&nbsp;|&nbsp;</span>
		<a href="./operateSet.php?id=<?php echo $info['id'].'&op=recycle'.$urlPass.$pageInfo['addUrl'] ?>" target="mainFrame" onFocus="this.blur()" class="add"><?php echo $recycles[$info['recycle']] ?></a>
		<span class="gray">&nbsp;|&nbsp;</span>
		<a href="./operateSet.php?id=<?php echo $info['id'].'&op=del'.$urlPass.$pageInfo['addUrl'] ?>" target="mainFrame" onFocus="this.blur()" class="add">直接删除</a>
		<?php 	
			if($PostreplyCount > 0){
		?>
		<span class="gray">&nbsp;|&nbsp;</span>
		<a href="main_postInfo.php?postId=<?php echo $info['id'].$urlPass.$pageInfo['addUrl'] ?>" target="mainFrame" onFocus="this.blur()" class="add">管理回复(<?php echo $PostreplyCount; ?>)</a>
		<?php
			}
		?>
		</td>
      </tr>
	<?php
		}
	?>
    </table></td>
    </tr>
  <tr>
    <td align="left" valign="top" class="fenye">
		<?php echo $pageInfo['iCount']; ?>条数据 <?php echo $nowPage; ?>/<?php echo $pageInfo['maxPage'] ?> 页&nbsp;&nbsp;
		<a href="./main_postList.php?page=1<?php echo $pageInfo['addUrl'] ?>" target="mainFrame" onFocus="this.blur()">首页</a>&nbsp;&nbsp;
		<a href="./main_postList.php?page=<?php echo $pageInfo['prevPage'].$pageInfo['addUrl']; ?>" target="mainFrame" onFocus="this.blur()">上一页</a>&nbsp;&nbsp;
		<a href="./main_postList.php?page=<?php echo $pageInfo['nextPage'].$pageInfo['addUrl']; ?>" target="mainFrame" onFocus="this.blur()">下一页</a>&nbsp;&nbsp;
		<a href="./main_postList.php?page=<?php echo $pageInfo['maxPage'].$pageInfo['addUrl']; ?>" target="mainFrame" onFocus="this.blur()">尾页</a>
	</td>
  </tr>
</table>
</body>
</html>










