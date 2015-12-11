<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\backend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/**
* @package hass\backend
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class LeftNav extends \yii\bootstrap\Nav {
	/**
	 * @var array list of items in the nav widget. Each array element represents a single
	 * menu item which can be either a string or an array with the following structure:
	 *
	 * - label: string, required, the nav item label.
	 * - url: optional, the item's URL. Defaults to "#".
	 * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
	 * - linkOptions: array, optional, the HTML attributes of the item's link.
	 * - options: array, optional, the HTML attributes of the item container (LI).
	 * - active: boolean, optional, whether the item should be on active state or not.
	 * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
	 *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
	 *
	 * If a menu item is a string, it will be rendered directly without HTML encoding.
	 */
	public $items = [];
	/**
	 * @var boolean whether the nav items labels should be HTML-encoded.
	 */
	public $encodeLabels = true;
	/**
	 * @var boolean whether to automatically activate items according to whether their route setting
	 * matches the currently requested route.
	 * @see isItemActive
	 */
	public $activateItems = true;
	/**
	 * @var boolean whether to activate parent menu items when one of the corresponding child menu items is active.
	 */
	public $activateParents = true;
	/**
	 * @var string the route used to determine if a menu item is active or not.
	 * If not set, it will use the route of the current request.
	 * @see params
	 * @see isItemActive
	 */
	public $route;
	/**
	 * @var array the parameters used to determine if a menu item is active or not.
	 * If not set, it will use `$_GET`.
	 * @see route
	 * @see isItemActive
	 */
	public $params;


	/**
	 * Initializes the widget.
	 */
	public function init() {

		if ($this->route === null && Yii::$app->controller !== null) {
			$this->route = Yii::$app->controller->getRoute();
		}
		if ($this->params === null) {
			$this->params = Yii::$app->request->getQueryParams();
		}
		if ($this->dropDownCaret === null) {
		    $this->dropDownCaret = Html::tag('b', '', ['class' => 'caret']);
		}
		Html::addCssClass($this->options, 'sidebar-menu');
	}



	/**
	 * Renders a widget's item.
	 *
	 * @param string|array $item the item to render.
	 *
	 * @return string the rendering result.
	 * @throws InvalidConfigException
	 */
	public function renderItem($item) {
		if (is_string($item)) {
			return $item;
		}
		if (!isset($item['label'])) {
			throw new InvalidConfigException("The 'label' option is required.");
		}
		$encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
		$label       = $encodeLabel ? Html::encode($item['label']) : $item['label'];
		$options     = ArrayHelper::getValue($item, 'options', []);
		$icons       = ArrayHelper::getValue($item, 'icon', 'fa-folder');
		$items       = ArrayHelper::getValue($item, 'items');
		$url         = ArrayHelper::getValue($item, 'url', '#');
		$linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
		$linkOptions['type'] = 'ajax';

		if (isset($item['active'])) {
			$active = ArrayHelper::remove($item, 'active', false);
		} else {
			$active = $this->isItemActive($item);
		}

		$topArrow = '';
		if ($items !== null) {
			if (is_array($items)) {
				if (!empty($items)) {
					Html::addCssClass($options, 'treeview');
					$topArrow = '<i class="fa fa-angle-left pull-right"></i>';
				}
				if ($this->activateItems) {
					$items = $this->isChildActive($items, $active);
				}
				$items = $this->renderDropdown($items, $item);
			}
		}

		if ($this->activateItems && $active) {
			Html::addCssClass($options, 'active');
		}

		$htmlA = $label;
		if($url !== 'n/a'){
			$htmlA = Html::a('<i class="fa '.$icons.'"></i><span>'.$label.'</span>'.$topArrow, $url, $linkOptions);
		}

		return Html::tag('li', $htmlA.$items, $options);

	}

	/**
	 * Renders the given items as a dropdown.
	 * This method is called to create sub-menus.
	 *
	 * @param array $items      the given items. Please refer to [[Dropdown::items]] for the array structure.
	 * @param array $parentItem the parent item information. Please refer to [[items]] for the structure of this array.
	 *
	 * @return string the rendering result.
	 * @since 2.0.1
	 */
	protected function renderDropdown($items, $parentItem) {
		return DropDown::widget([
			'items'         => $items,
			'encodeLabels'  => $this->encodeLabels,
			'clientOptions' => false,
			'view'          => $this->getView(),
		]);
	}
	/**
	 * Check to see if a child item is active optionally activating the parent.
	 * @param array $items @see items
	 * @param boolean $active should the parent be active too
	 * @return array @see items
	 */
	protected function isChildActive($items, &$active)
	{
	    foreach ($items as $i => $child) {

	       $activeItems =ArrayHelper::getValue($child, 'activeItems', []);

	        if (ArrayHelper::remove($items[$i], 'active', false) || $this->isItemActive($child) || $this->isChildItemActive($activeItems)) {
	            Html::addCssClass($items[$i]['options'], 'active');
	            if ($this->activateParents) {
	                $active = true;
	            }
	        }
	    }
	    return $items;
	}

	protected  function isChildItemActive($items)
	{
	    $result = false;
        foreach ($items as $item)
        {
            if($this->isItemActive(["url"=>[$item]]) == true)
            {
                $result = true;
                break;
            }

        }
        return $result;
	}

	/**
	 * Checks whether a menu item is active.
	 * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
	 * When the `url` option of a menu item is specified in terms of an array, its first element is treated
	 * as the route for the item and the rest of the elements are the associated parameters.
	 * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
	 * be considered active.
	 * @param array $item the menu item to be checked
	 * @return boolean whether the menu item is active
	 */
	protected function isItemActive($item)
	{
	    if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
	        $route = $item['url'][0];
	        if ($route[0] !== '/' && Yii::$app->controller) {
	            $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
	        }
	        if (ltrim($route, '/') !== $this->route) {
	            return false;
	        }
	        unset($item['url']['#']);
	        if (count($item['url']) > 1) {
	            $params = $item['url'];
	            unset($params[0]);
	            foreach ($params as $name => $value) {
	                if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
	                    return false;
	                }
	            }
	        }

	        return true;
	    }

	    return false;
	}

}
