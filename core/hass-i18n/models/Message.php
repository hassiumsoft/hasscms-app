<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\i18n\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use hass\i18n\Module;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


class Message extends ActiveRecord
{

    /**
     *
     * @return string
     * @throws InvalidConfigException
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'language',
                'required'
            ],
            [
                'language',
                'string',
                'max' => 16
            ],
            [
                'translation',
                'string'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('ID'),
            'language' => Module::t('Language'),
            'translation' => Module::t('Translation')
        ];
    }

    public function getSourceMessage()
    {
        return $this->hasOne(SourceMessage::className(), [
            'id' => 'id'
        ]);
    }
}
