<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\theme\models;
use yii\base\Model;
use hass\base\helpers\Util;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class CustomForm extends Model
{

    public $id;
    public $text;


    public function rules()
    {
        return [
            ["text","safe"]
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => '自定义样式表'
        ];
    }


    public static function findOne($id)
    {
        $model = new static();

        $model->id = $id;

        $model->text = \Yii::$app->get("themeManager")->getCustomCss($id);

        return $model;
    }


	public function save($runValidation = true, $attributeNames = null)
	{
	    if ($runValidation && !$this->validate($attributeNames)) {
	        return false;
	    }
	    \Yii::$app->get("themeManager")->setCustomCss($this->id, $this->text);
	    return true;
	}
}