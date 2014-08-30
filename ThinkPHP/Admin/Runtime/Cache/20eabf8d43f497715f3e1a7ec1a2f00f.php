<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>MyCMS管理平台</title>
		<meta name='Author' content='' />
	</head>
	     
		<frameset rows='61,*,24' cols='*' framespacing='0' frameborder='no' border='0'>
			<frame src='__APP__/Index/top' name='top' scrolling='no' noresize='noresize' />
			<frameset cols='200, *'>
				<frame src='__APP__/Index/menu' name='menu' noresize='noresize' scrolling='no' />
				<frame src='__APP__/Index/main' name='main' noresize='noresize' scrolling='yes'/>
			</frameset>
			<frame src='__APP__/Index/bottom' name='bottom' scrolling='No' noresize='noresize' />
		</frameset>
</html>