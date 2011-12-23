<?php


// +----------------------------------------------------------------------
// | LuluUI [ Lulu COMPANY WEB SHOW]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.luluui.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: uuleaf <uuleaf@163.com>
// +----------------------------------------------------------------------
class IcateModel extends IbaseModel {
	public $fields_set = array (
		'cate_id' => array (
			't' => 'input',
			'v' => 0
		),
		'parent_id' => array (
			't' => 'input',
			'v' => 0
		),
		'name' => array (
			't' => 'input',
			'v' => 0
		),
		'ename' => array (
			't' => 'input',
			'v' => 0
		),
		'title' => array (
			't' => 'input',
			'v' => 0
		),
		'keyword' => array (
			't' => 'input',
			'v' => 0
		),
		'detail' => array (
			't' => 'text',
			'v' => ''
		),
		'thumb' => array (
			't' => 'input',
			'v' => ''
		),
		'oid' => array (
			't' => 'input',
			'v' => 0
		)
	);
	public $data = array ();
	public $cateArray = array ();

	public function getPath($cate_id) {
		$tarr = array (
			'cate_1' => 0,
			'cate_2' => 0,
			'cate_3' => 0
		);
		if (empty ($cate_id))
			return $tarr;
		$catelist = $this->getTree();
		if (!isset ($catelist[$cate_id]))
			return $tarr;
		if ($catelist[$cate_id]['layer'] == 0) {
			$tarr['cate_1'] = $cate_id;
		}
		if ($catelist[$cate_id]['layer'] == 1) {
			$tarr['cate_1'] = $catelist[$cate_id]['parent'];
			$tarr['cate_2'] = $cate_id;
		}
		if ($catelist[$cate_id]['layer'] == 2) {
			$tarr['cate_2'] = $catelist[$cate_id]['parent'];
			$tarr['cate_1'] = $catelist[$tarr['cate_2']]['parent'];
			$tarr['cate_3'] = $cate_id;
		}
		return $tarr;
	}
	public function getTree($reset = 0) {
		$tcateher = array ();
		$tcates = $this->order('cate_id asc')->findAll();
		$tallnewinfo = array ();
		$tcateher = array ();
		foreach ($tcates as $cateinfo) {
			$tallnewinfo[$cateinfo[$this->getPk()]] = $cateinfo;
		}
		$allcatelay = $this->getCatelay();
		foreach ($allcatelay as $catelay) {
			$catelay = array_merge($catelay, $tallnewinfo[$catelay[$this->getPk()]]);
			$tcateher[$catelay[$this->getPk()]] = $catelay;
		}
		return $tcateher;
	}

	public function getCatelay() {
		$allcate = $this->field('cate_id,parent_id')->select();
		$this->cateArray = array ();
		foreach ($allcate as $acate) {
			$this->setNode($acate[$this->getPk()], $acate['parent_id'], '');
		}
		$newcates = array ();
		$allarray = $this->getChilds();

		foreach ($allarray as $key => $id) {
			$newcates[$id] = array (
				$this->getPk() => $id,
				'layer' => $this->getLayer($id, '-'),
				'childs' => $this->getChilds($id),
				'parent' => $this->cateArray[$id],
				'str' => $this->getStr($id, '&nbsp;'),
				'parr' => $this->getNodePath($id)
			);
		}
		return $newcates;
	}

	public function setNode($id, $parent, $value) {
		$parent = $parent ? $parent : 0;
		$this->data[$id] = $value;
		$this->cateArray[$id] = $parent;
	}
	public function getChildsTree($id = 0) {
		$childs = array ();
		foreach ($this->cateArray as $child => $parent) {
			if ($parent == $id) {
				$childs[$child] = $this->getChildsTree($child);
			}

		}
		return $childs;
	}
	public function getChilds($id = 0) {
		$childArray = array ();
		$childs = $this->getChild($id);
		foreach ($childs as $child) {
			$childArray[] = $child;
			$childArray = array_merge($childArray, $this->getChilds($child));
		}
		return $childArray;
	}
	public function getChild($id) {
		$childs = array ();
		foreach ($this->cateArray as $child => $parent) {
			if ($parent == $id) {
				$childs[$child] = $child;
			}
		}
		return $childs;
	}
	public function getNodePath($id) {
		$parr = array (
			0,
			0,
			0,
			0,
			0
		);
		$ps = $this->getNodeLever($id);
		$key = 0;
		foreach ($ps as $v) {
			$parr[$key] = $v;
			$key++;
		}
		$parr[$key] = $id;
		return $parr;
	}
	//单线获取父节点
	public function getNodeLever($id) {
		$parents = array ();
		if (key_exists($this->cateArray[$id], $this->cateArray)) {
			$parents[] = $this->cateArray[$id];
			$parents = array_merge($parents, $this->getNodeLever($this->cateArray[$id]));
		}
		return $parents;
	}
	public function getLayer($id, $preStr = '|-') {
		return count($this->getNodeLever($id));
		//return str_repeat($preStr, count($this->getNodeLever($id)));
	}
	public function getStr($id, $preStr = '|-') {
		$layers = count($this->getNodeLever($id));
		if ($layers) {
			return str_repeat('&nbsp; &nbsp; ', $layers) . $preStr;
		} else {
			return;
		}
	}
	public function getValue($id) {
		return $this->data[$id];
	}
//	public function doPost($par) {
//		$data = array ();
//		$data['parent_id'] = empty ($par['parent_id']) ? 0 : $par['parent_id'];
//		$data['name'] = empty ($par['name']) ? '' : $par['name'];
//		$data['oid'] = empty ($par['oid']) ? 0 : $par['oid'];
//		$data['detail'] = empty ($par['detail']) ? '' : $par['detail'];
//		$data['thumb'] = empty ($par['thumb']) ? '' : $par['thumb'];
//		if (empty ($data['name'])) {
//			$this->error = '分类名称不能为空';
//			return false;
//		}
//		if (!$this->create($data)) {
//			return false;
//		}
//		$newkey = $this->add($data);
//		if (!$newkey) {
//			return false;
//		}
//		$map[$this->getPk()] = $newkey;
//
//		$this->getTree(1);
//		return  $data;
//	}
	public function doGet($par) {
		return $this->getTree();
	}
	public function doPut($par) {
		$rs = parent :: doPut($par);
		$this->getTree(1);
		$this->rs = true;
		return true;
	}
	public function doDel($par) {
		$catelist = $this->getTree();
		if (empty ($par[$this->getPk()])) {
			$this->error = '参数错误';
			return false;
		}
		if (isset ($catelist[$par[$this->getPk()]])) {
			if (!empty ($catelist[$par[$this->getPk()]]['childs'])) {
				$this->error = '分类下有子分类，请移除子分类:cate_id=>' . implode(',', $catelist[$par[$this->getPk()]]['childs']);
				return false;
			}
		} else {
			$this->error = '无数据';
			return false;
		}
		$cid = parent :: doDelete($par);
		$this->getTree(1);
		return $cid;
	}
	public function doTree() {
		$datalist = $this->order('oid desc')->select();
		$tree = list_to_tree($datalist, $this->getPk(), 'parent_id', 'childs');
		return $tree;
	}
	public function doList() {
		$datalist = $this->order('oid desc')->select();
		return $datalist;
	}
}
?>