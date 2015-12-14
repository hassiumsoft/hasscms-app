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
class QqOAuth extends OAuth2 implements ClientInterface
{

    public $authUrl = 'https://graph.qq.com/oauth2.0/authorize';

    public $tokenUrl = 'https://graph.qq.com/oauth2.0/token';

    public $apiBaseUrl = 'https://graph.qq.com';
    //授权内容
    public $scope = "get_user_info";
    
    /**
     * @see http://wiki.connect.qq.com/oauth2.0/me
     * @see http://wiki.connect.qq.com/get_user_info
     * @see \yii\authclient\BaseClient::initUserAttributes()
     */
    protected function initUserAttributes()
    {
        $attributes =  $this->api('oauth2.0/me', 'GET');
        
        $openid = $attributes['openid'];
        $result =  $this->api("user/get_user_info", 'GET', [
            'oauth_consumer_key' => $this->clientId,
            'openid' => $openid
        ]);
        $result['id'] = $openid;
        return $result;
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
        return isset($this->getUserAttributes()['nickname'])
        ? $this->getUserAttributes()['nickname']
        : null;
    }

    protected function defaultName()
    {
        return 'qq';
    }

    protected function defaultTitle()
    {
        return 'QQ';
    }

    /**
     * Processes raw response converting it to actual data.
     *
     * @param string $rawResponse
     *            raw response.
     * @param string $contentType
     *            response content type.
     * @throws Exception on failure.
     * @return array actual response.
     */
    protected function processResponse($rawResponse, $contentType = self::CONTENT_TYPE_AUTO)
    {
        if ($contentType == self::CONTENT_TYPE_AUTO) {
            // jsonp to json
            if (strpos($rawResponse, "callback") === 0) {
                $lpos = strpos($rawResponse, "(");
                $rpos = strrpos($rawResponse, ")");
                $rawResponse = substr($rawResponse, $lpos + 1, $rpos - $lpos - 1);
                $rawResponse = trim($rawResponse);
                $contentType = self::CONTENT_TYPE_JSON;
            }
        }
        return parent::processResponse($rawResponse, $contentType);
    }
}