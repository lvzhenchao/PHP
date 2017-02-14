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
		<div id="reg">
			<img src="../public/home/images/logo.png" />
		</div>
		<div>
			<div>注册</div>
			<hr />
			<div>
				<div >带红色*的都是必填项目，若填写不全将无法注册</div>
				<div id="biaodan">
					<form method="post" action="./include/doReg.php">
						<table>
							<tr>
								<td>用户名<span> * </span></td>
								<td>
									<input type="text" name="userName" />
								</td>
							</tr>
							<tr>
								<td>密码<span> * </span></td>
								<td>
									<input type="password" name="passwd" />
								</td>
							</tr>
							<tr>
								<td>确认密码<span> * </span></td>
								<td>
									<input type="password" name="repasswd" />
								</td>
							</tr>
							<tr>
								<td>电子邮箱<span> * </span></td>
								<td>
									<input type="text" name="email" />
								</td>
							</tr>
							<tr>
								<td>验证码<span> * </span></td>
								<td>
									<input type="text" name="code" />
									<img style= "width:100px;"src="../public/code.php" />
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="checkbox" name="read" value="yes"/>我已阅读并完全同意 <a href="#">条款内容</a>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="submit" value="提交注册" />
								</td>
							</tr>
						</table>
						<div id="reded">
							<div>
								<a href="#" >已拥有账号？</a>
							</div>
							<div>
								<button type="button" onclick=window.location="./index.php">马上登陆</button>
							</div>
						</div>
						<div class="clear"></div>
					</form>
				</div>
			</div>
		</div>
		<?php
			require './include/bottom.php';
		?>
	</body>
</html>