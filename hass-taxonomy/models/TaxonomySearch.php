<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\taxonomy\models;

use Yii;
use hass\base\traits\SearchModelTrait;

/**
 * This is the model class for table "{{%taxonomy}}".
 *
 * @property string $taxonomy_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $weight
 * @property integer $status
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class TaxonomySearch extends  Taxonomy
{
    use SearchModelTrait;
}
