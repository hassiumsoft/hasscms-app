<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\components;

use yii\base\InvalidParamException;
use yii\helpers\FileHelper;
use Yii;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 */
class View extends \yii\web\View
{
    public function renderRead($pathMap, $params = [], $context = null)
    {
        $viewFile = null;

        foreach ($pathMap as $view) {

            $view = $this->findViewFile($view, $context);

            $view = Yii::getAlias($view);

            if ($this->theme !== null) {
                $view = $this->theme->applyTo($view);
            }
            if (is_file($view)) {
                $viewFile = FileHelper::localize($view);
                break;
            }
        }

        if ($viewFile == null) {
            throw new InvalidParamException("The view file does not exist: $viewFile");
        }

        return $this->renderFile($viewFile, $params, $context);
    }
}
