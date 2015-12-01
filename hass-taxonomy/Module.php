<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2014-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\taxonomy;

use yii\base\BootstrapInterface;
use hass\base\classes\Hook;
use hass\taxonomy\models\Taxonomy;
use hass\taxonomy\hooks\MenuCreateHook;
use hass\base\helpers\NestedSetsTree;
use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\backend
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends \hass\module\BaseModule implements BootstrapInterface
{

    public $controllerNamespace = 'hass\taxonomy\controllers';

    public function init()
    {
        parent::init();
    }

    public function bootstrap($app)
    {
        Hook::on(\hass\menu\Module::EVENT_MENU_MODULE_LINKS, [
            $this,
            "onMenuConfig"
        ]);
        
        Hook::on(new MenuCreateHook());
        Hook::on(new \hass\taxonomy\hooks\EntityUrlPrefix());
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
    }

    /**
     *
     * @param \hass\base\helpers\Event $event            
     */
    public function onSetGroupNav($event)
    {
        $item = [
            'label' => "分类",
            'icon' => "fa-circle-o",
            'url' => [
                "/$this->id/default/index"
            ]
        ];
        
        $event->parameters->set(ModuleGroupEnmu::STRUCTURE, [
            $item
        ]);
    }

    public function onMenuConfig($event)
    {
        $collection = Taxonomy::find()->sort()
            ->asArray()
            ->all();
        
        $event->parameters->set($this->id, [
            "name" => "分类目录",
            "id" => $this->id,
            "tree" => NestedSetsTree::generateTree($collection, function ($item) {
                $item["id"] = $item['taxonomy_id']; // 这里还是用taxonomy_id的好..不用slug,因为slug很容易被更改
                return $item;
            })
        ]);
    }
}
