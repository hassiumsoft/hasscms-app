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
* @since 0.1.0
 */

class CacheController extends \hass\base\BaseController
{


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
        if(Yii::$app->assetManager->linkAssets == false)
        {
            foreach(glob(Yii::$app->assetManager->basePath . DIRECTORY_SEPARATOR . '*') as $asset){
                \yii\helpers\FileHelper::removeDirectory($asset);
            }
        }
        
        $this->flash('success', Yii::t('hass', 'Assets cleared'));
        return $this->goReferrer();
    }
    
    
    public function actionFlushCacheKey($key)
    {
        if (Yii::$app->getCache()->delete($key)) {
            $this->flash('success', \Yii::t('hass', 'Cache entry has been successfully deleted'));
        };
        return $this->redirect(['index']);
    }
}