<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\meta\models;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Meta extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%meta}}';
    }

    public function rules()
    {
        return [
            [
                [
                    'title',
                    'keywords',
                    'description'
                ],
                'trim'
            ],
            [
                [
                    'title',
                    'keywords',
                    'description'
                ],
                'string',
                'max' => 255
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Seo Title',
            'keywords' => 'Seo Keywords',
            'description' => 'Seo Description'
        ];
    }
}