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
class ProductModel extends IrelaModel {
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
		'img' => array(
			'mapping_type' => HAS_MANY,
			'class_name' => 'Product_img',
			'foreign_key' => 'product_id',
			'mapping_name' => 'img',
			'mapping_order' => 'oid asc',
		),
		'attr' => array(
			'mapping_type' => HAS_MANY,
			'class_name' => 'Product_attr',
			'foreign_key' => 'product_id',
			'mapping_name' => 'attr',
			'mapping_order' => 'oid asc',
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
		'product_id' => array (
			't' => 'input',
			'v' => 0
		),
		'cate_id' => array (
			't' => 'input',
			'v' => ''
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
		'name' => array (
			't' => 'input',
			'v' => ''
		),
		'ename' => array (
			't' => 'input',
			'v' => ''
		),
		'thumb' => array (
			't' => 'input',
			'v' => ''
		),
		'attr_1' => array (
			't' => 'input',
			'v' => ''
		),
		'attr_2' => array (
			't' => 'input',
			'v' => ''
		),
		'attr_3' => array (
			't' => 'input',
			'v' => ''
		),
		'attr_4' => array (
			't' => 'input',
			'v' => ''
		),
		'attr_5' => array (
			't' => 'input',
			'v' => ''
		),
		'attr_6' => array (
			't' => 'input',
			'v' => ''
		),
		'attr_7' => array (
			't' => 'input',
			'v' => ''
		),
		'attr_8' => array (
			't' => 'input',
			'v' => ''
		),
		'detail' => array (
			't' => 'text',
			'v' => ''
		),
		'edetail' => array (
			't' => 'text',
			'v' => ''
		),
		
		'created' => array (
			't' => 'function',
			'v' => 'time'
		),
		'changed' => array (
			't' => 'function',
			'v' => 'time'
		),
		'status' => array (
			't' => 'select',
			'v' => 1
		),
		'grade' => array (
			't' => 'select',
			'v' => 1
		),
		'oid' => array (
			't' => 'input',
			'v' => ''
		),
		'img' => array (
			't' => 'relation_many',
			'mpk' => 'id',
			'oid' => 'oid',
			'v' => array (
				'id' => array (
					't' => 'input',
					'v' => ''
				),
				'product_id' => array (
					't' => 'input',
					'v' => ''
				),
				'path' => array (
					't' => 'input',
					'v' => ''
				),
				'intr' => array (
					't' => 'input',
					'v' => ''
				),
				'oid' => array (
					't' => 'input',
					'v' => 0
				),
			)
		),
		'attr' => array (
			't' => 'relation_many',
			'mpk' => 'id',
			'oid' => 'oid',
			'v' => array (
				'id' => array (
					't' => 'input',
					'v' => ''
				),
				'product_id' => array (
					't' => 'input',
					'v' => ''
				),
				'label' => array (
					't' => 'input',
					'v' => ''
				),
				'val' => array (
					't' => 'input',
					'v' => ''
				),
				'oid' => array (
					't' => 'input',
					'v' => 0
				),
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
	protected $_validate = array ();
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
			'status',
			'1'
		),
		// 新增的时候把status字段设置为1
		array (
				'created',
				'time',
				1,
				'function'
		)
		// 对create_time字段在更新的时候写入当前时间戳	

	
	);
}
?>