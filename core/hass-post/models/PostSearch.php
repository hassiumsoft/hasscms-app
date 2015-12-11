<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\post\models;

use hass\base\traits\SearchModelTrait;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $short
 * @property string $content
 * @property string $slug
 * @property integer $views
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $revision
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class PostSearch extends Post
{
    use SearchModelTrait;

    public function rules()
    {
        // 只有在 rules() 函数中声明的字段才可以搜索
        return [
            [['id'], 'integer'],
            [['title', 'status'], 'safe'],
        ];
    }

}