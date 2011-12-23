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
class NewsModel extends IrelaModel {
	//主表News：news_id cate_id cate_1 cate_2 cate_3 name from thumb annex created changed level oid auth_id auth_name 
	//内容表News_text： id news_id summary 	detail 
	/**
	 +----------------------------------------------------------
	 * 关联设置
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param none
	 +----------------------------------------------------------
	 * @return none
	 +----------------------------------------------------------
	 * @throws none
	 +----------------------------------------------------------
	 */
	protected $_link = array (
		'text' => array (
			'mapping_type' => HAS_ONE,
			'class_name' => 'News_text',
			'foreign_key' => 'news_id'
		)
	);
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
		'news_id' => array (
			't' => 'input',
			'v' => 0
		),
		
		'cate_id' => array (
			't' => 'input',
			'v' => 0
		),
		'cate_1' => array (
			't' => 'input',
			'v' => 0
		),
		'cate_2' => array (
			't' => 'input',
			'v' => 0
		),
		'cate_3' => array (
			't' => 'input',
			'v' => 0
		),
		'cate_id' => array (
			't' => 'input',
			'v' => 0
		),
		'name' => array (
			't' => 'input',
			'v' => ''
		),
		'keywords' => array (
			't' => 'input',
			'v' => ''
		),
		'summary' => array (
			't' => 'input',
			'v' => ''
		),
		'from' => array (
			't' => 'input',
			'v' => ''
		),
		'thumb' => array (
			't' => 'input',
			'v' => ''
		),
		'annex' => array (
			't' => 'input',
			'v' => ''
		),
		'level' => array (
			't' => 'select',
			'v' => 1
		),
		'oid' => array (
			't' => 'input',
			'v' => 0
		),
		'created' => array (
			't' => 'function',
			'v' => 'time'
		),
		'changed' => array (
			't' => 'function',
			'v' => 'time'
		),	
		'auth' => array (
			't' => 'input',
			'v' => ''
		),  
		'is_topic' => array (
			't' => 'input',
			'v' => 0
		),
		'text' => array (
			't' => 'relation_one',
			'mpk' => 'id',
			'mtb' => '',
			'v' => array (
				'news_id' => array (
					't' => 'input',
					'v' => ''
				),
				'detail' => array (
					't' => 'text',
					'v' => ''
				)
			)
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
			'相同文章标题已经存在！',
			0,
			'unique',
			1
		)
	);
	/**
	 +----------------------------------------------------------
	 * 自动填充
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
	protected $_auto = array (
		array (
			'level',
			'1'
		),
		// 新增的时候把status字段设置为1
		array (
			'created',
			'time',
			1,
			'function'
		),
		array (
			'changed',
			'time',
			2,
			'function'
		)
	);
	
}
?>