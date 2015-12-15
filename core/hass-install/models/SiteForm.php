<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\install\models;

use yii\base\Model;
use hass\base\traits\ModelTrait;
use Yii;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class SiteForm extends Model
{
    
    use ModelTrait;

    public $appTimezone;

    public $appLanguage;

    public $appName;

    public $appDescription;

    
    const CACHE_KEY = "install-site-form";
    
    public function rules()
    {
        return [
            [
                [
                    'appTimezone',
                    'appLanguage',
                ],
                'required'
            ],
            [
                [   'appName',
                    'appDescription'
                ],
                'string'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'appTimezone' => '时区',
            'appLanguage' => '语言',
            'appName' => '站点名称',
            'appDescription' => '站点简介'
        ];
    }
    
    public function  loadDefaultValues()
    {
        $data = \Yii::$app->getCache()->get(SiteForm::CACHE_KEY);
        if($data)
        {
            $this->setAttributes($data);
        }
        else
        {
            $this->appTimezone = Yii::$app->getTimeZone();
            $this->appLanguage = Yii::$app->language;
        }
    }

    public function save()
    {
       \Yii::$app->getCache()->set(SiteForm::CACHE_KEY, $this->toArray());
        return true;
    }
}