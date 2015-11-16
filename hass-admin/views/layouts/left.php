<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
use hass\admin\widgets\LeftNav;

/**
*
* @package hass\admin
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
/* @var $module \hass\admin\Module */

$module =  \hass\admin\Module::getInstance();
?>
<aside class="main-sidebar">
	<section class="sidebar">
    <?php
    echo LeftNav::widget([
        'items' =>$module->getLeftNav()
    ]);
    ?>
    </section>
</aside>
