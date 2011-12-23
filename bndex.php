<?php
// +----------------------------------------------------------------------
// | LuluCWS [ COMPANY WEB SHOW]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.luluui.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: uuleaf <uuleaf@163.com>
// +----------------------------------------------------------------------
// 定义ThinkPHP框架路径
define('THINK_PATH', 'Includes/ThinkPHP');
//定义项目名称和路径
define('APP_NAME', 'DYjiyin');
define('APP_PATH', './DYjiyin');
// 加载框架入口文件 
require(THINK_PATH."/ThinkPHP.php");
//实例化一个网站应用实例
$App = new App(); 
//应用程序初始化
$App->run();
?>

