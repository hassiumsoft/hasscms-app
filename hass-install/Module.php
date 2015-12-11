<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\install;

use Yii;
use yii\base\BootstrapInterface;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    public $layout = "main";

    
    public function init(){
        parent::init();
    }
    
    public function beforeAction($action)
    {        
        if ($this->getIsInstalled() == true) {
            \Yii::$app->getResponse()->redirect("admin.php");
            return false;
        }
        
        return parent::beforeAction($action);
    }

    
    /**
     *  index.php 因为其引导的配置和前台模块使用了大量的数据库..所以不使用
     *  
     *  为了不污染frontend模块.所以不会在frontend模块中判断是否是安装模块.进行安装判断
     * 
     *  
     * {@inheritDoc}
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap($app)
    {
        if ($this->getIsInstalled() == true || ($this->getIsInstalled() == false && pathinfo(Yii::$app->getRequest()->getScriptUrl(),PATHINFO_BASENAME) == "install.php")) {
            return;
        }
        
        \Yii::$app->getResponse()->redirect("install.php");
        \Yii::$app->end();
    }

    public function getIsInstalled()
    {
        return isset(Yii::$app->params[APP_INSTALLED]) == true;
    }

    /**
     * config/main-local.php
     */
    public static function setDbConnection($config)
    {
        $file = \Yii::getAlias("@app/config/main-local.php");
        
        $content = "<" . "?php return ";
        $content .= var_export($config, TRUE);
        $content .= "; ?" . ">";
        
        file_put_contents($file, $content);
    }

    /**
     * config/params-local.php
     */
    public static function setInstalled()
    {
        $file = \Yii::getAlias("@app/config/params-local.php");
        
        $config = [
            APP_INSTALLED => true
        ];
        
        $content = "<" . "?php return ";
        $content .= var_export($config, TRUE);
        $content .= "; ?" . ">";
        
        file_put_contents($file, $content);
    }

    /**
     * config/frontend/main-local.php
     * config/backend/main-local.php
     */
    public static function setCookieValidationKey()
    {
        static::generateCookieValidationKey(\Yii::getAlias("@app/config/frontend/main-local.php"), \Yii::getAlias("@app/config/backend/main-local.php"));
    }

    /**
     * Generates a cookie validation key for every app config listed in "config" in extra section.
     * You can provide one or multiple parameters as the configuration files which need to have validation key inserted.
     */
    public static function generateCookieValidationKey()
    {
        $configs = func_get_args();
        
        $key = self::generateRandomString();
        foreach ($configs as $config) {
            if (is_file($config)) {
                $content = preg_replace('/(("|\')cookieValidationKey("|\')\s*=>\s*)(("|\').*("|\'))/', "\\1'$key'", file_get_contents($config));
                file_put_contents($config, $content);
            }
        }
    }

    protected static function generateRandomString()
    {
        if (! extension_loaded('openssl')) {
            throw new \Exception('The OpenSSL PHP extension is required by Yii2.');
        }
        $length = 32;
        $bytes = openssl_random_pseudo_bytes($length);
        return strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
    }
}