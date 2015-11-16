<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\config\models;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class MailConfigForm extends BaseConfig
{

    public $mailHost;

    public $mailUsername;

    public $mailPassword;

    public $mailPort;

    public $mailEncryption;

    public $mailUseTransport;

    public function rules()
    {
        return [
            // Host
            [
                'mailHost',
                'required'
            ],
            [
                'mailHost',
                'string',
                'max' => 255
            ],

            // Username
            [
                'mailUsername',
                'required'
            ],
            [
                'mailUsername',
                'string',
                'max' => 255
            ],

            // Password
            [
                'mailPassword',
                'required'
            ],
            [
                'mailPassword',
                'string',
                'max' => 255
            ],

            // Port
            [
                'mailPort',
                'required'
            ],
            [
                'mailPort',
                'integer'
            ],

            // Encryption
            [
                'mailEncryption',
                'string',
                'max' => 10
            ],

            // Use Transport
            [
                'mailUseTransport',
                'integer'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'mailHost' => 'Host',
            'mailUsername' => 'Username',
            'mailPassword' => 'Password',
            'mailPort' => 'Port',
            'mailEncryption' => 'Encryption',
            'mailUseTransport' => 'Use Transport'
        ];
    }

    public function loadDefaultValues()
    {
        $config = $this->getConfig();
        $this->mailHost = $config->get('mail.host');
        $this->mailUsername = $config->get('mail.username');
        $this->mailPassword = $config->get('mail.password');
        $this->mailPort = $config->get('mail.port');
        $this->mailEncryption = $config->get('mail.encryption');
        $this->mailUseTransport = $config->get('mail.useTransport');
    }


    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }
        $config = $this->getConfig();
        $config->set('mail.host', $this->mailHost);
        $config->set('mail.username', $this->mailUsername);
        $config->set('mail.password', $this->mailPassword);
        $config->set('mail.port', $this->mailPort);
        $config->set('mail.encryption', $this->mailEncryption);
        $config->set('mail.useTransport', $this->mailUseTransport);

        return true;
    }
}