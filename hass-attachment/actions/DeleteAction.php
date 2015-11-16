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

use yii\web\HttpException;
use yii\web\Response;


/**
 * public function actions(){
 *   return [
 *           'upload'=>[
 *               'class'=>'hass\attachment\actions\DeleteAction',
 *           ]
 *       ];
 *   }
 *
 *   所有的删除动作都不做处理,在提交后对比前后两次的附件数..然后统一处理是否删除
 *
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class DeleteAction extends BaseAction
{
    /**
     * @return bool
     * @throws HttpException
     * @throws \HttpException
     */
    public function run()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $path = \Yii::$app->request->get('path');

        return [$path=>true];
    }
}
