<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
use hass\backend\widgets\LeftNav;

/**
*
* @package hass\backend
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
/* @var $module \hass\backend\Module */

$module =  \hass\backend\Module::getInstance();
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
