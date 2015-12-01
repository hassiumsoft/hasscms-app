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

use yii\db\ActiveRecord;
use hass\attachment\models\AttachmentIndex;
use hass\base\behaviors\BaseAttachAttribute;
use hass\attachment\models\Attachment;

/**
 * @author zhepama <zhepama@gmail.com>
 *
 * @since 0.1.0
 */
class UploadBehavior extends BaseAttachAttribute
{
    use UploadBehaviorTrait;


    public $multiple = false;


    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    // 根据特性返回这个值
    protected function getValue()
    {
        $value = [];

        if ($this->multiple == false) {
            $value = null;
        }

        if (!$this->owner->isNewRecord) {
            $value = $this->getAttachments()->all();
            if ($this->multiple == false) {
                $value = array_shift($value);
            }
        }

        return $value;
    }


    public function getAttachments()
    {
        return $this->owner->hasMany(Attachment::className(), [
            'attachment_id' => 'attachment_id'
        ])->via("attachmentIndex");
    }

    public function getAttachmentIndex()
    {
        return $this->owner->hasMany(AttachmentIndex::className(), [
            'entity_id' =>  $this->owner->primaryKey()[0]
        ])
        ->where([
            "entity" => $this->getEntityClass(),
            "attribute"=>$this->attribute
        ]);
    }


    public function afterInsert()
    {
        $postData = \Yii::$app->getRequest()->post($this->owner->formName());

        if (!isset($postData[$this->attribute]) || empty($postData[$this->attribute])) {
            return;
        }

        $files = $postData[$this->attribute];

        if ($this->multiple == false) {
            $files = [$files];
        }

        $uploadFiles = []; // 先上传,存储attachedment,得到id再建立关系
        $indexIds = []; // 只建立关系

        foreach ($files as $file) {
            if ($file['id'] == -1) {
                $uploadFiles[] = $file;
            } elseif ($file['id'] > 0) {
                $indexIds[] = $file['id'];
            }
        }

        $this->uploadAndSaveIndex($uploadFiles, $indexIds);
    }

    /**
     * $file 中id = -1 的是要上传的.
     *
     * 剩下的拿出来
     * 和数据库中的ID进行比较
     *
     * 两组不同的则是删除的.
     *
     * 删除附件的方法
     * 1.删除该item和附件的关系.
     * 2.检查该附件是否有其他引用,如果没有引用则删除附件表中的文件.再删除文件
     */
    public function afterUpdate()
    {
        $postData = \Yii::$app->getRequest()->post($this->owner->formName());

        if (isset($postData[$this->attribute])) {
            $files = $postData[$this->attribute];
            if ($this->multiple == false) {
                $files = [$files];
            }
        } else {
            $files = [];
        }

        $relatedIds = $this->getRelatedIds();
        $uploadFiles = []; // 先上传,存储attachedment,得到id再建立关系
        $indexIds = []; // 只建立关系
        $existIds = []; // 存在Oldid中的id,不存在的代表已经被删除的

        foreach ($files as $file) {
            if ($file['id'] == -1) {
                $uploadFiles[] = $file;
            } elseif ($file['id'] > 0 && !in_array($file['id'], $relatedIds)) {
                $indexIds[] = $file['id'];
            } else {
                $existIds[] = $file['id'];
            }
        }

        $this->uploadAndSaveIndex($uploadFiles, $indexIds);
        $this->deleteNotExistFiles($relatedIds, $existIds);
    }

    public function uploadAndSaveIndex($uploadFiles, $indexIds)
    {
        foreach ($uploadFiles as $file) {
            $attachment = $this->attachFile($file);
            $indexIds[] = $attachment->primaryKey;
        }

        // $indexIds 关系可以去重
        foreach (array_unique($indexIds) as $id) {
            $this->saveIndex($id);
        }
    }
}
