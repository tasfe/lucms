<?php
// +----------------------------------------------------------------------
// | Luluui [ Lulu COMPANY WEB SHOW]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.luluui.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: uuleaf <uuleaf@163.com>
// +----------------------------------------------------------------------
class AuthModel extends SoabaseModel {
	public function check($auth_id, $auth_name){
		$map['auth_id'] = $auth_id;
		$map['name'] = $auth_name;
		$rs = $this->where($map)->getField('auth_id');
		return $rs;
	}
	
}
?>