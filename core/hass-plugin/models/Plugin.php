<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\plugin\models;

use Yii;
use hass\backend\enums\StatusEnum;
use hass\backend\enums\BooleanEnum;

/**
 * This is the model class for table "{{%plugin}}".
 *
 * @property string $package
 * @property integer $status
 * @property integer $installed
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Plugin extends \hass\backend\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plugin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'installed'], 'integer'],
            [['package'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'package' => Yii::t('hass', 'Package'),
            'status' => Yii::t('hass', 'Status'),
            'installed' => Yii::t('hass', 'Installed'),
        ];
    }
    
    public function loadDefaultValues($skipIfSet = true)
    {
        $this->status = StatusEnum::STATUS_OFF;
        $this->installed = BooleanEnum::FLASE;
    }
}
