<?php
return array(
	'SYS_VERSION' => 'Preview预览版',
	//数据库缓存
	'DB_FIELDS_CACHE'=>false,
	'DB_LIKE_FIELDS'=>'name|path|title|detail|content|local',
	'TMPL_TEMPLATE_SUFFIX'=>'.html',//模板扩展名
	
	'DEFAULT_MODULE'=>'Index',
	'DEFAULT_THEME'=>'default', 
	
	//文件上传路径
	'UPLOADS_PATH'=>'Uploads/',
	//文件略缩图片路径
	'UPLOADS_THUMB'=>'Uploads/_thumbs/',
	//如果你的环境不支持PATHINFO 请设置为3
    //'URL_MODEL'=>1, 
	//'URL_ROUTER_ON'=>false,//路由设置
	//'URL_CASE_INSENSITIVE'=>true,
	//'URL_DISPATCH_ON'=>true, 
	//'URL_HTML_SUFFIX'=>'.html',
	//'URL_MODEL'=>1, 
	//'URL_PATHINFO_MODEL'=>2, 
	//'URL_PATHINFO_DEPR'=>'/', 
);
?>