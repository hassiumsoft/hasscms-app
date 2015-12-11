<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\module\models;

use hass\base\enums\StatusEnum;

/**
 * This is the model class for table "{{%modules}}".
 *
 * @property string $package
 * @property string $id
 * @property string $class
 * @property integer $status
 * @property integer $installed
 * @property string $bootstrap
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends \hass\base\ActiveRecord
{

    const CACHE_KEY = 'hass_system_modules';

    public static function tableName()
    {
        return '{{%module}}';
    }

    public static function findEnabledModules()
    {
        $query = static::find();
        return $query->where([
            "status" => StatusEnum::STATUS_ON
        ])->asArray()->all();
    }
    
    public function loadDefaultValues($skipIfSet = true)
    {
        $this->status = 0;
        $this->installed = 0;
        return $this;
    }
}