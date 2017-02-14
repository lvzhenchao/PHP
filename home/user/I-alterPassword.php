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
			table tr{
				text-align:right;
			}
			h6{
				color:#666666;
			}
		</style>
	</head>
	<body>
		<?php
			
			session_start();
			if(!isset($_SESSION['id'])){
		?>
				<h6>请在上方登录再试！</h6>
		<?php
			}
			if(isset($_SESSION['p-alterp']) && $_SESSION['p-alterp'] == 'false'){
			unset($_SESSION['p-alterp']);
		?>
			
		<h6>密码修改失败！请重新尝试！@ . @ </h6>
		
		<?php
			}
		?>
		<br />
		<form method="post" action="alterPwd.php">
			<table border="1">
				<tr>
					<td>原　密　码　：</td>
					<td>
						<input type="password" name="oldPasswd" />
					</td>
				</tr>
				<tr>
					<td>新　密　码　：</td>
					<td>
						<input type="password" name="newPasswd" />
					</td>
				</tr>
				<tr>
					<td>确认　密码　：</td>
					<td>
						<input type="password" name="renewPasswd" />
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