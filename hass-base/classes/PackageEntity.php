<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\classes;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/

trait PackageEntity{
    
    protected  $packageInfo;
    
    public function getPackageInfo()
    {
        return $this->packageInfo;
    }
    
    public function setPackageInfo($packageInfo)
    {
        $this->packageInfo = $packageInfo;
    }
    
    public function install()
    {
        return true;
    }
    
    public function uninstall()
    {
        return true;
    }
    
    public function upgrade()
    {
        return true;
    }
}