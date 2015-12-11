<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\misc\editor;

use Yii;
use yii\db\ActiveRecord;
use \hass\attachment\models\Attachment;
use hass\base\behaviors\BaseAttachAttribute;
use PHPHtmlParser\Dom;
use hass\attachment\behaviors\UploadBehaviorTrait;
use hass\base\helpers\Util;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */



class EditorBehavior extends BaseAttachAttribute
{

    use UploadBehaviorTrait;

    public $dom;

    /**
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }


    /**
     *
     * @return \PHPHtmlParser\Dom
     * @throws \yii\base\InvalidConfigException
     */
    protected function getHtmlDom()
    {
        if($this->dom == null)
        {
            $this->dom = new Dom();
        }
        return $this->dom;
    }

    //存储需要建立关联的附件id在实体保存后使用..因为这个时候不知道实体id
    public $indexIds;

    public function beforeInsert()
    {
        list($imgs,$files) = $this->getContentAttachements();

        if (empty($files)) {
            return true;
        }

        $uploadFiles = []; // 先上传,存储attachedment,得到id再建立关系
        $indexIds = []; // 建立关系

        foreach ($files as $file) {
            if ($file["id"] == - 1) {
                $uploadFiles[] = $file;
            } elseif ($file['id'] > 0 ) {
                $indexIds[] = $file['id'];
            }
        }

        $this->uploadAndReplaceUrls($uploadFiles, $imgs,$indexIds);

        $this->indexIds = $indexIds;
        return true;
    }

    public function afterInsert()
    {
        if(empty($this->indexIds))
        {
            return;
        }
        //$indexIds 关系可以去重
        foreach (array_unique($this->indexIds) as $id) {
            $this->saveIndex($id);
        }
    }


    public function beforeUpdate()
    {
        list($imgs,$files) = $this->getContentAttachements();

        if (empty($files)) {
            $files = [];
        }

        $relatedIds =$this->getRelatedIds();
        $uploadFiles = []; // 先上传,存储attachedment,得到id再建立关系
        $indexIds = []; // 只建立关系
        $existIds = []; // 存在Oldid中的id,不存在的代表已经被删除的

        foreach ($files as $file) {
            if ($file["id"] == - 1) {
                $uploadFiles[] = $file;
            } elseif ($file['id'] > 0 && ! in_array($file['id'], $relatedIds)) {
                $indexIds[] = $file['id'];
            } else {
                $existIds[] = $file['id'];
            }
        }

        $this->deleteNotExistFiles($relatedIds, $existIds);
        $this->uploadAndReplaceUrls($uploadFiles, $imgs,$indexIds);
            //$indexIds 关系可以去重
        foreach (array_unique($indexIds) as $id) {
            $this->saveIndex($id);
        }
    }

    /**
     * 获取编辑器内容中的附件列表
     */
    public function getContentAttachements()
    {
        $content = $this->owner->{$this->attribute};
        $this->getHtmlDom()->load($content);
        $imgs = $this->getHtmlDom()->find('img');

        $files = [];
        foreach ($imgs as $img)
        {
            $file = $this->checkUploadImg($img->getAttribute('src'));

            if($file)
            {
                $files[] =$file;
            }
        }

        return [$imgs,$files];
    }

    /**
     * 根据url检查该附件是否存在与数据库中,以及该附件的相关信息
     * 外部的src返回null,无效的url返回null
     * @param unknown $src
     */
    public function checkUploadImg($src)
    {
        $pathParts  = pathinfo($src);
        $hash = $pathParts['filename'];
        $attachment = Attachment::find()->where(["hash"=>$hash])->one();

        $file = [];
        if(!$attachment)
        {
            $path = \Yii::$app->get("fileStorage")->urlToPath($src);


           if(\Yii::$app->get("fileStorage")->has($path) && ($media =\Yii::$app->get("fileStorage")->get($path)))
           {
               $file["id"] = -1;
               $file["path"] =$path;
               $file['url'] = $src;
               $file['name'] = $hash;
               $file['hash'] = $hash;
               $file['type'] = $media->getMimetype();
               $file['size'] = $media->getSize();
               $file['extension'] = $pathParts['extension'];
               return $file;
           }

           return null;
        }

        $file = $attachment->getAttributes();
        $file['id'] = $attachment->primaryKey;
        $file['path'] = $attachment->getPath();
        $file['url'] = $attachment->getUrl();

        return $file;
    }


    /*
     * 上传新附件并且替换内容中的url
     */
    protected function uploadAndReplaceUrls($uploadFiles,$imgs,&$indexIds)
    {

        $replaceUrls = [];

        foreach ($uploadFiles as  $file) {
            $attachment =  $this->attachFile($file);
            $indexIds[] = $attachment->primaryKey;
            $replaceUrls[$file["url"]] =  $attachment->getUrl();
        }

        foreach ($imgs as $img)
        {
            $url = $img->getAttribute('src');
            if(array_key_exists($url,$replaceUrls))
            {
                $img->setAttribute('src',$replaceUrls[$url]);
            }
        }


        $this->owner->{$this->attribute} = (string)$this->getHtmlDom();
    }
}
