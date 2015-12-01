<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\comment\models;


use hass\base\enums\BooleanEnum;
use hass\base\traits\ModelTrait;
use hass\config\models\BaseConfig;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class CommentConfigForm extends BaseConfig
{

    use ModelTrait;


    /**
     * Maximum allowed nested level for comment's replies
     *
     * @var int
     */
    public $maxNestedLevel;

    /**
     * Indicates whether not registered users can leave a comment
     *
     * @var boolean
     */
    public $onlyRegistered;

    /**
     * Comments order direction
     *
     * @var int const
     */
    public $orderDirection;

    /**
     * Replies order direction
     *
     * @var int const
     */
    public $nestedOrderDirection;

    private $prefix;

    public function init()
    {
        parent::init();

        $this->prefix = \hass\comment\Module::getInstance()->id . ".";
    }

    public function rules()
    {
        return [
            [
                [
                    'maxNestedLevel',
                    'orderDirection',
                    "nestedOrderDirection"
                ],
                'integer'
            ],
            [
                "onlyRegistered",
                'boolean'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'maxNestedLevel' => 'Maximum allowed nested level',
            'onlyRegistered' => '只有注册用户才能发表评论',
            'orderDirection' => 'Comments order direction',
            'nestedOrderDirection' => 'Replies order direction'
        ];
    }

    public function loadDefaultValues()
    {
        $config = $this->getConfig();
        $this->maxNestedLevel = $config->get($this->prefix . "maxNestedLevel", 5);
        $this->onlyRegistered = $config->get($this->prefix . "onlyRegistered", BooleanEnum::FLASE);
        $this->orderDirection = $config->get($this->prefix . "orderDirection", SORT_DESC);
        $this->nestedOrderDirection = $config->get($this->prefix . "nestedOrderDirection", SORT_ASC);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && ! $this->validate($attributeNames)) {
            return false;
        }
        $config = $this->getConfig();
        $config->set($this->prefix . "maxNestedLevel", $this->maxNestedLevel);
        $config->set($this->prefix . "onlyRegistered", $this->onlyRegistered);
        $config->set($this->prefix . "orderDirection", $this->orderDirection);
        $config->set($this->prefix . "nestedOrderDirection", $this->nestedOrderDirection);

        return true;
    }
}