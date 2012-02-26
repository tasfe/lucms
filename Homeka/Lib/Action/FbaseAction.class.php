<?php
class FbaseAction extends Action {
	public $tbname = '';
	public $cate = '';
	public $obj = '';
	public $mpk = '';
	public $map = null;
	public $webinfo = array ();
	public $catearr = array ();
	public $sets = array();
	public $seo = array ();
	public function _initialize() {
		$this->assign('domid', MODULE_NAME . '_' . ACTION_NAME);
		$this->assign('mdomid', MODULE_NAME);
		$this->assign('adomid', ACTION_NAME);
		$this->assign('mpk', $this->mpk);
		if (!empty ($this->tbname) && !empty ($this->mpk)) {
			$this->obj = D($this->tbname);
			//exit ('none ser or obj');
		}
		$srcpre = str_replace('//', '/', $this->getConfig('weburl') . '/' . $this->getConfig('upload_path') . '/');
		$srcpre = str_replace(':/', '://', $srcpre);
		$this->assign('srcpre', $srcpre);
		$mset = D('Set');
		$this->sets = $mset->getTree();
		$this->assign('sets', $this->sets);
		$this->catearr = $this->getCateTree();
		if ($this->cate != 'product_cate')
			$this->getCateTree('product_cate');
		$webinfo = $this->getConfig();
		$this->webinfo = $webinfo;
		$this->setSeo('', $this->webinfo['seokeywords'], $this->webinfo['seodes']);
		$this->kefu();
		$this->assign('webinfo', $webinfo);
	}

	public function getMap() {
		$maparr = $_GET;
		$p = isset ($_GET['p']) ? $_GET['p'] : 1;
		$ps = isset ($_GET['ps']) ? $_GET['ps'] : 15;
		$oby = isset ($_GET['oby']) ? $_GET['oby'] : '';
		$okey = isset ($_GET['okey']) ? $_GET['okey'] : 'desc';
		$ps = 10;
		$page['p'] = $p;
		$map = array (
			'p' => $p,
			'ps' => $ps
		);
		if (!empty ($oby)) {
			$map['o'] = array (
				'oby' => $oby,
				'okey' => $okey
			);
			$page['oby'] = $oby;
			$page['okey'] = $okey;
		}
		$map['q'] = array ();
		foreach ($maparr as $k => $v) {
			if ($k != 'p' && $k != 'ps' && $k != 'oby' && $k != 'okey') {
				//echo $k;
				if($v != '') $map['q'][$k] = $v;
			}
			
			//if ($k == 'cate_id') {
				//unset ($map['q'][$k]);
				//$cmap = $this->getCateMap($v);
				//$map['q'] = array_merge($map['q'], $cmap);
			//}
		}
		$par = $map;
		$this->map = $map;
		//dump($map);
		$this->assign('urlmap', $map);
		$this->assign('urlpar', $par);
		return array (
			'par' => $par,
			'map' => $map,
			'page' => $page
		);
	}

	public function index() {
		$maparr = $this->getMap();
		$datalist = $this->obj->doGet($maparr['map']);
		$this->assign('datalist', $datalist['list']);
		$this->assign('pageinfo', $datalist['page']);
		$this->initPage($datalist['page'], $maparr['page']);
		$cate_id = isset ($_GET['cate_id']) ? trim($_GET['cate_id']) : 0;
		$this->assign('cateinfo', null);
		if (method_exists($this, 'setMySeo')) {
			$this->setMySeo();
		} else {
			if ($cate_id) {
				$cateinfo = $this->catearr[$cate_id];
				if (empty ($cateinfo)) {
					$this->setSeo(MODULE_NAME, $this->webinfo['seokeywords']);
				} else {
					$this->assign('cateinfo', $cateinfo);
					$this->setSeo($cateinfo['name'], $cateinfo['keyword'], $cateinfo['detail']);
				}
			} else {
				$this->setSeo(MODULE_NAME, $this->webinfo['seokeywords']);
			}
		}
		$this->display();
	}

