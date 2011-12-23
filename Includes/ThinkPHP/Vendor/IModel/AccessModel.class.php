<?php


// +----------------------------------------------------------------------
// | LuluCWS [ Lulu COMPANY WEB SHOW]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.luluui.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: uuleaf <uuleaf@163.com>
// +----------------------------------------------------------------------
class AccessModel extends Model {
	public function checkAccess($md = 0,$ac = 0,$role_id = 0){
		if($role_id == -1) return true;
		if($md == 0 || $ac == 0 || $role_id == 0) return false;
		$md = strtolower($md);
		$ac = strtolower($md);
		$tmd = M('Ctmd');
		$tac = M('Ctac');
		$mdmap['name'] = $md;
		$md_id = $tmd->where($mdmap)->getField('md_id');
		if(!$md_id) return false;
		$acmap['name'] = $ac;
		$ac_id = $tac->where($acmap)->getField('ac_id');
		if(!$ac_id) return false;
		$tacc = M('Access');
		$accmap['md_id'] = $md_id;
		$accmap['ac_id'] = $ac_id;
		$accmap['role_id'] = $role_id;
		$rs = $tacc->where($accmap)->find();
		return $rs;
	}
}
?>