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
class WeiboAuth extends OAuth2 implements ClientInterface
{

    public $authUrl = 'https://api.weibo.com/oauth2/authorize';

    public $tokenUrl = 'https://api.weibo.com/oauth2/access_token';

    public $apiBaseUrl = 'https://api.weibo.com';

    /**
     *
     * @return []
     * @see http://open.weibo.com/wiki/Oauth2/get_token_info
     * @see http://open.weibo.com/wiki/2/users/show
     */
    protected function initUserAttributes()
    {
        return $this->api('oauth2/get_token_info', 'POST');
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
        return isset($this->getUserAttributes()['login'])
        ? $this->getUserAttributes()['login']
        : null;
    }

    /**
     * get UserInfo
     *
     * @return []
     * @see http://open.weibo.com/wiki/2/users/show
     */
    public function getUserInfo()
    {
        return $this->api("2/users/show.json", 'GET', [
            'uid' => $this->getOpenid()
        ]);
    }

    /**
     *
     * @return int
     */
    public function getOpenid()
    {
        $attributes = $this->getUserAttributes();
        return $attributes['uid'];
    }

    protected function defaultName()
    {
        return 'weibo';
    }

    protected function defaultTitle()
    {
        return 'Weibo';
    }
}