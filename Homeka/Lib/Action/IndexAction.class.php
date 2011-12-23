<?php
class IndexAction extends MbaseAction {
	public function index() {
		$imap['p'] = 0;
		$imap['q'] = array(
			'info_id' => 1
		);
		$minfo = D('Info');
		$gdata['intr1'] = $minfo->doGet($imap);
		$imap['q']['info_id'] = 3;
		$gdata['intr2'] = $minfo->doGet($imap);
		
		$pmap['p'] = 1;
		$pmap['ps'] = 4;
		$pmap['o'] = array(
			'oby' => 'grade',
			'okey' => 'desc'
		);
		$mproduct = D('Product');
		$rs = $mproduct->doGet($pmap);
		$gdata['product'] = $rs['list'];
		$this->assign('gdata',$gdata);
		$this->display();
	}
	public function sitemap() {

	}

}
?>