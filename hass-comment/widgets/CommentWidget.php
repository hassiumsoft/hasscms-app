<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\comment\widgets;

use Yii;
use hass\comment\enums\CommentEnabledEnum;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 */
class CommentWidget extends \yii\base\Widget
{
    use \hass\helpers\traits\EntityRelevance;
    public $owner;
    public $commentUrl;
    public $replyFormUrl;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if ($this->owner->commentEnabled == CommentEnabledEnum::STATUS_OFF) {
            return;
        }
        return $this->render('index', [
            'entity' =>$this->getEntityClass(),
            "entity_id"=>$this->getEntityId(),
            "commentUrl"=>$this->commentUrl,
            "replyFormUrl"=>$this->replyFormUrl
        ]);
    }
}