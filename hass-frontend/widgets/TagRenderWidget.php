<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\frontend\widgets;

use hass\frontend\models\Tag;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 1.0
*/
class TagRenderWidget extends \yii\base\Widget
{
    public $items;

    public function init()
    {
        parent::init();
        $this->items = Tag::find()->orderBy(['frequency' => SORT_DESC])->limit(10)->all();
    }

    public function run()
    {
        parent::run();
    }
}