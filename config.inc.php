<?php
/**************************************************************************************
 ***  说明：项目统一配置文件
 ***  作者：赵兴壮
 ***  日期：2012-08-12
 *************************************************************************************/

 //配置项=>配置值
 return array(

        'DB_TYPE'   => 'pgsql', // 数据库类型
        'DB_HOST'   => '127.0.0.1', // 服务器地址
        'DB_NAME'   => 'IPCCS', // 数据库名
        'DB_USER'   => 'postgres', // 用户名
        'DB_PWD'    => '201671zhuang', // 密码
        'DB_PORT'   => 5432, // 端口
        'DB_PREFIX' => 'cb_', // 数据库表前缀  
		'DB_CHARSET'=>'utf8',		 //数据库字符集编码
		'DEFAULT_TIMEZONE'=>'PRC',   // 设置默认时区为新加坡
		'TMPL_L_DELIM'=>'{',
	    'TMPL_R_DELIM'=>'}',
		'URL_HTML_SUFFIX'=>'.shtml',
	    'URL_CASE_INSENSITIVE' =>  true,//去掉URL的大小写区分问题
	    'TMPL_ACTION_ERROR'  => 'Public:success', //错误提示模版
	    'TMPL_ACTION_SUCCESS' => 'Public:success', //正确提示模版
	    'APP_DEBUG'=>true,
		//'SHOW_PAGE_TRACE'=>true    

		 'DB_CONFIG2' => 'pgsql://postgres:123456@192.168.1.128:5432/IPCCS',//用户：密码@host：端口/数据库
	);

?>
