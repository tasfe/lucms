<?php
// +----------------------------------------------------------------------
// | LuluUI[ Lulu COMPANY WEB SHOW]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.luluui.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: uuleaf <uuleaf@163.com>
// +----------------------------------------------------------------------
class IbaseAction extends Action {
	public $mtb = '';
	public $rela = false;
	public function _initialize() {
		$this->mtb = empty($this->mtb)? $this->getActionName():$this->mtb;
		$mmodel = D($this->mtb);
		$this->assign('_mpk', $mmodel->getPk());
		$this->assign('_mpk_val', $_GET[$mmodel->getPk()]);
	}
	public function index($re = false){
		$m = D($this->mtb);
		$datalist = $m->doGet();
		$datalist = $mmodel->getFilter();
		$modellist = $datalist['list'];
		$modelpage = $datalist['page'];
		$this->assign('datalist', $modellist);
		$this->assign('page', $modelpage);
		if ($re)
			return $datalist;
		$this->display();
	}
	public function create(){
		if (!$this->isPost()) {
			$this->display();
		} else {
			$m = D($this->mtb);
			$this->assign('jumpUrl', __URL__);
			$rs = $m->doPost(null,$this->rela);
			if($rs){
				$this->success('添加成功',$rs);
			}else{
				$this->error($m->getError(),1);
			}
		}
	}
	public function edit($re = false){
		$m = D($this->mtb);
		$mpk = $m->getPk();
		if (isset ($_GET[$mpk])) {
			$id = $_GET[$mpk];
		}
		if (isset ($_POST[$mpk])) {
			$id = $_POST[$mpk];
		}
		$qmap = array(
			'q' => array(
				$mpk => $id
			),
			'p' => 0,
			'r' => $this->rela
		);
		$data = $m->doGet($qmap);
		import("ORG.Util.Input");
		if ($data) {
			foreach ($data as $key => $val) {
				if (is_array($val)) {
					foreach ($val as $skey => $sval) {
						$data[$key][$skey] = Input :: forTag($sval);
					}
				} else {
					$data[$key] = Input :: forTag($val);
				}
			}
		}
		$this->assign('datainfo', $data);
		if ($re) {
			return $data;
		}
		$this->display();
	}
	public function show(){
		$this->edit(1);
		$this->display();
	}
	public function update(){
		if (!$this->isPost()) {
			$this->error('无权限', 1);
			return;
		} else {
			$mmodel = D($this->mtb);
			$this->assign('jumpUrl', __URL__);
			$rs = $mmodel->doPut(null,$this->rela);
			if($rs){
				$this->success('修改成功',$rs);
			}else{
				$this->error($m->getError(),1);
			}
		}
	}
	public function delete(){
		if (!$this->isPost()) {
			$this->error('ERROR DATA', 1);
			return;
		} else {
			$mmodel = D($this->mtb);
			$rs = $mmodel->doDel(null,$this->rela);
			if($rs){
				$this->success('删除成功',$rs);
			}else{
				$this->error($m->getError(),1);
			}
		}
	}
}
?>