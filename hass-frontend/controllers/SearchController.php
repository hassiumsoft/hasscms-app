<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\frontend\controllers;


use hass\frontend\BaseController;
use hass\frontend\models\Post;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class SearchController extends BaseController
{


    public function actionRead($id)
    {
        $id = intval($id);
        $condition = ["id"=>$id];
        if($id == 0)
        {
            $condition = ["slug"=>$id];
        }

        $model = Post::findOne($condition);

        return $this->render('view',["model"=>$model]);
    }

}
