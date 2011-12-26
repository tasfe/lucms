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
class BimagesModel extends Model {
	protected $tableName = 'config';
	public function doGet($par = '') {
		$imgtype = array (
			'gif',
			'png',
			'jpg',
			'jpge'
		);
		$dirroot = 'Uploads/Images/';
		if (!empty ($par)) {
			if (!is_dir($dirroot . $par))
				return false;
		}
		$dirpath = $dirroot . $par;
		if (!empty ($par))
			$dirpath .= '/';
		$files = array ();
		foreach (glob($dirpath . '*') as $item) {
			if (is_file($item)) {
				$tinfo = pathinfo($item);
				$ext = strtolower($tinfo['extension']);
				if (in_array($ext, $imgtype)) {
					$files[] = array (
						't' => 'file',
						's' => str_replace($dirroot, '', $item),
						'p' => str_replace('Uploads/', '', $item)
					);
				}
			} else {
				//echo $item;
				$files[] = array (
					't' => 'dir',
					's' => str_replace($dirroot, '', $item),
					'p' => str_replace('Uploads/', '', $item)
				);
			}
		}
		return $files;
	}
	public function doWater($par = '') {
		$dirroot = 'Uploads/';
		//if (!empty ($par))
		//$dirpath .= '/';
		$dirmark = 0;
		$imgp = $dirroot . $par;
		//echo $imgp;
		if (is_dir($imgp)) {
			$dirmark = 1;
			if (!empty ($par))
				$imgp .= '/';
		}
		$imgtype = array (
			'gif',
			'png',
			'jpg',
			'jpge'
		);
		$files = array ();
		//echo $imgp;
		if ($dirmark == 0) {
			if (is_file($imgp)) {
				$files[] = str_replace('Uploads/', '', $imgp);
			}
			//echo $imgp;
		} else {
			foreach (glob($imgp . '*') as $item) {
				if (is_file($item)) {
					$tinfo = pathinfo($item);
					$ext = strtolower($tinfo['extension']);
					if (in_array($ext, $imgtype)) {
						$files[] = str_replace('Uploads/', '', $item);
					}
				}
			}
		}
		//dump($files);
		Vendor('Water_image');
		$wimg = new Gimage();
		foreach ($files as $vo) {
			$wimg->wm_image_name = 'Uploads/Images/water.gif';
			$wimg->save_file = 'Uploads/' . $vo;
			$wimg->create('Uploads/' . $vo);
			usleep(300000);
		}
		//
		//$wimg = new Gimage();
		//$img->wm_text = "www.discuz.com";
		//$img->wm_text_font = "./STXINWEI.TTF";
		//$wimg->wm_image_name = 'Uploads/Images/water.gif';
		//$wimg->save_file = $imgp;
		//$wimg->create($imgp);
		return true;
	}
}