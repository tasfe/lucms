<?php
class MbasecateAction extends MbaseAction {
	public $tbname = '';
	public $obj = '';
	public $mpk = '';
	public function index() {
		$datalist = $this->obj->doGet();
		$this->assign('datalist', $datalist);
		$this->display();
	}
	public function edit(){
		$mpk_val = isset ($_GET[$this->mpk]) ? $_GET[$this->mpk] : 0;
		if (!$mpk_val)
			$this->error('无数据', 0);
		$datalist = $this->obj->doGet();
		$this->assign('datainfo',$datalist[$mpk_val]);
		$this->display();
	}
	public function selector() {
		$datalist = $this->obj->doGet();
		$this->assign('datalist', $datalist);
		$this->display('selector');
	}
	public function mselector() {
		$datalist = $this->obj->doGet();
		$this->assign('datalist', $datalist);
		$this->display('mselector');
	}
	public function getCateTree($reset = 0) {
		$tcateher = array ();
		if (S(MODULE_NAME.'s') && $reset == 0) {
			$tcateher = S($this->tbname);
		} else {
			Vendor('Soa.SoaApi');
			$tcateher = $this->obj->doGet();
			S(MODULE_NAME.'s', $tcateher);
		}
		dump($tcateher);
		return $tcateher;
	}
}
?>