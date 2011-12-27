<?php
class IndexAction extends FbaseAction {
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
	public function aboutus(){
		$imap['p'] = 0;
		$imap['q'] = array(
			'info_id' => 1
		);
		$minfo = D('Info');
		$rs = $minfo->doGet($imap);
		$this->assign('datainfo',$rs);
		$this->display('view');
	}
	
	public function contact(){
		$imap['p'] = 0;
		$imap['q'] = array(
			'info_id' => 2
		);
		$minfo = D('Info');
		$rs = $minfo->doGet($imap);
		$this->assign('datainfo',$rs);
		$this->display('view');
	}
	public function factory(){
		$imap['p'] = 0;
		$imap['q'] = array(
			'info_id' => 5
		);
		$minfo = D('Info');
		$rs = $minfo->doGet($imap);
		$this->assign('datainfo',$rs);
		$this->display('view');
	}
	public function market(){
		$imap['p'] = 0;
		$imap['q'] = array(
			'info_id' => 6
		);
		$minfo = D('Info');
		$rs = $minfo->doGet($imap);
		$this->assign('datainfo',$rs);
		$this->display('view');
	}
	public function rw(){
		$res = C('REWRITE_RULE');
		foreach($res as $vo){
			if(!empty($vo['url_out'])){
				$url_out = str_replace('.','\\.',$vo['url_out']);
				$pattern = str_replace('.','\\.',$vo['pattern']);
				echo "RewriteRule $url_out $pattern [QSA,PT]".'<br/>';
				//echo $vo['url_out'].$vo['pattern'];
			}
			
		}
	}
}
?>