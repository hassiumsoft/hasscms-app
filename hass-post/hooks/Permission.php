<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\post\hooks;

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Permission implements ListenerProviderInterface
{

    public function provideListeners(ListenerAcceptorInterface $acceptor)
    {
        $acceptor->addListener(\hass\rbac\Module::EVENT_RBAC_PERMISSION, [
            $this,
            "onAddPermission"
        ]);
    }

    public function onAddPermission($event)
    {
        $event->parameters->set("post", [
            "module" => "文章",
            "permissions" => [
                'post/default/switcher' => [
                    'type' => 2,
                    'description' => '文章状态'
                ],
                'post/default/delete' => [
                    'type' => 2,
                    'description' => '删除文章'
                ],
                'post/default/index' => [
                    'type' => 2,
                    'description' => '文章列表'
                ],
                'post/default/update' => [
                    'type' => 2,
                    'description' => '文章修改'
                ],
                'post/default/create' => [
                    'type' => 2,
                    'description' => '文章创建'
                ],
            ]
        ]);
    }
}