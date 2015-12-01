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

class PostController extends BaseController
{
    public function actionRead($id)
    {
        $model = Post::findByIdOrSlug($id);
        $model->addViewsNumber();
 
        list($title,$desc,$keys) = $model->getMetaData();
        $this->getView()->setMetaData($title,$desc,$keys);
        return $this->render('view',["post"=>$model]);
    }

}
