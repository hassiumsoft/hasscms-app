<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\area\models;

use hass\base\traits\SearchModelTrait;
use hass\area\models\Area;

/**
 * AreaSearch represents the model behind the search form about `hass\area\models\Area`.
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class AreaSearch extends Area{
     use SearchModelTrait;
}
