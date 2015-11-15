<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace hass\system\controllers;

use Yii;
/**
*
* @package hass\system
* @author zhepama <zhepama@gmail.com>
* @since 1.0
 */

class CacheController extends \hass\backend\BaseController
{
    public $rootActions = ['*'];

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFlushCache()
    {
        Yii::$app->cache->flush();
        $this->flash('success', Yii::t('hass', 'Cache flushed'));
        return $this->goReferrer();
    }

    public function actionClearAssets()
    {
        foreach(glob(Yii::$app->assetManager->basePath . DIRECTORY_SEPARATOR . '*') as $asset){
            if(is_link($asset)){
                unlink($asset);
            } elseif(is_dir($asset)){
                $this->deleteDir($asset);
            } else {
                unlink($asset);
            }
        }
        $this->flash('success', Yii::t('hass', 'Assets cleared'));
        return $this->goReferrer();
    }


    private function deleteDir($directory)
    {
        $iterator = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        return rmdir($directory);
    }
}