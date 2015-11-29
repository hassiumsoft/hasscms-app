<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\rbac\hooks;

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
        ],ListenerAcceptorInterface::P_HIGH);
    }

    /** @param \hass\base\classes\HookEvent $event */
    public function onAddPermission($event)
    {
        $event->parameters->fromArray(require dirname(__DIR__)."/permissions.php");
    }
}