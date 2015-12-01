<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\attachment\actions;

use yii\base\Action;
use yii\web\HttpException;
use hass\attachment\components\FileStorage;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
abstract class BaseAction extends Action
{
    /**
     * @return FileStorage
     * @throws \HttpException
     * @throws \yii\base\InvalidConfigException
     */
    protected function getFileStorage()
    {
        $fileStorage = \Yii::$app->get('fileStorage');
        if (!$fileStorage) {
            throw new HttpException(400);
        }
        return $fileStorage;
    }
}