	public function view() {
		$mpk_val = isset ($_GET[$this->mpk]) ? $_GET[$this->mpk] : 0;
		if (!$mpk_val)
			$this->error('无数据', 0);
		$data = $this->getMap();
		$data['map']['p'] = 0;
		$datainfo = $this->obj->doGet($data['map']);
		if (!$datainfo) {
			$this->error($this->obj->getError(), 0);
			return false;
		} else {
			$this->assign('datainfo', $datainfo);
			$this->setSeo($datainfo['name'], $datainfo['keyword'], $datainfo['summary']);
			$this->getNeighbor($datainfo);
			$this->getRelaData($datainfo);
			$this->display();
		}
	}
	public function getNeighbor($datainfo) {
		if (isset ($datainfo[$this->mpk])) {
			$map['q'] = array ();
			$map['p'] = 0;
			$map['q'][$this->mpk] = $datainfo[$this->mpk] + 1;
			$next = $this->obj->doGet($map);
			$map['q'][$this->mpk] = $datainfo[$this->mpk] - 1;
			$pre = $this->obj->doGet($map);
			$this->assign('datapre', $pre);
			$this->assign('datanext', $next);
		}
	}
	public function getRelaData($datainfo) {
		//$map['q'] = array();
		//$map['p'] = 1;
		//$map['ps'] = 8;
		//$map['q']['cate_1'] = $datainfo['cate_1'];

		if (!empty ($datainfo['cate_1']))
			$tmap['cate_1'] = $datainfo['cate_1'];
		if (!empty ($datainfo['cate_2']))
			$tmap['cate_2'] = $datainfo['cate_2'];
		if (!empty ($datainfo['cate_3']))
			$tmap['cate_3'] = $datainfo['cate_3'];
		$map['_logic'] = 'or';
		$rs = $this->obj->where($map)->limit(8)->select();
		$this->assign('relalist', $rs);
	}
	public function getConfig($name = '') {
		$configs = S('GConfig');
		if (!$configs) {
			$mset = M('Config');
			$tarr = $mset->select();
			foreach ($tarr as $vo) {
				$configs[$vo['name']] = $vo['val'];
			}
			S('GConfig', $configs);
		}
		if ($name == '')
			return $configs;
		if (isset ($configs[$name])) {
			return $configs[$name];
		} else {
			return false;
		}
	}

	public function getCateTree($catename = '', $reset = 0) {
		if ($this->cate == '' && $catename == '')
			return null;
		if (!empty ($catename))
			$this->cate = $catename;
		if (empty ($this->cate))
			return null;
		$cate = $this->cate . 's';
		$mcatetb = ucfirst(strtolower($this->cate));
		$tcateher = array ();
		if (S($cate) && $reset == 0) {
			$tcateher = S($cate);
		} else {
			$mcate = D($mcatetb);
			$tcateher = $mcate->doGet();
			S($cate, $tcateher);
		}
		$this->assign($cate, $tcateher);
		$tarr = array ();
		foreach ($tcateher as $vo) {
			$tarr[$vo['enname']] = $vo;
		}
		$this->assign($cate . 'i', $tarr);
		return $tcateher;
	}
	public function getCateMap($cate_id = 0) {
		$marr = array ();
		if (!$cate_id)
			return $marr;
		$tree = $this->getCateTree();
		if (!isset ($tree[$cate_id]))
			return $marr;
		$tarr = $tree[$cate_id]['parr'];
		$i = 1;
		foreach ($tarr as $v) {
			if ($v != 0) {
				$marr['cate_' . $i] = $v;
			} else {
				break;
			}
		}
		return $marr;
	}
	public function initPage($pagearr, $map) {
		import("ORG.Util.Page");
		$p = new Page($pagearr['rownum'], $pagearr['pagesize']);
		foreach ($map as $key => $val) {
			if (!is_array($val)) {
				$p->parameter .= "$key=" . urlencode($val) . "&";
			}
		}
		//分页显示
		$page = $p->show();
		//$addpage = $p->addShow();
		$this->assign('page', $page);
		//$this->assign('addpage', $addpage);
	}
	public function setSeo($t = '', $k = '', $d = '') {
		if ($t == '') {
			$this->seo['t'] = $this->webinfo['seotitle'];
		} else {
			$this->seo['t'] = $t . '-' . $this->webinfo['seotitle'];
		}
		$this->seo['k'] = $k;
		$this->seo['d'] = $d;
		$this->assign('seo', $this->seo);
	}
	
	public function kefu(){
		$m = M('Kefu');
		$list = $m->select();
		$this->assign('kefulist',$list);
	}
}
?>