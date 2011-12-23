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
class SetModel  extends IrelaModel {
	 protected $_link = array (
		'list' => array (
			'mapping_type' => HAS_MANY,
			'class_name' => 'Set_list',
			'foreign_key' => 'sid',
			'mapping_name' => 'list'
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
		'sid' => array (
			't' => 'input',
			'v' => 0,
		),
		'name' => array (
			't' => 'input',
			'v' => '',
		),
		'title' => array (
			't' => 'input',
			'v' => '',
		),
		'status' => array (
			't' => 'input',
			'v' => 1,
		),
		'stype' => array (
			't' => 'input',
			'v' => 2,
		),
		'list' => array (
			't' => 'relation_many',
			'mpk' => 'id',
			'mtb' => '',
			'v' => array (
				'sid' => array (
					't' => 'input',
					'v' => ''
				),
				'value' => array (
					't' => 'input',
					'v' => ''
				),
				'label' => array (
					't' => 'input',
					'v' => ''
				)
			)
		),
	);
	protected $_validate = array (
		array (
			'name',
			'require',
			'设置名称不能为空'
		),
		array (
			'name',
			'',
			'设置名称已经存在!',
			1,
			'unique',
			1
		),
		array (
			'name',
			'/^[a-z_]{3,16}$/i',
			'设置名称只能为字母下划线组成!',
			1,
			'regex',
			1
		),
		array (
			'title',
			'require',
			'标签不能为空'
		)
	);

	
	public function getTree($reset = 0){
		$tdata = S('Set');
		if (empty($tdata) || $reset != 0) {
			$datalist = $this->select();
			$mlist = M('Set_list');
			$list = $mlist->select();
			$tdata = array();
			foreach($datalist as $v){
				$tdata[$v['name']] = array();
				foreach($list as $lv){
					if($v['sid'] == $lv['sid']){
						$tdata[$v['name']][$lv['value']] = $lv['label'];
					}
				}
			}
			S('Set', $tdata);
		}
		
		return $tdata;
	}
}
?>