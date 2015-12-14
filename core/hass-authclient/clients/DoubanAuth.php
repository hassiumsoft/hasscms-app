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
use yii\base\Exception;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class DoubanAuth extends OAuth2 implements ClientInterface
{

    /**
     * @inheritdoc
     */
    public $authUrl = 'https://www.douban.com/service/auth2/auth';

    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://www.douban.com/service/auth2/token';

    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://api.douban.com';

    /**
     * @inheritdoc
     */
    public $scope = 'douban_basic_common';

    protected function initUserAttributes()
    {
        return $this->api('v2/user/~me', 'GET');
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


    protected function defaultName()
    {
        return 'douban';
    }

    protected function defaultTitle()
    {
        return 'Douban';
    }

    /**
     * @ineritdoc
     */
    public function api($apiSubUrl, $method = 'GET', array $params = [], array $headers = [])
    {
        if (preg_match('/^https?:\\/\\//is', $apiSubUrl)) {
            $url = $apiSubUrl;
        } else {
            $url = $this->apiBaseUrl . '/' . $apiSubUrl;
        }
        $accessToken = $this->getAccessToken();
        if (! is_object($accessToken) || ! $accessToken->getIsValid()) {
            throw new Exception('Invalid access token.');
        }
        $headers[] = 'Authorization: Bearer ' . $accessToken->getToken();
        return $this->apiInternal($accessToken, $url, $method, $params, $headers);
    }
}