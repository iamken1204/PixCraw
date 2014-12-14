<?php
namespace app\assets\craw;

use yii\web\AssetBundle;

class CrawAsset extends AssetBundle {

	public $sourcePath = '@app/assets/craw';
	public $css = [
		'css/craw.css',
		'css/semantic.css'
	];
	public $js = [
		'js/jquery-2.1.1.min.js',
		'js/js_craw.js'
	];
	public $depends = [
	];
}