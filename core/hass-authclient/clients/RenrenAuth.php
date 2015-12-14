<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\authclient\clients;

use yii\authclient\OAuth2;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class RenrenAuth extends OAuth2 implements ClientInterface
{

    /**
     * @inheritdoc
     */
    public $authUrl = 'https://graph.renren.com/oauth/authorize';

    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://graph.renren.com/oauth/token';

    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://api.renren.com';

    /**
     * Try to use getUserAttributes to get simple user info
     *
     * @see http://open.renren.com/wiki/Authentication @inheritdoc
     * @see http://open.renren.com/wiki/V2/user/get
     */
    protected function initUserAttributes()
    {
         return  $this->getAccessToken()->getParams()['user'];
    }

    /** @inheritdoc */
    public function getEmail()
    {
        return isset($this->getUserAttributes()['email'])
        ? $this->getUserAttributes()['email']
        : null;
    }

    /** @inheritdoc */
    public function getUsername()
    {
        return isset($this->getUserAttributes()['name'])
        ? $this->getUserAttributes()['name']
        : null;
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'renren';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'Renren';
    }
}