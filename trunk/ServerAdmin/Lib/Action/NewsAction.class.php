<?php
class NewsAction extends MbaseAction {
	public $tbname = 'News';
	public $obj = '';
	public $mpk = 'news_id';
	public function _initialize() {
		parent :: _initialize() ;
		$this->assign('ncates',$this->getCateTree());
		
	}
	public function getCateTree($reset = 0) {
		$tcateher= array();
		if (S('ncates') && $reset == 0) {
			$tcateher = S('ncates');
		} else {
			$mcate = D('News_cate');
			$tcateher = $mcate->doGet();
			S('ncates',$tcateher);
		}
		return $tcateher;
	}
}
?>