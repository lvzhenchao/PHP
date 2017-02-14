<DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link href="../../public/home/css/reset200802.css" type="text/css" rel="stylesheet" />
		<style>
			table{
				height:150px;
				width:300px;
			}
		</style>
	</head>
	<body>
	<?php
		
		session_start();
		if(!isset($_SESSION['id'])){
	?>
			<h6>请在右上方登录再试！</h6>
	<?php
		}
		if(isset($_SESSION['p-alteri']) && $_SESSION['p-alteri'] == 'false'){
		unset($_SESSION['p-alteri']);
	?>
		
	<h6>信息修改失败！请重新尝试！@ . @ </h6>
	
	<?php
		}
	?>
		<br />
		<form method="post" action="./alterInf.php">
			<table border="1">
				<tr>
					<td>昵　称　：</td>
					<td>
						<input type="text" name="userName" />
					</td>
				</tr>
				<tr>
					<td>邮　箱　：</td>
					<td>
						<input type="text" name="email" />
					</td>
				</tr>
				<tr>
					<td>Q　Q　：</td>
					<td>
						<input type="text" name="QQ" />
					</td>
				</tr>
				<tr>
					<td>资料</td>
					<td>
						<textarea name="info"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="确认修改" />
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>