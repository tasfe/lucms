<?php

// +----------------------------------------------------------------------
// | LuluCWS [ Lulu COMPANY WEB SHOW]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.luluui.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: uuleaf <uuleaf@163.com>
// +----------------------------------------------------------------------
class DownloadModel extends IbaseModel {
	/**
	 +----------------------------------------------------------
	 * 字段设置数组
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param none
	 +----------------------------------------------------------
	 * @return none
	 * '字段名称' => array();
	 * t 字体类型 ：input text function select relation
	 * v 默认值
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	public $fields_set = array (
		'download_id' => array (
			't' => 'input',
			'v' => 0
		),
		'name' => array (
			't' => 'input',
			'v' => ''
		),
		'path' => array (
			't' => 'input',
			'v' => ''
		),

		'created' => array (
			't' => 'function',
			'v' => 'time'
		),
		'oid' => array (
			't' => 'input',
			'v' => 0
		)
	);

	/**
	 +----------------------------------------------------------
	 * 自动验证
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param none
	 +----------------------------------------------------------
	 * @return none
	 +----------------------------------------------------------
	 * @throws none
	 +----------------------------------------------------------
	 */
	protected $_validate = array (
		array (
			'name',
			'',
			'相同文件名称已经存在！',
			0,
			'unique',
			1
		)
	);

}
?>