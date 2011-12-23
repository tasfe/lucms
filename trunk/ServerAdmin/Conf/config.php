<?php
$configdir = dirname(dirname(dirname(__FILE__))).'/Config/';
$config_global = require $configdir.'/config_global.php';
$config_app = require $configdir.'/config.php';
$array=array(
	'APP_DEBUG'				=> false, 	// 是否开启调试模式
	'TMPL_CACHE_ON'			=> false,   //关闭模板缓存 
	'TOKEN_ON' => false,
	'DB_FIELDS_CACHE'=>false,
	'SHOW_RUN_TIME'=>false,       // 运行时间显示
	'SHOW_ADV_TIME'=>false,          // 显示详细的运行时间
	'SHOW_DB_TIMES'=>false,         // 显示数据库查询和写入次数
	'SHOW_CACHE_TIMES'=>false,     // 显示缓存操作次数
	'SHOW_USE_MEM'=>false,          // 显示内存开销
	
	'DATA_CACHE_TYPE'=> 'File',
	'DATA_CACHE_TIME' => 1,
	
	//'DEFAULT_THEME' => 'dwz',
	//'URL_MODEL' => 0,
	//'URL_DISPATCH_ON' => false,
	
	
);
return array_merge($config_global,$config_app,$array);
?>