<?php
class IndexAction extends Action {
	public $act = array (
		'navtab' => array (
			'id' => 0,
			'close' => 0,
			'reload' => 0,
			'forward' => 0
		),
		'dialog' => array (
			'id' => 0,
			'close' => 0,
			'reload' => 0,
			'forward' => 0
		)
	);
	/**
	+----------------------------------------------------------
	* 默认操作
	+----------------------------------------------------------
	*/
	public function index() {
		$role_id = Session :: get('role_id');
		if (empty ($role_id))
			redirect(U('Index/login'));
		$this->display();
	}
	public function login() {
		if (!$this->isPost()) {
			$this->display();
		} else {
			$this->assign('jumpUrl', U('login'));
			$username = isset ($_POST['username']) ? trim($_POST['username']) : '';
			$password = isset ($_POST['password']) ? trim($_POST['password']) : '';
			$verify = isset ($_POST['verify']) ? trim($_POST['verify']) : '';
			$ac = isset ($_POST['ac']) ? trim($_POST['ac']) : '';
			$userinfo = null;

			if (strlen($username) < 6 || strlen($username) > 16) {
				$msg = "用户名为6到16个字符组成";
				$this->error($msg, 1, 'username');
				return;
			}
			if (strlen($password) < 6 || strlen($password) > 16) {
				$msg = "用户密码为6到16个字符组成";
				$this->error($msg, 1, 'password');
				return;
			}
			if (md5($verify) != Session :: get('verify')) {
				$msg = "请填写正确的验证码";
				$this->error($msg, 1, 'verify');
				return;
			}

			$mset = M('Config');
			$smap['name'] = 'sysadmin';
			$sysadmin = $mset->where($smap)->getField('val');
			//根管理员
			if ($sysadmin == $username) {
				$smap['name'] = 'syspass';
				$syspass = $mset->where($smap)->getField('val');
				if (md5(md5($password)) != $syspass) {
					$msg = "密码输入错误";
					$this->error($msg, 1, 'password');
					return;
				}
				$userinfo = array (
					'person_id' => -1,
					'name' => $sysadmin,
					'role_id' => -1,
					'role' => '根系统管理员'
				);
				//其它用户
			} else {
				if (!$userinfo) {
					$msg = "登录用户不存在或输入错误";
					$this->error($msg, 1, 'username');
					return;
				}

			}

			Session :: set('person_id', (int) $userinfo['person_id']);
			Session :: set('personname', $userinfo['name']);
			Session :: set('role_id', (int) $userinfo['role_id']);
			Session :: set('wwwroot', __ROOT__);
			Session :: set('apppath', dirname(dirname(dirname(dirname(__FILE__)))). '/Uploads/');
			$this->success('登录成功', 1);
		}
	}

	public function logout() {
		$this->assign('jumpUrl', U('login'));
		Session :: clear();
		Session :: destroy();
		redirect(U('login'));
	}
	public function verify() {
		import("ORG.Util.Image");
		Image :: buildImageVerify();
	}
	
	public function set() {
		$m = M('Config');
		if ($this->isPost()) {
			$sets = isset ($_POST['set']) ? $_POST['set'] : null;
			foreach ($sets as $k => $v) {
				$map['name'] = $k;
				$data = array (
					'val' => $v
				);
				if ($k == 'syspass') {
					$data['val'] = md5(md5($v));
					if ($v == '') {
						$data['val'] = $m->where($map)->getField('val');
					}
				}

				$m->where($map)->save($data);
			}
			$this->setClose('dialog', 'Index_set');
			$this->success('修改成功', 1);
		} else {
			$set = isset ($_GET['set']) ? $_GET['set'] : 'sys';
			switch ($set) {
				case 'sys' :
					$map['type'] = 8;
					$data = $m->where($map)->order('config_id asc')->select();
					break;
				case 'ser' :
					$map['type'] = 1;
					$data = $m->where($map)->select();
					break;
				default :
					break;
			}
			$this->assign('datalist', $data);
			$this->display();
		}

	}
	public function config(){
		$m = M('Config');
		if ($this->isPost()) {
			$sets = isset ($_POST['config']) ? $_POST['config'] : null;
			foreach ($sets as $k => $v) {
				$map['name'] = $k;
				$data = array (
					'val' => $v
				);
				$m->where($map)->save($data);
			}
			$this->setClose('dialog', 'Index_config');
			$this->success('修改成功', 1);
		}else{
			$datalist = $m->select();
			$this->assign('datalist',$datalist);
			$this->display();
		}
	}
	public function menu() {
		$menu = $_GET['id'];
		$this->display('Layout:b_menu_' . $menu);
	}
	public function cache(){
		if ($this->isPost()) {
			import("ORG.Io.Dir");
			//$this->setClose('dialog', 'Index_cache');
			$this->success('操作成功', 1);
		}else{
			$this->display();
		}
		
	}
	public function ckfinder(){
		$this->display();
	}
	public function setClose($type = 'navtab', $id = '') {
		$this->act[$type]['close'] = 1;
		$this->act[$type]['id'] = $id;
	}
	public function setReload($type = 'navtab', $id = '') {
		$this->act[$type]['reload'] = 1;
		$this->act[$type]['id'] = $id;
	}
	public function setForward($url, $type = 'navtab', $id = '') {
		$this->act[$type]['forward'] = $url;
		$this->act[$type]['id'] = $id;
	}
	public function timeout() {
		$this->ajaxReturn('null', '会话超时', 301);
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
}
?>