<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\page\models;

use Yii;
use hass\base\traits\SearchModelTrait;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $author_id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $weight
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class PageSearch extends Page
{
        use SearchModelTrait;
}
