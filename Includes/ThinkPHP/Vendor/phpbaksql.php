<?php
ini_set("max_execution_time", "180"); //避免数据量过大，导出不全的情况出现。

/*

程序功能：mysql数据库备份功能
作者：唐小刚
说明：
本程序主要是从mysqladmin中提取出来，并作出一定的调整，希望对大家在用php编程时备份数据有一定帮助.
如果不要备份结构：请屏掉这句:echo   get_table_structure($dbname,   $table,   $crlf).";$crlf$crlf";
如果不要备份内容：请屏掉这句:echo   get_table_content($dbname,   $table,   $crlf);

修改者：何锦盛
修改时间：2009/11/7
修改内容：新增函数get_table_structure，注释掉了函数get_table_def，目的是获得更丰富的建表时的细节（如：ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品信息变更信息'）
*/

$host = "localhost"; //数据库地址
$dbname = $_GET['dbname']; //这里配置数据库名
$username = $_GET['username']; //用户名
$passw = $_GET['password']; //这里配置密码

$filename = date("Y-m-d_H-i-s") . "-" . $dbname . ".sql";
header("Content-disposition:filename=" . $filename); //所保存的文件名
header("Content-type:application/octetstream");
header("Pragma:no-cache");
header("Expires:0");

//备份数据
$i = 0;
$crlf = "\r\n";
global $dbconn;
$dbconn = mysql_connect($host, $username, $passw); //数据库主机，用户名，密码
$db = mysql_select_db($dbname, $dbconn);
mysql_query("SET NAMES 'utf8'");
$tables = mysql_list_tables($dbname, $dbconn);
$num_tables = @ mysql_numrows($tables);
print "-- filename=" . $filename;
while ($i < $num_tables) {
	$table = mysql_tablename($tables, $i);
	print $crlf;
	echo get_table_structure($dbname, $table, $crlf) . ";$crlf$crlf";
	//echo   get_table_def($dbname,   $table,   $crlf).";$crlf$crlf";
	echo get_table_content($dbname, $table, $crlf);
	$i++;
}

/*新增的获得详细表结构*/
function get_table_structure($db, $table, $crlf) {
	global $drop;

	$schema_create = "";
	if (!empty ($drop)) {
		$schema_create .= "DROP TABLE IF EXISTS `$table`;$crlf";
	}
	$result = mysql_db_query($db, "SHOW CREATE TABLE $table");
	$row = mysql_fetch_array($result);
	$schema_create .= $crlf . "-- " . $row[0] . $crlf;
	$schema_create .= $row[1] . $crlf;
	Return $schema_create;
}

//获得表内容
function get_table_content($db, $table, $crlf) {
	$schema_create = "";
	$temp = "";
	$result = mysql_db_query($db, "SELECT   *   FROM   $table");
	$i = 0;
	while ($row = mysql_fetch_row($result)) {
		$schema_insert = "INSERT INTO `$table` VALUES   (";
		for ($j = 0; $j < mysql_num_fields($result); $j++) {
			if (!isset ($row[$j]))
				$schema_insert .= " NULL,";
			elseif ($row[$j] != "") $schema_insert .= " '" . addslashes($row[$j]) . "',";
			else
				$schema_insert .= " '',";
		}
		$schema_insert = ereg_replace(",$", "", $schema_insert);
		$schema_insert .= ");$crlf";
		$temp = $temp . $schema_insert;
		$i++;
	}
	return $temp;
}
?>