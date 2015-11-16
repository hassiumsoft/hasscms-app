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

use yii\data\ActiveDataProvider;
use hass\frontend\models\Post;
use hass\frontend\BaseController;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class TagController extends BaseController
{



    public function actionRead($id)
    {
        $query = Post::find();

        $query->innerJoin("tag_index","`tag_index`.`entity_id`=`post`.`id`")->where(["entity"=>\hass\post\models\Post::className(),"tag_id"=>$id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $this->render('index',['dataProvider'=>$dataProvider]);
    }

}
