<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo ($msgTitle); ?></title>

		<style type="text/css">
			body { font: 75% Arail; text-align: center; }
			#notice { width: 300px; background: #FFF; border: 1px solid #BBB; background: #EEE; padding: 3px;
			position: absolute; left: 50%; top: 50%; margin-left: -155px; margin-top: -100px; }
			#notice div { background: #FFF; padding: 30px 0 20px; font-size: 1.2em; font-weight:bold }
			#notice p { background: #FFF; margin: 0; padding: 0 0 20px; }
			a { color: #f00} a:hover { text-decoration: none; }
			
		</style>
	</head>
	<body>
		<div id="notice">
	
			<div style="text-align:left;padding-left:10px;padding-right:10px"><?php echo ($message); ?></div>
			
			<?php if(($status) == "1"): ?>
				<p style="font: italic bold 2cm cursive,serif; color:green">
					ok 
				</p>
			
			<?php elseif(($status)=="0"): ?>
				 <p style="font: italic bold 2cm cursive,serif; color:red">
					x
				</p>
               <?php endif; ?>	
						
				<p >
				页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间 <b id="wait"><?php echo($waitSecond); ?></b>
				</p>
			</div>
				<script type="text/javascript">
				(function(){
				var wait = document.getElementById('wait'),href = document.getElementById('href').href;
				var interval = setInterval(function(){
					var time = --wait.innerHTML;
					(time == 0) && (location.href = href);
				}, 1000);	
				})();
				</script>
	</body>
</html>