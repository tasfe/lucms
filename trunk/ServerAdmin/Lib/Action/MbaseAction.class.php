<?php
// 本文档自动生成，仅供测试运行
class MbaseAction extends Action {
	public $tbname = '';
	public $obj = '';
	public $mpk = '';
	public function _initialize() {
		$role_id = Session :: get('role_id');
		if(empty($role_id)) $this->timeout();
		$this->assign('domid',MODULE_NAME.'_'.ACTION_NAME);
		$this->assign('mdomid',MODULE_NAME);
		$this->assign('adomid',ACTION_NAME);
		$this->assign('mpk',$this->mpk);
		if(empty($this->tbname) || empty($this->mpk)) exit('none ser or obj');
		$this->obj = D($this->tbname);
		$srcpre = str_replace('//', '/', $this->getConfig('weburl') . '/' . $this->getConfig('upload_path') . '/');
		$srcpre = str_replace(':/', '://', $srcpre);
		$this->assign('srcpre',$srcpre);
		//echo $this->getConfig('weburl');
		$mset = D('Set');
		$sets=$mset->getTree();
		$this->assign('sets',$sets);
	}
	
	public function getMap(){
		$maparr = $_GET;
		$p = isset($_GET['pageNum'])? $_GET['pageNum']:1;
		$ps = isset($_GET['ps'])? $_GET['ps']:15;
		if(isset($_GET['pageNum'])) unset($maparr['pageNum']);
		if(isset($_GET['ps'])) unset($maparr['ps']);
		if(isset($maparr['_'])) unset($maparr['_']);
		if(isset($maparr['numPerPage'])) unset($maparr['numPerPage']);
		if(isset($maparr['orderField'])) unset($maparr['orderField']);
		$map = array(
			'p' => $p,
			'ps' => $ps
		);
		$map = array_merge ($map,array('q'=>$maparr));
		foreach($map as $k=>$v){
			if(trim($v) == '') unset($map[$k]);
		}
		return $map;
	}
	public $act = array(
		'navtab' => array(
			'id' => 0,
			'close' => 0,
			'reload' => 0,
			'forward' => 0
		),
		'dialog' => array(
			'id' => 0,
			'close' => 0,
			'reload' => 0,
			'forward' => 0
		)
	);
	public function index() {
		$datalist = $this->obj->doGet($this->getMap());
		$this->assign('datalist', $datalist['list']);
		//dump($datalist);
		$this->assign('page', $datalist['page']);
		$this->display();
	}
	public function mselector(){
		$name = isset($_GET['name'])? $_GET['name']:0;
		$p = isset($_GET['pageNum'])? $_GET['pageNum']:1;
		$ps = isset($_GET['ps'])? $_GET['ps']:15;
		$map = array(
			'p' => $p,
			'ps' => $ps
		);
		if($name) $map['name'] = $name;
		$datalist = $this->obj->doGet($map);
		$this->assign('datalist', $datalist['list']);
		$this->assign('page', $datalist['page']);
		$this->display('mselector');
		$mset = D('Set');
		$sets = $mset->getTree();
		$this->assign('sets',$sets);
	}
	public function selector(){
		$name = isset($_GET['name'])? $_GET['name']:0;
		$p = isset($_GET['pageNum'])? $_GET['pageNum']:1;
		$ps = isset($_GET['ps'])? $_GET['ps']:15;
		$map = array(
			'p' => $p,
			'ps' => $ps
		);
		if($name) $map['name'] = $name;
		$datalist = $this->obj->doGet($map);
		$this->assign('datalist', $datalist['list']);
		$this->assign('page', $datalist['page']);
		$this->display('selector');
	}
	public function create() {
		if ($this->isPost()) {
			$data = $this->obj->getForm();
			//dump($data);
			$rs = $this->obj->doPost($data);
			if (!$rs) {
				$this->error( $this->obj->getError());
				return false;
			} else {
				$this->setClose('dialog',MODULE_NAME.'_create');
				$this->setReload('navtab',MODULE_NAME.'_index');
				$this->success('创建成功');
			}
		} else {
			$this->display();
		}

	}
	public function del() {
		$mpk_val = isset ($_POST[$this->mpk]) ? $_POST[$this->mpk] : 0;
		$data[$this->mpk] = $mpk_val;
		if (empty($data[$this->mpk])) {
			$this->error('no mpk', 0);
			return false;
		} 
		$rs = $this->obj->doDel($data);
		if (!$rs) {
			$this->error($this->obj->getError(), 0);
			return false;
		} else {
			$this->setReload('navtab',MODULE_NAME.'_index');
			$this->success('ok');
		}

	}
	
