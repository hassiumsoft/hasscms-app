<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace hass\taxonomy\hooks;
use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */

class EntityUrlPrefix implements ListenerProviderInterface
{
    public function provideListeners(ListenerAcceptorInterface $acceptor)
    {
        $acceptor->addListener(\hass\urlrule\Module::EVENT_URLRULE_PREFIX_ENTITY, [
            $this,
            "onAddPrefix"
        ]);
    }

    public function onAddPrefix($event)
    {
        $event->parameters->set('hass\taxonomy\models\Taxonomy',"cat");
    }
}