<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend;

use hass\base\traits\BaseControllerTrait;
use hass\base\helpers\Util;


/**
 *
 * @package hass\frontend
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class BaseController extends  \yii\web\Controller
{
    use BaseControllerTrait;

    /**
     * @param $view
     * @param $model
     * @param array $params
     * @return string
     */
    public function renderRead($view,$model,$params = [])
    {
        $prefix = Util::getEntityPrefix($model);
        $pathMap = [$prefix."-".$model->getPrimaryKey(),$view];
        if($model->hasAttribute("slug"))
        {
           array_unshift($pathMap,$prefix."-".$model->getAttribute("slug"));
        }
        $content =  $this->getView()->renderRead($pathMap,$params,$this);
        return $this->renderContent($content);
    }
}