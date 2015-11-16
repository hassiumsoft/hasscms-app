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



/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class PermalinkForm extends BaseConfig
{

    public static $structures = [
        "0"=>["默认","/?p=123"],
        "1"=>["Id型","/type/id"],
        "2"=>["Slug型","/type/slug"],
        "3"=>["名称型","/type/name"]
    ];

    public $permalinkStructure;

    public function rules()
    {
        return [
            [
                [
                    'permalinkStructure',
                ],
                'required'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'permalinkStructure' => '链接结构',
        ];
    }

    public function loadDefaultValues()
    {

    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && ! $this->validate($attributeNames)) {
            return false;
        }
        return true;
    }
}