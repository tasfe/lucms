<?php
class ProductAction extends FbaseAction {
	public $tbname = 'Product';
	public $cate = 'product_cate';
	public $obj = '';
	public $mpk = 'product_id';
	public $map = null;

	public function setMySeo() {
		$cate_id = isset ($_GET['cate_id']) ? trim($_GET['cate_id']) : 0;
		$attr_7 = isset ($_GET['attr_7']) ? trim($_GET['attr_7']) : 0;
		$attr_8 = isset ($_GET['attr_8']) ? trim($_GET['attr_8']) : 0;
		$seo['t'] = '';
		if ($cate_id) {
			$cateinfo = $this->catearr[$cate_id];
			if (empty ($cateinfo)) {
				$seo['t'] ='Gloves';
				$seo['k'] = $this->webinfo['seokeywords'];
			} else {
				$this->assign('cateinfo', $cateinfo);
				$seo['t'] = $cateinfo['name'];
				$seo['d'] =  $cateinfo['detail'];
				$seo['k'] = $cateinfo['keyword'];
			}
		} else {
			$seo['k'] =  $this->webinfo['seokeywords'];
		}
		if($attr_7){
			$seo['t'] = $this->sets['material'][$attr_7].' Gloves,'.$seo['t'];
		}
		if($attr_8){
			$seo['t'] = $this->sets['usefor'][$attr_8].' Gloves,'.$seo['t'];
		}
		//dump($this->sets);
		$this->setSeo($seo['t'],$seo['k'],$seo['d']);
	}
}
?>