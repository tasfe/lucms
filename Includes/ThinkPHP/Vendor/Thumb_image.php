<?php

/***************************************
*作者：落梦天蝎（beluckly）
*完成时间：2006-12-18
*类名：CreatMiniature
*功能：生成裁切类型的缩略图
*基本参数：$srcFile,$echoType
*方法用到的参数：
                $toFile,生成的文件
                $toW,生成的宽
                $toH,生成的高
                $bk1,背景颜色参数 以255为最高
                $bk2,背景颜色参数
                $bk3,背景颜色参数

*整理：集客 - WEB资源储藏夹
***************************************/
class Thumb{
    //公共变量
    var $srcFile="";			//原图
    var $echoType;			//输出图片类型，link--不保存为文件；file--保存为文件
    var $im="";					//临时变量
    var $srcW="";				//原图宽
    var $srcH="";				//原图高

    //设置变量及初始化
	function SetVar($srcFile,$echoType){
		$this->srcFile=$srcFile;
		$this->echoType=$echoType;

        $info = "";
        $data = GetImageSize($this->srcFile,$info);
		switch ($data[2]){
			case 1:
				if(!function_exists("imagecreatefromgif")){
					echo "你的GD库不能使用GIF格式的图片，请使用Jpeg或PNG格式！<a href='javascript:go(-1);'>返回</a>";
					exit();
				}
				$this->im = ImageCreateFromGIF($this->srcFile);
				break;
			case 2:
				if(!function_exists("imagecreatefromjpeg")){
					echo "你的GD库不能使用jpeg格式的图片，请使用其它格式的图片！<a href='javascript:go(-1);'>返回</a>";
					exit();
				}
				$this->im = ImageCreateFromJpeg($this->srcFile);
				break;
			case 3:
				$this->im = ImageCreateFromPNG($this->srcFile);
				break;
		}
		$this->srcW=ImageSX($this->im);
		$this->srcH=ImageSY($this->im);
	}

    //生成最小裁剪后的缩图
    function Cut($toFile,$toW,$toH){
          $toWH=$toW/$toH;
          $srcWH=$this->srcW/$this->srcH;
          if($toWH<=$srcWH){
               $ctoH=$toH;
               $ctoW=$ctoH*($this->srcW/$this->srcH);
          }else{
              $ctoW=$toW;
              $ctoH=$ctoW*($this->srcH/$this->srcW);
          }
        $allImg=$this->CreatImage($this->im,$ctoW,$ctoH,0,0,0,0,$this->srcW,$this->srcH);
        $cImg=$this->CreatImage($allImg,$toW,$toH,0,0,($ctoW-$toW)/2,($ctoH-$toH)/2,$toW,$toH);
        return $this->EchoImage($cImg,$toFile);
        ImageDestroy($cImg);
        ImageDestroy($allImg);
    }


    function CreatImage($img,$creatW,$creatH,$dstX,$dstY,$srcX,$srcY,$srcImgW,$srcImgH){
        if(function_exists("imagecreatetruecolor")){
            @$creatImg = ImageCreateTrueColor($creatW,$creatH);
            if($creatImg)
                ImageCopyResampled($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
            else{
                $creatImg=ImageCreate($creatW,$creatH);
                ImageCopyResized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
            }
         }else{
            $creatImg=ImageCreate($creatW,$creatH);
            ImageCopyResized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
         }
         return $creatImg;
    }
    //输出图片，link---只输出，不保存文件。file--保存为文件
    function EchoImage($img,$to_File){
        switch($this->echoType){
            case "link":
                if(function_exists('imagejpeg')) return ImageJpeg($img);
                else return ImagePNG($img);
                break;
            case "file":
                if(function_exists('imagejpeg')) return ImageJpeg($img,$to_File);
                else return ImagePNG($img,$to_File);
                break;
        }
    }
}

## ------------------http://www.jike365.com-------------------------------------
?>