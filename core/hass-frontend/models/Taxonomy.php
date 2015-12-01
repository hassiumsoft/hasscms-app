<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\models;

use creocoder\nestedsets\NestedSetsBehavior;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class Taxonomy extends \hass\taxonomy\models\Taxonomy
{

    public function behaviors()
    {
        $behaviors = [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree'
            ]
        ];
        $behaviors['meta'] = [
            'class' => \hass\meta\behaviors\MetaBehavior::className(),
            'entityClass' => 'hass\taxonomy\models\Taxonomy'
        ];
        return $behaviors;
    }

    public function getMetaData()
    {
        $model = $this->getMetaModel();
        
        $title = $model->title ?  : $this->name;
        
        $description = $model->description ?  : $this->description;
        
        return [
            $title,
            $description,
            $model->keywords
        ];
    }
}