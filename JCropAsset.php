<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace raoul2000\jcrop;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class JCropAsset extends AssetBundle
{
	public $css = [
		'css/jquery.Jcrop.css'
	];
	public $js = [
		'js/jquery.Jcrop.js'
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
	public function init() {
		$this->sourcePath = __DIR__.'/assets';
		return parent::init();
	}	
}
