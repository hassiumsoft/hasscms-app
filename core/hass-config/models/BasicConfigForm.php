<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\config\models;

use hass\attachment\models\Attachment;
use hass\attachment\models\AttachmentIndex;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class BasicConfigForm extends BaseConfig
{

    public $appName;

    public $appDescription;

    public $appTimezone;

    public $appLanguage;

    public $appLogo;

    public $adminMail;

    public $appBackendTheme;

    public $appFrontendThemePath;



    public function rules()
    {
        return [
            // Application Name
            [
                'appName',
                'required'
            ],
            [
                [
                    'appName',
                    'appDescription',
                    'appTimezone',
                    'appLanguage'
                ],
                'string'
            ],

            //
            [
                'adminMail',
                'required'
            ],
            [
                'adminMail',
                'email'
            ],

            // Application Backend Theme
            [
                'appBackendTheme',
                'required'
            ],

            // Application Frontend Theme
            [
                'appFrontendThemePath',
                'required'
            ],

            [
                'appLogo',
                "safe"
            ]
        ]
        ;
    }

    public function attributeLabels()
    {
        return [
            'adminMail' => '管理员邮箱',
            'appName' => '站点标题',
            'appDescription' => '站点副标题',
            'appLogo' => '站点Logo',
            'appTimezone' => '时区',
            'appLanguage' => '语言',
            'appFrontendThemePath' => '前台主题路径',
            'appBackendTheme' => '后台主题',
        ];
    }

    public function loadDefaultValues()
    {
        $config = $this->getConfig();
        $this->appName = $config->get("app.name", 'Hasscms');
        $this->appDescription = $config->get("app.description", 'Hasscms is best phpcms');

        $this->appLogo = $config->get("app.logo", $this->getLogoUrl());

        $this->appTimezone = $config->get("app.timezone", 'UTC');
        $this->appLanguage = $config->get("app.language", 'en-US');
        $this->adminMail = $config->get("app.adminEmail", 'no@reply.com');

        $this->appFrontendThemePath = $config->get('theme.themePath', "@app/themes");
        $this->appBackendTheme = $config->get("app.backendTheme", "skin-purple");
    }

    public function load($data, $formName = NULL)
    {
        if (empty($data)) {
            return false;
        }

        if (! \Yii::$app->request->isAjax) {
            $scope = $formName === null ? $this->formName() : $formName;

            if (isset($data[$scope]["appLogo"])) {
                $postLogo = $data[$scope]["appLogo"];

                if (pathinfo($postLogo["path"], PATHINFO_BASENAME) != pathinfo($this->appLogo, PATHINFO_BASENAME)) {
                    $this->deleteOldLogo();
                    $attachment =  $this->saveLogo($postLogo["path"]);

                    $logo = $attachment->getUrl();
                } else {
                    $logo = $this->appLogo;
                }
            } else {
                if (! empty($this->appLogo)) {
                    $this->deleteOldLogo();
                }

                $logo = "";
            }

            $data[$scope]["appLogo"] = $logo;
        }

        return parent::load($data);
    }

    public function saveLogo($path)
    {
        $attachment = new Attachment();
        $attachment->uploadFromFile($path);
        $attachment->save();

        $attachmentIndex = new AttachmentIndex();
        $attachmentIndex->attachment_id = $attachment->primaryKey;
        $attachmentIndex->entity = get_class($this);
        $attachmentIndex->entity_id = 0;
        $attachmentIndex->attribute = "appLogoImage";
        $attachmentIndex->save();

        return $attachment;
    }

    public function deleteOldLogo()
    {
        $attachment = Attachment::find()->where([
            AttachmentIndex::tableName() . '.entity' => get_class($this),
            AttachmentIndex::tableName() . '.entity_id' => 0,
            AttachmentIndex::tableName() . '.attribute' => "appLogoImage"
        ])
            ->leftJoin(AttachmentIndex::tableName(), AttachmentIndex::tableName() . '.attachment_id =' . Attachment::tableName() . ".attachment_id")
            ->one();

        if ($attachment) {
            $attachment->delete();
        }
    }

    public function getLogoUrl()
    {
        $attachment = Attachment::find()->where([
            AttachmentIndex::tableName() . '.entity' => get_class($this),
            AttachmentIndex::tableName() . '.entity_id' => 0,
            AttachmentIndex::tableName() . '.attribute' => "appLogoImage"
        ])
            ->leftJoin(AttachmentIndex::tableName(), AttachmentIndex::tableName() . '.attachment_id =' . Attachment::tableName() . ".attachment_id")
            ->one();

        if ($attachment) {

            return $attachment->getUrl();
        }
        return null;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && ! $this->validate($attributeNames)) {
            return false;
        }

        $config = $this->getConfig();

        $config->set("app.name", $this->appName);
        $config->set("app.description", $this->appDescription);
        $config->set("app.logo", $this->appLogo);
        $config->set("app.timezone", $this->appTimezone);
        $config->set("app.language", $this->appLanguage);
        $config->set("app.adminEmail", $this->adminMail);

        $config->set('theme.themePath', $this->appFrontendThemePath);
        $config->set("app.backendTheme", $this->appBackendTheme);
        return true;
    }
}