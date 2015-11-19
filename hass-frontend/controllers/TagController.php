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
use hass\frontend\BaseController;
use hass\tag\models\TagIndex;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class TagController extends BaseController
{
    /**
     * 
     * @param unknown $id
     */
    public function actionRead($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TagIndex::find()->where(["tag_id"=>$id]),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        
        return $this->render('view',[
            'tagIndexs' => $dataProvider->getModels(),
            "pagination" => $dataProvider->getPagination()
        ]);
    }

}
