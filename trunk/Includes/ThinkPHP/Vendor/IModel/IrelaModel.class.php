<?php
// +----------------------------------------------------------------------
// | LULUUI [ Lulu COMPANY WEB SHOW]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.luluui.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: uuleaf <uuleaf@163.com>
// +----------------------------------------------------------------------
class IrelaModel extends RelationModel {
	//相关分类模型
	public $cate_set = array();
	public $fields_inc = array();
	//+++++++---------------------------SHARE START------------------------------------+++++++
	//过滤设置
	public $qmap = array (
		//查询数组
		'q' => array (),
		//排序
	'o' => array (
			'oby' => '',
			'okey' => 'desc'
		),
		//分页
	'p' => 0,
		//条数
	'ps' => 20,
		//关联
	'r' => true,
		'a' => array ()
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
	 * 备注：relation 两种形式
	 *	   relation_one一对一关联
	 *     relation_many一对多关联
	 +----------------------------------------------------------
	 * @throws none
	 +----------------------------------------------------------
	 */
	public $fields_set = array (
		//		'classroom_id' => array (
	//			't' => 'input',
	//			'v' => 0
	//		),
	//		'created' => array (
	//			't' => 'function',
	//			'v' => 'time'
	//		),
	//		'status' => array (
	//			't' => 'select',
	//			'v' => 1
	//		),
	//		'detail' => array (
	//			't' => 'text',
	//			'v' => ''
	//		),
	//		'bos' => array (
	//			't' => 'relation_one',
	//			'mpk' => 'id',
	//			'mtb' => '',
	//			'oid' => 'bos_id',
	//			'v' => array (
	//				'bos_id' => array (
	//					't' => 'input',
	//					'v' => ''
	//				),
	//				'bos_name' => array (
	//					't' => 'input',
	//					'v' => ''
	//				)
	//			)
	//		),
	//		'student' => array (
	//			't' => 'relation_many',
	//			'mpk' => 'id',
	//			'oid' => 'company_id',
	//			'mtb' => '',
	//			'v' => array (
	//				'school_id' => array (
	//					't' => 'input',
	//					'v' => ''
	//				),
	//				'company_id' => array (
	//					't' => 'input',
	//					'v' => ''
	//				)
	//			)
	//		)
	);
	/**
	 +----------------------------------------------------------
	 * 获得过滤条件
	 * 使用之前必须在model中定义$fields_set设置
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param int $map
	 +----------------------------------------------------------
	 * @return array
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	public function initQmap($map = array ()) {
		$DbFields = $this->getDbFields();
		if (!empty ($map)) {
			if (isset ($map['q']))
				$this->qmap['q'] = $map['q'];
			if (isset ($map['p']))
				$this->qmap['p'] = $map['p'];
			if (isset ($map['ps']))
				$this->qmap['ps'] = $map['ps'];
			if (isset ($map['r']))
				$this->qmap['r'] = $map['r'];
			if (isset ($map['o']))
				$this->qmap['o'] = $map['o'];
			if (empty ($this->qmap['o']['oby']))
				$this->qmap['o']['oby'] = $this->getPk();
		} else {
			//生成查询条件
			foreach ($DbFields as $key => $val) {
				if (isset ($_GET[$val]) && $_GET[$val] != '') {
					$this->qmap['q'][$val] = $_GET[$val];
				}
			}

			if (isset ($_GET['oby']) && $_GET['oby'] != '') {
				if (isset ($_GET['okey']) && $_GET['okey'] != '') {
					$this->qmap['o'] = array (
						'oby' => $_GET['oby'],
						'okey' => $_GET['okey'],
						'auto' => true
					);
				} else {
					$this->qmap['o'] = array (
						'oby' => $_GET['oby'],
						'okey' => 'desc',
						'auto' => true
					);
				}
			} else {
				$this->qmap['o'] = array (
					'oby' => $this->getPk(),
					'okey' => 'desc',
					'auto' => false
				);
			}
			if (isset ($_GET['ps']) && $_GET['ps'] != '') {
				$this->qmap['ps'] = $_GET['ps'];
			}

			if (isset ($_GET['p']) && $_GET['p'] != '') {
				$this->qmap['p'] = $_GET['p'];
			}
		}
		if (empty ($this->qmap['o']['oby']))
			$this->qmap['o']['oby'] = $this->getPk();
		//cate处理
		if (!empty ($this->cate_set)) {
			foreach ($this->cate_set as $ck => $cvo) {
				if (isset ($this->qmap['q'][$cvo])) {
					$mcate = D(ucfirst(strtolower($ck)));
					if (method_exists($mcate, 'getPath')) {
						$catemap = $mcate->getPath($this->qmap['q'][$cvo]);
						unset ($this->qmap['q'][$cvo]);
						$this->qmap['q'] = array_merge($this->qmap['q'], $catemap);
					}
				}
			}
		}
		foreach($this->qmap['q'] as $k => $vo){
			if(!in_array($k,$DbFields)) unset($this->qmap['q'][$k]);
		}
	}
	public function getQmap() {
		return $this->qmap;
	}

	/**
	 +----------------------------------------------------------
	 * 获得过滤表单数据
	 * 使用之前必须在model中定义$fields_set设置
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param int $type 表单类型：1为新建 2为更新
	 +----------------------------------------------------------
	 * @return array
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	public function getForm($type = 1, $rela = true) {
		import("ORG.Util.Input");
		$mdata = array ();
		$pkey = $this->getPk();
		foreach ($this->fields_set as $cname => $cset) {
			switch ($cset['t']) {
				case 'relation_one' :
					if ($rela == false)
						break;
					$tdata = isset ($_POST[$cname]) ? $_POST[$cname] : null;
					if (empty ($tdata))
						break;
					$mdata[$cname] = array ();
					foreach ($cset['v'] as $crname => $crset) {
						switch ($crset['t']) {
							case 'function' :
								$mdata[$cname][$crname] = isset ($tdata[$crname]) ? $tdata[$crname] : $crset['v'] ();
								break;
							case 'select' :
							case 'input' :
							case 'text' :
							default :
								$mdata[$cname][$crname] = isset ($tdata[$crname]) ? Input :: getVar(trim($_POST[$cname][$crname])) : $crset['v'];
								break;
						}
						if ($crname == $pkey) {
							if ($type == 1) { //如果是新增，删除主键
								$mdata[$cname][$crname] = '';
							}
						}
					}
					break;
				case 'relation_many' :
					if ($rela == false)
						break;
					$tdata = isset ($_POST[$cname]) ? $_POST[$cname] : null;
					if (empty ($tdata))
						break;
					$mdata[$cname] = array ();
					foreach ($tdata as $k => $vo) {
						$mdata[$cname][$k] = array ();
						foreach ($cset['v'] as $crname => $crset) {
							switch ($crset['t']) {
								case 'function' :
									$mdata[$cname][$k][$crname] = isset ($vo[$crname]) ? $vo[$crname] : $crset['v'] ();
									break;
								case 'select' :
								case 'input' :
								case 'text' :
								default :
									$mdata[$cname][$k][$crname] = isset ($vo[$crname]) ? Input :: getVar(trim($_POST[$cname][$k][$crname])) : $crset['v'];
									break;
							}
							if ($crname == $pkey) {
								if ($type == 1) { //如果是新增，删除主键
									$mdata[$cname][$k][$crname] = '';
								}
							}
						}
					}
					break;
				case 'function' :
					$mdata[$cname] = isset ($_POST[$cname]) ? Input :: getVar(trim($_POST[$cname])) : $cset['v'] ();
					//如果更新，更新中无字段则删除
					if ($type == 2) {
						if (!isset ($_POST[$cname]))
							unset ($mdata[$cname]);
					}
					break;
				case 'select' :
				case 'input' :
				case 'text' :
				default :
					$mdata[$cname] = isset ($_POST[$cname]) ? Input :: getVar(trim($_POST[$cname])) : $cset['v'];
					//如果更新，更新中无字段则删除
					if ($type == 2) {
						if (!isset ($_POST[$cname]))
							unset ($mdata[$cname]);
					}
					break;
			}
		}
		if ($type == 1) {
			$mdata[$pkey] = '';
		}
		return $mdata;
	}

	public function getData($datainfo, $type = 1, $rela = true) {
		$tdata = array ();
		foreach ($this->fields_set as $field => $field_set) {
			switch ($field_set['t']) {
				case 'function' :
					$tdata[$field] = isset ($datainfo[$field]) ? $datainfo[$field] : $field_set['v'] ();
					break;
				case 'select' :
				case 'input' :
				case 'text' :
					$tdata[$field] = isset ($datainfo[$field]) ? $datainfo[$field] : $field_set['v'];
					break;
				default :
					if ($rela && isset ($datainfo[$field]))
						$tdata[$field] = $datainfo[$field];
			}
			if ($type != 1) {
				if (!isset ($datainfo[$field]))
					unset ($tdata[$field]);
			}
		}

		return $tdata;
	}

	/**
	 +----------------------------------------------------------
	 * 获得过滤数据
	 * 使用之前必须在model中定义$fields_set设置
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param int $map
	 +----------------------------------------------------------
	 * @return array
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */

	public function doGet($qmap = null) {
		$this->initQmap($qmap);
		//dump($this->qmap);
		$dlist = array (
			'list' => null,
			'page' => null
		);

		//排序字段 默认为主键名
		if (empty ($this->qmap['q'])) {
			$count = $this->count($this->getPk());
		} else {
			$count = $this->where($this->qmap['q'])->count();
		}

		$voList = array ();
		if ($count > 0) {
			//如果没有设置分页
			if ($this->qmap['p'] == -1) {
				if (empty ($this->qmap['q'])) {
					if ($this->qmap['r']) {
						$voList = $this->relation($this->qmap['r'])->order("`" . $this->qmap['o']['oby'] . "` " . $this->qmap['o']['okey'])->findAll();
					} else {
						$voList = $this->order("`" . $this->qmap['o']['oby'] . "` " . $this->qmap['o']['okey'])->findAll();
					}
				} else {
					if ($this->qmap['r']) {
						$voList = $this->relation($this->qmap['r'])->where($this->qmap['q'])->order("`" . $this->qmap['o']['oby'] . "` " . $this->qmap['o']['okey'])->findAll();
					} else {
						$voList = $this->where($this->qmap['q'])->order("`" . $this->qmap['o']['oby'] . "` " . $this->qmap['o']['okey'])->findAll();
					}
				}
				$dlist['list'] = $voList;
				return $dlist;
			} else
				if ($this->qmap['p'] == 0) {
					if (empty ($this->qmap['q'])) {
						if ($this->qmap['r']) {
							$voList = $this->relation($this->qmap['r'])->find();
						} else {
							$voList = $this->find();
						}
					} else {
						if ($this->qmap['r']) {
							$voList = $this->relation($this->qmap['r'])->where($this->qmap['q'])->find();
						} else {
							$voList = $this->where($this->qmap['q'])->find();
						}
					}
					$this->autoInc($voList[$this->getPk()]);
					return $voList;
				} else {
					$p = $this->qmap['p'];
					$ps = $this->qmap['ps'];
					$page = initPage($count, $p, $ps);
					if (empty ($this->qmap['q'])) {
						if ($this->qmap['r']) {
							$voList = $this->relation($this->qmap['r'])->order("`" . $this->qmap['o']['oby'] . "` " . $this->qmap['o']['okey'])->limit($ps)->page($p)->findAll();
						} else {
							$voList = $this->order("`" . $this->qmap['o']['oby'] . "` " . $this->qmap['o']['okey'])->limit($ps)->page($p)->findAll();
						}
					} else {
						if ($this->qmap['r']) {
							$voList = $this->relation($this->qmap['r'])->where($this->qmap['q'])->order("`" . $this->qmap['o']['oby'] . "` " . $this->qmap['o']['okey'])->limit($ps)->page($p)->findAll();
						} else {
							$voList = $this->where($this->qmap['q'])->order("`" . $this->qmap['o']['oby'] . "` " . $this->qmap['o']['okey'])->limit($ps)->page($p)->findAll();
						}
					}
					$page['par'] = '';
					//echo $this->getlastsql();
					//分页跳转的时候保证查询条件
					foreach ($this->qmap['q'] as $key => $val) {
						if (!is_array($val)) {
							$page['par'] .= "$key=" . urlencode($val) . "&";
						}
					}
					foreach ($this->qmap['o'] as $key => $val) {
						if (!is_array($val)) {
							$page['par'] .= "$key=" . urlencode($val) . "&";
						}
					}
				}
			$dlist = array (
				'list' => $voList,
				'page' => $page
			);
			return $dlist;
		} else {
			$this->error = '无数据';
			return false;
		}
	}

	public function doPost($data = null, $rela = true) {
		if (empty ($data)) {
			$data = $this->getForm(1);
		} else {
			$data = $this->getData($data, 1, true);
		}
		//dump($data);
		if ($rela) {
			if (!$this->relation($rela)->create($data)) {
				$this->error = $this->getError();
				return false;
			}
			$rs = $this->relation($rela)->add($data);
			if (!$rs)
				$this->error = $this->getLastSql();
			return $rs;
		} else {
			if (!$data = $this->create($data)) {
				$this->error = $this->getError();
				return false;
			}
			$rs = $this->add($data);
			if (!$rs)
				$this->error = $this->getLastSql();
			return $rs;
		}
	}

	public function doPut($data = null, $rela = true) {

		if (empty ($data)) {
			$data = $this->getForm(2);
		} else {
			$data = $this->getData($data, 2, $rela);
		}
		$mpk = $this->getPk();
		if (!isset ($data[$mpk])) {
			$this->error = '无主键';
			return false;
		}
		$map[$mpk] = $data[$mpk];
		if (!$this->where($map)->find()) {
			$this->error = '无数据';
			return false;
		}
		foreach ($this->fields_set as $cname => $cset) {
			switch ($cset['t']) {
				case 'relation_one' :
				case 'relation_many' :
					if (isset ($data[$cname])) {
						$rs = $this->putRela($cname, $map[$mpk], $data[$cname], true);
						if ($rs) {
							unset ($data[$cname]);
						} else {
							return false;
						}
					}
			}
		}

		if (count($data) > 1) {
			$data = $this->create($data);
			$rs = $this->where($map)->save($data);
			if (!$rs)
				$this->error = 'error:' . $this->getLastSql();
			return $rs;
		} else {
			return true;
		}
	}
	/**
	 +----------------------------------------------------------
	 * 关联删除
	 * 根据主键，可删除多个
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param int $oidfield 顺序字段
	 +----------------------------------------------------------
	 * @return boolean
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */

	public function doDel($qmap = null, $rela = true) {
		$tmap = array ();
		$mpk = $this->getPk();
		$tmap[$mpk] = isset ($_POST[$mpk]) ? $_POST[$mpk] : 0;
		if (empty ($qmap))
			$qmap = $tmap;
		if (empty ($qmap)) {
			$this->error = L('_SELECT_NOT_EXIST_');
			return false;
		}
		if (!is_array($qmap[$mpk])) {
			$data = explode(",", $qmap[$mpk]);
			if (count($data) > 1)
				$qmap[$mpk] = $data;
		}

		$this->startTrans();
		if (is_array($qmap[$mpk])) {
			foreach ($qmap[$mpk] as $v) {
				$map[$mpk] = $v;
				if ($rela != false) {
					if (!$this->relation($rela)->delete($v)) {
						$this->error = L('_SELECT_NOT_EXIST_');
						$this->rollback();
						return false;
					}
				} else {
					if (!$this->where($map)->delete()) {
						$this->error = L('_SELECT_NOT_EXIST_');
						$this->rollback();
						return false;
					}
				}
			}

		} else {
			$map[$mpk] = $qmap[$mpk];
			if ($rela != false) {
				if (!$this->relation($rela)->delete($map[$mpk])) {
					$this->error = L('_SELECT_NOT_EXIST_');
					$this->rollback();
					return false;
				}
			} else {
				if (!$this->delete($map[$mpk])) {
					$this->error = L('_SELECT_NOT_EXIST_');
					$this->rollback();
					return false;
				}
			}
		}
		$this->commit();
		return true;
	}
	public function autoInc($mpk_val){
		if(empty($mpk_val)) return false;
		$map[$this->getPk()] = $mpk_val;
		if(!empty($this->fields_inc)){
			foreach($this->fields_inc as $k=>$v){
				$this->setInc($k,$map,$v);
			}
		}
		return true;
	}
	//+++++++---------------------------SHARE END------------------------------------+++++++

	/**
	 +----------------------------------------------------------
	 * 设置关联数据
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param $r _link中关联mapname $mpk_val关联主键,$data关联数据，$delmark修改关联是否清空
	 +----------------------------------------------------------
	 * @return array
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	public function putRela($r = null, $mpk_val = null, $data = null, $delmark = false) {

		$mpk_field = $this->getPk();
		if (empty ($mpk_val))
			$mpk_val = isset ($_POST[$mpk_field]) ? trim($_POST[$mpk_field]) : $mpk_val;
		if (empty ($r) || empty ($mpk_val)) {
			$this->error = '无关联主键';
			return false;
		}
		if (!isset ($this->fields_set[$r])) {
			$this->error = '错误关联类型' . $r;
			return false;
		}
		if (empty ($data)) {
			$tdata = $this->getForm(2, true);
			$data = $tdata[$r];
		}

		$rmodelname = ucfirst(strtolower($this->_link[$r]['class_name']));
		if (empty ($rmodelname)) {
			$this->error = '未定义关联表';
			return false;
		}

		$subm = M($rmodelname);
		$main_mpk = $mpk_field;
		$sub_mpk = empty($this->fields_set[$r]['mpk'])? $subm->getPk():$this->fields_set[$r]['mpk'];
		$this->startTrans();
		
		if ($this->fields_set[$r]['t'] == 'relation_one') {
			$data[$main_mpk] = $mpk_val;
			if (!empty ($data[$sub_mpk])) {
				$map[$sub_mpk] = $data[$sub_mpk];
				if (isset ($data[$sub_mpk]))
					unset ($data[$sub_mpk]);
				$rs = $subm->where($map)->save($data);
			} else {
				if (!$rs = $subm->add($data)) {
					$this->error = 'error2:' . $subm->getLastSql();
					$this->rollback();
					return false;
				}
			}
		} else {
			if ($delmark) {
				$tsubkeys = array();
				foreach($data as $vo){
					if (!empty ($vo[$sub_mpk])){
						$tsubkeys[] = $vo[$sub_mpk];
					}
				}
				$tsubmap[$main_mpk] = $mpk_val;
				if(!empty ($tsubkeys)){
					$tsubmap[$sub_mpk]  = array('not in',implode(",", $tsubkeys));
				}
				$subm->where($tsubmap)->delete();
			}
			
			foreach ($data as $vo) {
				$vo[$main_mpk] = $mpk_val;
				if (!empty ($vo[$sub_mpk])) {
					$map[$sub_mpk] = $vo[$sub_mpk];
					if (isset ($vo[$sub_mpk]))
						unset ($vo[$sub_mpk]);
					$rs = $subm->where($map)->save($vo);
				} else {
					if (!$rs = $subm->add($vo)) {
						$this->error = 'error2:' . $subm->getLastSql();
						$this->rollback();
						return false;
					}
				}
			}
		}
		$this->commit();
		return true;
	}

	/**
	 +----------------------------------------------------------
	 * 取得n条多对多关联相关记录
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param Str $r _link中关联mapname $mpk_val关联主键,$qmap 附加条件
	 +----------------------------------------------------------
	 * @return array
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	public function getRela($r = null, $mpk_val = null, $qmap = null) {
		$rs = array (
			'list' => null,
			'page' => null
		);
		$mpk_field = $this->getPk();
		if (empty ($mpk_val))
			$mpk_val = isset ($_POST[$mpk_field]) ? trim($_POST[$mpk_field]) : $mpk_val;
		if (empty ($r) || empty ($mpk_val)) {
			$this->error = '无主键';
			return false;
		}
		if (!isset ($this->fields_set[$r])) {
			$this->error = '错误关联';
			return false;
		}
		$rmodelname = $this->getModelName() . '_' . strtolower($this->_link[$r]['class_name']);
		$subm = M($rmodelname);
		$main_mpk = $mpk_field;
		$sub_mpk = $subm->getPk();
		$p = 0;
		$ps = 20;
		if (isset ($qmap['p'])) {
			$p = $qmap['p'];
			unset ($qmap['p']);
		}
		if (isset ($qmap['ps'])) {
			$ps = $qmap['ps'];
			unset ($qmap['ps']);
		}
		//直接关联
		$order = empty ($this->fields_set[$r]['oid']) ? $sub_mpk : $this->fields_set[$r]['oid'];
		if (isset ($this->fields_set[$r]['mtb']) && $this->fields_set[$r]['mtb'] == '') {
			$qmap[$mpk_field] = $mpk_val;
			if ($p) {
				$count = $subm->where($qmap)->count();
				$page = initPage($count, $p, $ps);
				$list = $subm->where($qmap)->order($order . ' asc')->limit($ps)->page($p)->select();
				$rs['list'] = $list;
				$rs['page'] = $page;
			} else {
				$list = $subm->where($qmap)->order($order . ' asc')->select();
				$rs['list'] = $list;
			}
			//间接关联
		} else {
			$subrm = M(ucfirst(strtolower($this->fields_set[$r]['mtb'])));
			$subr_mpk = $subrm->getPk();
			$subtb = $subm->getTableName();
			$subrtb = $subrm->getTableName();
			if ($p) {
				$count = $subm->where($qmap)->count();
				$page = initPage($count, $p, $ps);
				$list = $this->table($subrtb . ' a')->join('inner join ' . $subtb . ' b on a.' . $subr_mpk . '=b.' . $subr_mpk)->field('a.*,b.' . $main_mpk)->limit($ps)->page($p)->select();
				$rs['list'] = $list;
				$rs['page'] = $page;
			} else {
				$list = $this->table($subrtb . ' a')->join('inner join ' . $subtb . ' b on a.' . $subr_mpk . '=b.' . $subr_mpk)->field('a.*,b.' . $main_mpk)->select();
				$rs['list'] = $list;
			}
		}
		return $rs;
	}
	/**
	 +----------------------------------------------------------
	 * 清空某个关联部分所有数据
	 +----------------------------------------------------------
	 * @access public 
	 +----------------------------------------------------------
	 * @param int $r关联部分
	 *        int $mpk 主键号
	 *        array $qmap附加查询
	 +----------------------------------------------------------
	 * @return array
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	public function delRela($r, $mpk_val, $qmap = array ()) {
		$mpk_field = $this->getPk();
		$rmodelname = $this->_link[$r]['class_name'];
		$model = M($rmodelname);
		$rtable = $this->getModelName() . '_' . strtolower($this->_link[$r]['class_name']);
		$rmpk_field = $model->getPk();
		$mpk_id = isset ($_POST[$mpk_field]) ? trim($_POST[$mpk_field]) : $mpk_val;
		$mq = D($rtable);
		if (!$mpk_id)
			return false;
		$map[$mpk_field] = $mpk_id;
		if (!empty ($qmap)) {
			foreach ($qmap as $key => $val) {
				$map[$key] = $val;
			}
		}
		if (!$rs = $mq->where($map)->delete()) {
			return false;
		}
		return true;
	}
	
}
?>