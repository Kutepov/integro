<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $cssOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
        'css/site.css',
        'css/styles.css',
        'css/template_styles.css',
        'css/jsgantt.css',
        'css/jquery.ganttView.css',
        'css/all.min.css',
        'css/jquery.flexdatalist.min.css',
        'css/font-awesome.min.css',
        'css/jquery.arcticmodal-0.3.css',
        'css/lightgallery.min.css',
    ];
    public $js = [
        'js/jquery.arcticmodal-0.3.min.js',
        'js/jquery.flexdatalist.min.js',
        'js/jquery.ganttView.js',
        'js/jsgantt.js',
        'js/glightbox.min.js',
        'js/lightgallery.min.js',
        'js/lg-zoom.min.js',
        'js/Chart.js',
        'js/lg-thumbnail.min.js',
        'js/lg-fullscreen.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}