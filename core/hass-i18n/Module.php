<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\i18n;

use hass\module\BaseModule;
use yii\base\BootstrapInterface;
use yii\i18n\MissingTranslationEvent;
use hass\i18n\models\SourceMessage;
use hass\base\classes\Hook;
use hass\system\enums\ModuleGroupEnmu;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends BaseModule implements BootstrapInterface
{
    public $languages = [];

    public function bootstrap($app)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
    }
    
    
    public static  function getInstallLanguages()
    {
        return  (array)\Yii::$app->get("config")->get("app.language");
    }
    
    /**
     *
     * @param \hass\base\helpers\Event $event            
     */
    public function onSetGroupNav($event)
    {
        $event->parameters->set(ModuleGroupEnmu::STRUCTURE, [
            [
                'label' => "i18n",
                'icon' => "fa-users",
                'url' => [
                    "/i18n/default/index"
                ]
            ]
        ]);
    }

    public static function t($message, $params = [], $language = null)
    {
        return \Yii::t('hass/i18n', $message, $params, $language);
    }

    /**
     *
     * @param MissingTranslationEvent $event            
     */
    public static function missingTranslation(MissingTranslationEvent $event)
    {
        $driver = \Yii::$app->getDb()->getDriverName();
        $caseInsensitivePrefix = $driver === 'mysql' ? 'binary' : '';
        $sourceMessage = SourceMessage::find()->where('category = :category and message = ' . $caseInsensitivePrefix . ' :message', [
            ':category' => $event->category,
            ':message' => $event->message
        ])
            ->with('messages')
            ->one();
        
        if (! $sourceMessage) {
            $sourceMessage = new SourceMessage();
            $sourceMessage->setAttributes([
                'category' => $event->category,
                'message' => $event->message
            ], false);
            $sourceMessage->save(false);
        }
        $sourceMessage->initMessages();
        $sourceMessage->saveMessages();
    }
}

?>