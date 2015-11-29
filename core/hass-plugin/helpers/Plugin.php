<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\plugin\helpers;
use hass\helpers\Package;
use hass\plugin\models\Plugin as Model;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class Plugin extends Package
{
    /**
     *
     * @var \hass\plugin\models\Plugin
     */
    private $_model = null;
    /**
     *
     * @param \yii\web\Application $app
     */
    public function bootstrapInBackend($app)
    {

    }

    public function install()
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }

    public function upgrade()
    {
        return true;
    }

    public function getName()
    {
        $extra =  $this->configuration->extra();

        if(property_exists($extra, "pluginName"))
        {
            return $extra->pluginName;
        }
        return $this->configuration->name();
    }

    public function getVersion()
    {
        $extra =  $this->configuration->extra();

        if(property_exists($extra, "pluginVersion"))
        {
            return $extra->pluginVersion;
        }
        return $this->configuration->version();
    }

    public function getModel()
    {
        if($this->_model==null)
        {
            $model =  Model::findOne($this->getPackage());
            if($model == null)
            {
                $model = new Model();
                $model->loadDefaultValues();
                $model->package = $this->getPackage();
            }
            $this->_model = $model;
        }
        return  $this->_model;
    }

}