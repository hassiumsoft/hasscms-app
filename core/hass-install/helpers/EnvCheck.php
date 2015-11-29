<?php

/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\install\helpers;

use Yii;
use yii\base\Object;
require Yii::getAlias("@vendor/yiisoft/yii2/requirements/YiiRequirementChecker.php");

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class EnvCheck extends Object
{

    public $requirementsChecker;

    public function init()
    {
        $this->requirementsChecker = new \YiiRequirementChecker();
        
        $this->requirementsChecker->checkYii();
        
        $this->requirementsChecker->check($this->requirements());
    }

    public function getResult()
    {

        return $this->requirementsChecker->getResult();
    }

    public function requirements()
    {
        return array(
            // Database :
            array(
                'name' => 'PDO extension',
                'mandatory' => true,
                'condition' => extension_loaded('pdo'),
                'by' => 'All DB-related classes'
            ),
            array(
                'name' => 'PDO MySQL extension',
                'mandatory' => false,
                'condition' => extension_loaded('pdo_mysql'),
                'by' => 'All DB-related classes',
                'memo' => 'Required for MySQL database.'
            ),
            // PHP ini :
            'phpExposePhp' => array(
                'name' => 'Expose PHP',
                'mandatory' => false,
                'condition' => $this->requirementsChecker->checkPhpIniOff("expose_php"),
                'by' => 'Security reasons',
                'memo' => '"expose_php" should be disabled at php.ini'
            ),
            'phpAllowUrlInclude' => array(
                'name' => 'PHP allow url include',
                'mandatory' => false,
                'condition' => $this->requirementsChecker->checkPhpIniOff("allow_url_include"),
                'by' => 'Security reasons',
                'memo' => '"allow_url_include" should be disabled at php.ini'
            ),
            'phpSmtp' => array(
                'name' => 'PHP mail SMTP',
                'mandatory' => false,
                'condition' => strlen(ini_get('SMTP')) > 0,
                'by' => 'Email sending',
                'memo' => 'PHP mail SMTP server required'
            )
        );
    }
}
