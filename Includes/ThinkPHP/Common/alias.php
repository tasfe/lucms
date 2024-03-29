<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

// 导入别名定义
alias_import(array(
    'Model'         => THINK_PATH.'/Lib/Think/Core/Model.class.php',
    'Dispatcher'    => THINK_PATH.'/Lib/Think/Util/Dispatcher.class.php',
    'HtmlCache'     => THINK_PATH.'/Lib/Think/Util/HtmlCache.class.php',
    'Db'            => THINK_PATH.'/Lib/Think/Db/Db.class.php',
    'ThinkTemplate' => THINK_PATH.'/Lib/Think/Template/ThinkTemplate.class.php',
    'Template'      => THINK_PATH.'/Lib/Think/Util/Template.class.php',
    'TagLib'        => THINK_PATH.'/Lib/Think/Template/TagLib.class.php',
    'Cache'         => THINK_PATH.'/Lib/Think/Util/Cache.class.php',
    'Debug'         => THINK_PATH.'/Lib/Think/Util/Debug.class.php',
    'Session'       => THINK_PATH.'/Lib/Think/Util/Session.class.php',
    'TagLibCx'      => THINK_PATH.'/Lib/Think/Template/TagLib/TagLibCx.class.php',
    'TagLibHtml'    => THINK_PATH.'/Lib/Think/Template/TagLib/TagLibHtml.class.php',
    'ViewModel'     => THINK_PATH.'/Lib/Think/Core/Model/ViewModel.class.php',
    'AdvModel'      => THINK_PATH.'/Lib/Think/Core/Model/AdvModel.class.php',
    'RelationModel' => THINK_PATH.'/Lib/Think/Core/Model/RelationModel.class.php',
    'IbaseModel'    => THINK_PATH.'/Vendor/IModel/IbaseModel.class.php',
    'IrelaModel'    => THINK_PATH.'/Vendor/IModel/IrelaModel.class.php',
    'SettingModel'  => THINK_PATH.'/Vendor/IModel/SettingModel.class.php',
    'AccessModel'  => THINK_PATH.'/Vendor/IModel/AccessModel.class.php',
    'IcateModel'  => THINK_PATH.'/Vendor/IModel/IcateModel.class.php',
    //'Action'        => THINK_PATH.'/Lib/Think/Core/Action.class.php',
    'IbaseAction'   => THINK_PATH.'/Vendor/IAction/IbaseAction.class.php',
    'IrelaAction'    => THINK_PATH.'/Vendor/IAction/IrelaAction.class.php',
    //'MbaseAction'    => THINK_PATH.'/Vendor/IAction/MbaseAction.class.php',
    )
);
alias_import(array(
    'BulletinModel'    => THINK_PATH.'/Vendor/SModel/BulletinModel.class.php',
    'InfoModel'    => THINK_PATH.'/Vendor/SModel/InfoModel.class.php',
    'KefuModel'    => THINK_PATH.'/Vendor/SModel/KefuModel.class.php',
    'FlinkModel'    => THINK_PATH.'/Vendor/SModel/FlinkModel.class.php',
    'News_cateModel'    => THINK_PATH.'/Vendor/SModel/News_cateModel.class.php',
    'NewsModel'    => THINK_PATH.'/Vendor/SModel/NewsModel.class.php',
    'Product_cateModel'    => THINK_PATH.'/Vendor/SModel/Product_cateModel.class.php',
    'ProductModel'    => THINK_PATH.'/Vendor/SModel/ProductModel.class.php',
    'SetModel'    => THINK_PATH.'/Vendor/SModel/SetModel.class.php',
    'DownloadModel'    => THINK_PATH.'/Vendor/SModel/DownloadModel.class.php'
    //'Model'    => THINK_PATH.'/Vendor/SModel/Model.class.php',
    )
);
?>