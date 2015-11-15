<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\extensions\nestedsortable;

use yii;
use hass\extensions\nestedsortable\NestedSortableAsset;

/**
* @package hass\extensions
* @author zhepama <zhepama@gmail.com>
* @since 1.0
 */
class NestedSortable extends \yii\base\Widget
{

    public function init()
    {
        $view = $this->getView();
        NestedSortableAsset::register($view);
        $view->registerJs("$('#" . $this->getId() . "').nestedSortable({
		        forcePlaceholderSize: true,
				handle: 'div',
				helper:	'clone',
				items: 'li',
				opacity: .6,
				placeholder: 'placeholder',
				revert: 250,
				tabSize: 25,
				tolerance: 'pointer',
				toleranceElement: '> div',
				maxLevels: 4,
				isTree: true,
				expandOnHover: 700,
				startCollapsed: false
        });");
    }

    public function run()
    {
        return '<ol class="sortable" id="' . $this->getId() . '"></ol>';
    }
}
