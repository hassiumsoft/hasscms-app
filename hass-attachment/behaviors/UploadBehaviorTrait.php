<?php
/**
* HassCMS (http://www.hassium.org/).
*
* @link http://github.com/hasscms for the canonical source repository
*
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\attachment\behaviors;

use hass\attachment\models\AttachmentIndex;
use hass\attachment\models\Attachment;

/**
 * @author zhepama <zhepama@gmail.com>
 *
 * @since 0.1.0
 */
trait UploadBehaviorTrait
{
    use \hass\base\traits\EntityRelevance;
    /**
     * 里面三段代码的顺序不能错..
     */
    public function afterDelete()
    {
        $relatedIds = $this->getRelatedIds();

        AttachmentIndex::deleteAll([
            'entity_id' => $this->getEntityId(),
            'entity' => $this->getEntityClass(),
        ]);

        foreach ($relatedIds as $id) {
            $this->deleteFile($id);
        }
    }

    public function deleteNotExistFiles($relatedIds, $existIds)
    {
        foreach (array_diff($relatedIds, $existIds) as $id) {
            // 删除索引关系
            AttachmentIndex::deleteAll([
                'attachment_id' => $id,
                'entity_id' => $this->getEntityId(),
                'attribute' => $this->attribute,
                'entity' => $this->getEntityClass(),
            ]);

            // 尝试删除文件
            $this->deleteFile($id);
        }
    }

    /**
     * @param $filePath string
     * @param
     *            $owner
     *
     * @return bool|File
     *
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function attachFile($file)
    {
        $filePath = $file['path'];

        $attachment = new Attachment();
        $attachment->uploadFromFile($filePath);
        $attachment->name = $file['name'];
        if ($attachment->save()) {
            return $attachment;
        } else {
            return false; // 存储失败的话的处理
        }
    }

    /**
     * 先检查文件是否被使用没有使用则删除,在beforedelete中
     * 尝试删除文件.
     *
     * @param unknown $id
     */
    public function deleteFile($id)
    {
        $isUse = AttachmentIndex::find()->where([
            'attachment_id' => $id,
        ])->count();

        if ($isUse > 0) {
            return false;
        }

        $file = Attachment::findOne([
            'attachment_id' => $id,
        ]);

        $file->delete();
    }

    public function getRelatedIds()
    {
        $attachments = AttachmentIndex::find()->where([
            'entity' => $this->getEntityClass(),
            'entity_id' => $this->getEntityId(),
            'attribute' => $this->attribute,
        ])
        ->all();

        return \hass\base\helpers\ArrayHelper::getColumn($attachments, 'attachment_id');
    }

    public function saveIndex($id)
    {
        $relation = new AttachmentIndex();
        $relation->entity = $this->getEntityClass();
        $relation->entity_id = $this->getEntityId();
        $relation->attribute = $this->attribute;
        $relation->attachment_id = $id;
        $relation->save();
    }
}
