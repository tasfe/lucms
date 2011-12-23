<?php


//'last|L'(结尾规则)
//'nocase|NC'(忽略大小写)
/*replacement
RewriteRule ^index.html$ index\.php/Index/index\.html [QSA,PT,L]
RewriteRule ^product.html$ index\.php/Product/index\.html [QSA,PT,L]
RewriteRule ^product-([0-9]+)\.html$ index\.php/Good/Category/path/c$1c\.html [QSA,PT,L]
 */
return array (
	
	array (
		'url_out' => "",
		'pattern' => "index.php"
	),
	//模块
	array (
		'url_out' => "",
		'pattern' => "/Index/index.html"
	),
	array (
		'url_out' => "",
		'pattern' => "/Index/"
	),

	array (
		'url_out' => "product",
		'pattern' => "/Product/"
	),
	//action
	array (
		'url_out' => ".html",
		'pattern' => "index.html"
	),
	array (
		'url_out' => "/",
		'pattern' => "index/"
	),
	array (
		'url_out' => "/view-",
		'pattern' => "view/"
	),
	//参数
	array (
		'url_out' => "/cate-",
		'pattern' => "cate_id/"
	),
	array (
		'url_out' => "/id-",
		'pattern' => "product_id/"
	),
	array (
		'url_out' => "id-",
		'pattern' => "news_id/"
	),
	array (
		'url_out' => "p-",
		'pattern' => "p/"
	),
	array (
		'url_out' => "ps-",
		'pattern' => "ps/"
	),
	array (
		'url_out' => "o-",
		'pattern' => "oby/"
	),
	array (
		'url_out' => "",
		'pattern' => "okey/desc"
	),
	array (
		'url_out' => "ok-asc",
		'pattern' => "okey/asc"
	)
	
);
?>