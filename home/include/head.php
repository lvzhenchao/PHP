<?php
	require '../configDB/configdb.php';
?>
		<!-- 标题大块开始 -->
		<div id="ti">
			<!-- 标题1 顶连接块开始 -->
			<div>
				<div>
					<div style="font-size:12px;">
						<a href="#">设为首页</a>
						<a href="#">收藏LAMP兄弟连</a>
					</div>
					<div style="font-size:12px;">
						<a href="#">搜索</a>
						<a href="#">统计排行</a>
						<a href="#">会员列表</a>
						<a href="#">社区服务</a>
						<a href="#">精华区</a>
						<a href="#">最新帖子</a>
						<a href="#">社区应用</a>
						<a href="#">推广连接</a>
						<a href="#">帮助</a>
					</div>
				</div>
			</div>
			<!-- 标题1 顶连接块结束 -->
			
			<!-- 标题2 LOGO、登录块开始 -->
			<div>
				<!-- LOGO块开始 -->
				<!-- LOGO1-XDL -->
				<div id="ti-logo">
					<image src="../public/update/admin/webico/<?php echo WEBLOGO ?>" />
				</div>
				<!-- LOGO2-无兄弟、不编程 -->
				<div>
					<image src="../public/home/images/wxdbjc.gif" />
				</div>
				<!-- LOGO块结束 -->
				
				<!-- 登录块开始 -->
				<?php 
					//启用SESSION
					session_start();
					if(isset($_SESSION['id'])){
						$id = $_SESSION['id'];
						//查询用户信息
						$link = mysqli_connect(LOCALHOST,USER,PASSWORD);
						
						
						mysqli_select_db($link,DATABASE);
						mysqli_set_charset($link,CHARSET);
						//查询用户信息
						$SQL = "select auth,score,(select name from userDetail where id='{$id}') as name,(select photo from userDetail where id='{$id}') as photo from user where id='{$id}'";
						$result = mysqli_query($link,$SQL);
						if($info = mysqli_fetch_assoc($result)){
							$score = $info['score'];
							$auths = array('会员','高贵的管理员');
							$auth = $info['auth'];
							$userName = $info['name'];
							$userPhoto = $info['photo'];
				?>
				<div>
					<div id="ti-login">
						<img src="../public/update/home/images/<?php echo $userPhoto; ?>" alt="用户头像" />
						<div><a href="./userInfo.php">欢迎回来，<?php echo $userName ?></a></div>
						<div>积分：<?php echo $score; ?></div>
						<div><?php echo $auths[$auth] ?></div>
						<a href="./include/logout.php">退出登录</a>
						<div class="clear"></div>
					</div>
				</div>			
				<?php
						}else{
							//查询失败
						}
					}else{
				?>
				<div>
					<form method="post" action="./include/doLogin.php">
						<!-- 点击块开始 -->
						<div id="ti-input">
							<div>
								<input type="checkbox" name="rem" value="yes" />
								记住密码
								
							</div>
							<div>
								<a href="#">找回密码</a>
							</div>
							<div>
								<button type="submit" >登录</button>
							</div>
							<div>
								<button type="button" onclick="window.location='./register.php'">注册</button>
							</div>
						</div>
						<!-- 点击块结束 -->
						<!-- 输入块开始 -->
						<div id="input-text">
							<input type="text" name="userName" />
							<input type="password" name="passwd" />				
						</div>
						<!-- 输入块结束 -->
						<div class="clear"></div>
					</form>
				</div>
				<?php
					}
				?>
				<!-- 登录块结束 -->
			</div>
			<!-- 标题2 LOGO、登录块结束 -->
			
			<!-- 标题3 导航块开始 -->
			<div>
				<div>
					<a href="#" >技术交流</a>
					<a href="#" >兄弟连</a>
					<a href="#" >连队趣事</a>
					<a href="#" >议事厅</a>
					<div class="clear"></div>
				</div>
			</div>
			<!-- 标题3 导航快结束 -->
		</div>
		<!-- 标题大块结束 -->