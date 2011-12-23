<?php
class ProductAction extends MbaseAction {
	public $tbname = 'Product';
	public $obj = '';
	public $mpk = 'product_id';
	public function _initialize() {
		parent :: _initialize() ;
		$this->assign('pcates',$this->getCateTree());
		
	}
	public function getCateTree($reset = 0) {
		$tcateher= array();
		if (S('pcates') && $reset == 0) {
			$tcateher = S('pcates');
		} else {
			$mcate = D('Product_cate');
			$tcateher = $mcate->doGet();
			S('pcates',$tcateher);
		}
		return $tcateher;
	}
}
?>