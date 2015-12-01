<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\components;

use yii\base\InvalidConfigException;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Theme extends \yii\base\Theme
{

    public $package;

    public $assetClass;

    /**
     *
     * @var \yii\web\AssetBundle
     */
    private $_bundle;

    public function init()
    {
        parent::init();
    }

    /**
     * view在init中还没有实例化完成..所以未写在init()中
     *
     * @return \yii\web\AssetBundle
     */
    public function getBundle()
    {
        if ($this->_bundle == null)
        {
            $this->publicBundle(\Yii::$app->getView());
        }
        return $this->_bundle;
    }

    public function publicBundle($view)
    {
        $assetClass = $this->assetClass;
        $this->_bundle = $assetClass::register($view);
    }

    public function getUrl($url)
    {
        if (! empty(($baseUrl = $this->getBaseUrl()))) {
            return $baseUrl . '/' . ltrim($url, '/');
        } elseif ($this->getBundle() != null) {
            return $this->_bundle->baseUrl . '/' . ltrim($url, '/');
        } else {
            throw new InvalidConfigException('The "baseUrl" property must be set.');
        }
    }

    public function getPath($path)
    {
        if (! empty(($basePath = $this->getBasePath()))) {
            return $basePath . DIRECTORY_SEPARATOR . ltrim($path, '/\\');
        } elseif ($this->getBundle() != null) {
            return $this->_bundle->basePath . '/' . ltrim($path, '/');
        } else {
            throw new InvalidConfigException('The "baseUrl" property must be set.');
        }
    }
}