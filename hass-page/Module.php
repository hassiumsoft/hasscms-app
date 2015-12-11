<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\page;

use hass\module\BaseModule;
use hass\base\classes\Tree;
use yii\base\BootstrapInterface;
use hass\base\classes\Hook;
use hass\page\models\Page;
use hass\page\hooks\MenuCreateHook;
use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends BaseModule implements BootstrapInterface
{

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
        Hook::on(new \hass\page\hooks\EntityUrlPrefix());
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
            'label' => "页面",
            'icon' => "fa-circle-o",
            'url' => [
                "/$this->id/default/index"
            ]
        ];
        
        $event->parameters->set(ModuleGroupEnmu::CONTENT, [
            $item
        ]);
    }

    public function onMenuConfig($event)
    {
        $models = Page::find()->select([
            "id",
            "parent",
            "title"
        ])
            ->asArray()
            ->all();
        array_unshift($models, Page::getAppDefaultPage());
        $data = [];
        $tree = new Tree($models);
        $nodes = $tree->getRootNodes();
        $data = [];
        
        foreach ($nodes as $node) {
            $node = $node->toArray();
            $data[] = call_user_func([
                $this,
                "repalceKey"
            ], $node);
        }
        $event->parameters->set($this->id, [
            "name" => "页面",
            "id" => $this->id,
            "tree" => $data
        ]);
    }
    
    
    public  function repalceKey($node)
    {
        $node["name"] = $node["title"];
        unset($node["title"]);
        if(count($node["children"])>0)
        {
            $children = [];
            foreach($node["children"] as $child)
            {
                $children[] = call_user_func([$this,"repalceKey"],$child);
            }
            $node["children"] = [];
        }
        return $node;
    }
    
}

?>