	public function view() {
		$mpk_val = isset ($_GET[$this->mpk]) ? $_GET[$this->mpk] : 0;
		if (!$mpk_val)
			$this->error('无数据', 0);
		$data = $this->getMap();
		$data['p'] = 0;
		$datainfo =  $this->obj->doGet($data);
		if (!$datainfo) {
			$this->error($this->obj->getError(), 0);
			return false;
		} else {
			$this->assign('datainfo', $datainfo);
			$this->display('view');
		}
	}
	public function edit($re = 0) {
		$mpk_val = isset ($_GET[$this->mpk]) ? $_GET[$this->mpk] : 0;
		if (!$mpk_val)
			$this->error('无数据', 0);
		$data = $this->getMap();
		$data['p'] = 0;
		$datainfo =  $this->obj->doGet($data);
		if($re) return $datainfo;
		if (!$datainfo) {
			$this->error($this->obj->getError(), 0);
			return false;
		} else {
			$this->assign('datainfo', $datainfo);
			$this->display('edit');
		}
	}
	public function update() {
		if ($this->isPost()) {
			Vendor('Soa.SoaApi');
			$data = $this->obj->getForm(2);
			//echo json_encode($data);
			$rs = $this->obj->doPut($data);
			$this->setClose('dialog',MODULE_NAME.'_edit');
			$this->setReload('navtab',MODULE_NAME.'_index');
			$this->success('修改成功');
			if (!$rs) {
				$this->error($this->obj->getError());
				return false;
			} else {
				$this->setClose('dialog',MODULE_NAME.'_edit');
				$this->setReload('navtab',MODULE_NAME.'_index');
				$this->success($this->obj->getError());
			}
		}
	}
	public function setClose($type = 'navtab',$id = ''){
		$this->act[$type]['close'] = 1;
		$this->act[$type]['id'] = $id;
	}
	public function setReload($type = 'navtab',$id = ''){
		$this->act[$type]['reload'] = 1;
		$this->act[$type]['id'] = $id;
	}
	public function setForward($url,$type = 'navtab',$id = ''){
		$this->act[$type]['forward'] = $url;
		$this->act[$type]['id'] = $id;
	}
	public function timeout(){
		$this->ajaxReturn('null','会话超时',301);
	}
	protected function ajaxReturn($data, $info = '', $status = 1, $type = 'json') {
		// 保证AJAX返回后也能保存日志
		if (C('LOG_RECORD'))
			Log :: save();
		$result = array ();
		$result['statusCode'] = $status;
		$result['navTabId'] = '';
		$result['callbackType'] = '';
		$result['forwardUrl'] = '';
		$result['message'] = $info;
		$result['data'] = $data;
		$result['act'] = $this->act;
		if (empty ($type))
			$type = C('DEFAULT_AJAX_RETURN');
		if (strtoupper($type) == 'JSON') {
			// 返回JSON数据格式到客户端 包含状态信息
			header("Content-Type:text/html; charset=utf-8");
			exit (json_encode($result));
		}
		elseif (strtoupper($type) == 'XML') {
			// 返回xml格式数据
			header("Content-Type:text/xml; charset=utf-8");
			exit (xml_encode($result));
		}
		elseif (strtoupper($type) == 'EVAL') {
			// 返回可执行的js脚本
			header("Content-Type:text/html; charset=utf-8");
			exit ($data);
		} else {
			// TODO 增加其它格式
		}
	}
	public function getConfig($name = ''){
		if(empty($name)) return 0;
		$mset = M('Config');
		$map['name'] = $name;
		return $mset->where($map)->getField('val');
	}
}
?>