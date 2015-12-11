<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\user\models;

use yii\helpers\ArrayHelper;
use hass\base\behaviors\TimestampFormatter;
use hass\attachment\models\Attachment;
use hass\attachment\models\AttachmentIndex;
/**
 *
 * @package hass\user
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class User extends \dektrium\user\models\User
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors =  array_merge(parent::behaviors(), [

            TimestampFormatter::className()
        ]);

        $behaviors['avatarImage'] = [
            'class' => \hass\attachment\behaviors\UploadBehavior::className(),
            'attribute' => 'avatarImage',
        ];

        return $behaviors;
    }

    public function getRole()
    {
        $authManager = \Yii::$app->getAuthManager();

        if ($authManager) {
            $roles = $authManager->getRolesByUser($this->id);

            if (count($roles) > 0) {
                $role = array_shift($roles);
                return $role->description;
            }
        }

        return "";
    }


    public function saveAvatar($avatar)
    {

        if($this->avatarImage)
        {
            $this->avatarImage->delete();
        }

        $attachment = new Attachment();
        $attachment->uploadFromFile($avatar);
        $attachment->save();

        $attachmentIndex =   new AttachmentIndex();
        $attachmentIndex->attachment_id =$attachment->primaryKey;
        $attachmentIndex->entity = get_class($this);
        $attachmentIndex->entity_id = $this->primaryKey;
        $attachmentIndex->attribute = "avatarImage";
        $attachmentIndex->save();
    }

    public function getAvatar($width="96", $height="96", $options = [])
    {
        if($this->avatarImage)
        {
            return $this->avatarImage->getThumb($width, $height, $options);
        }
        return static::getDefaultAvatar($width,$height);
    }

    public static  function getDefaultAvatar($width, $height)
    {
        list (, $baseUrl) = \Yii::$app->getAssetManager()->publish("@hass/user/misc/avatars");
        return $baseUrl . "/" . "avatar_" . $width."x".$height. ".png";
    }

    /**
     * getUsersList
     *
     * @return array
     */
    public static function getUsersList()
    {
        $users = static::find()->select([
            'id',
            'username'
        ])
            ->asArray()
            ->all();
        return ArrayHelper::map($users, 'id', 'username');
    }
}

?>