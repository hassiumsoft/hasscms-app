<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\attachment\actions;
use Yii;
use yii\web\Response;
use hass\attachment\models\Attachment;
use hass\attachment\helpers\MediaItem;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class GetAction extends BaseAction
{


    public $authorId;

    /**
     *
     * @var int return type (images or files)
     */
    public $type = MediaItem::FILE_TYPE_IMAGE;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if(!$this->authorId)
        {
            $this->authorId = \Yii::$app->getUser()->getId();
        }

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $attachments  = Attachment::findAll(["author_id"=>$this->authorId]);

        $list = [];

        foreach ($attachments as $attachment) {

            $mediaItem = MediaItem::createFromAttachment($attachment);

            if ($mediaItem->getFileType() === MediaItem::FILE_TYPE_IMAGE) {
                $list[] = [
                    'title' => $attachment->title,
                    'thumb' => $attachment->getUrl() ,
                    'image' =>  $attachment->getUrl() ,
                ];
            } elseif ($mediaItem->getFileType() === MediaItem::FILE_TYPE_DOCUMENT) {

                $list[] = [
                    'title' => $attachment->title,
                    'name' => $attachment->title,
                    'link' =>$attachment->getUrl(),
                    'size' => $attachment->size
                ];
            } else {
                $list[] = $url;
            }
        }

        return $list;
    }
}
