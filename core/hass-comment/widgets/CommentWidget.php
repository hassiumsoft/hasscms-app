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

use hass\comment\enums\CommentEnabledEnum;
use yii\base\InvalidConfigException;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class CommentWidget extends \yii\base\Widget
{
    use \hass\base\traits\EntityRelevance;
    public $owner;
    public $commentUrl;
    public $replyFormUrl;

    public function init()
    {
        parent::init();
        
        if($this->commentUrl == null)
        {
            $this->commentUrl = ["/comment/create"];
        }
        
        if($this->replyFormUrl == null)
        {
            $this->replyFormUrl =  ["/comment/replyform"] ;
        }
        
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