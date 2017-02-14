<?php
	require '../../configDB/configdb.php';
	session_start();
	$uid = $_SESSION['id'];
	$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
	mysqli_select_db($link,DATABASE);
	mysqli_set_charset($link,CHARSET);
	$SQL = "select photo from userDetail where id={$uid}";
	$uPhoto = mysqli_fetch_assoc(mysqli_query($link,$SQL))['photo'];

?>
<DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link href="../../public/home/css/reset200802.css" type="text/css" rel="stylesheet" />
		<style>
			table{
				height:200px;
				width:400px;
			}
			table tr{
				text-align:right;
			}
			table tr:nth-of-type(2){
				height:100px;
			}
			#headP{
				border:1px solid #CCCCCC;
				width:55px;
				height:55px;
			}
			#portP{
				border:1px solid #CCCCCC;
				width:133px;
				height:133px;
			}

		</style>
	</head>
	<body>
		<form method="post" action="alterHPor.php" enctype="multipart/form-data">
			<table border="1">
				<tr>
					<td>上　传　头　像　：</td>
					<td>
						<input type="file" name="hP" />
					</td>
				</tr>
				<tr>
					<td>
						<img  src="../../public/update/home/images/<?php echo $uPhoto; ?>" alt="头像预览" id="headP"/>
						<br />
						<img  src="../../public/update/home/images/<?php echo $uPhoto; ?>" alt="头像预览" id="portP"/>
					</td>
					<td>
						<input type="submit" value="确认修改" />
					</td>
				</tr> 
			</table>
		</form>
	</body>
</html>