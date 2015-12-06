<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\attachment\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use hass\base\behaviors\TimestampFormatter;
use Distill\Exception\InvalidArgumentException;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;
use yii\imagine\Image;
use hass\attachment\helpers\MediaItem;
/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property integer $attachment_id
 * @property integer $author_id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $hash
 * @property integer $size
 * @property string $type
 * @property string $extension
 * @property integer $created_at
 * @property integer $updated_at
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Attachment extends \hass\base\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'hash',
                    'size',
                    'type',
                    'extension'
                ],
                'required'
            ],
            [
                [
                    'author_id',
                    'size'
                ],
                'integer'
            ],
            [
                [
                    'name',
                    'title',
                    'description',
                    'hash',
                    'type',
                    'extension'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'created_at',
                    'updated_at'
                ],
                'safe'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => Yii::t('hass', 'Attachment ID'),
            'author_id' => Yii::t('hass', 'Author ID'),
            'name' => Yii::t('hass', 'Name'),
            'title' => Yii::t('hass', 'Title'),
            'description' => Yii::t('hass', 'Description'),
            'hash' => Yii::t('hass', 'Hash'),
            'size' => Yii::t('hass', 'Size'),
            'type' => Yii::t('hass', 'Type'),
            'extension' => Yii::t('hass', 'Extension'),
            'created_at' => Yii::t('hass', 'Created At'),
            'updated_at' => Yii::t('hass', 'Updated At')
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                "class" => BlameableBehavior::className(),
                "attributes" => [
                    static::EVENT_BEFORE_INSERT => "author_id"
                ]
            ],
            TimestampFormatter::className()
        ];
    }

    public function afterDelete()
    {
        // 删除关系表
        AttachmentIndex::deleteAll([
            'attachment_id' => $this->primaryKey
        ]);

        try {
            $media = MediaItem::createFromAttachment($this);
            if($media->isImage())
            {
                $this->deleteThumbs();
            }            
            $this->deleteFile();
        } catch (Exception $ex) {}
    }

    /**
     *
     * @todo-hass 这个生成唯一代码
     *       Returns a unique code used for masking the file identifier.
     * @param $file System\Models\File
     * @return string
     */
    public function getUniqueCode($file)
    {
        if (! $file) {
            return null;
        }

        $hash = md5($file->file_name . '!' . $file->disk_name);
        return base64_encode($file->id . '!' . $hash);
    }

    /**
     * Locates a file model based on the unique code.
     *
     * @param $code string
     * @return Attachment
     */
    public function findFileObject($code)
    {
        $parts = explode('!', base64_decode($code));
        if (count($parts) < 2) {
            throw new InvalidArgumentException('Invalid code');
        }

        list ($id,$hash) = $parts;

        if (! $file = static::find((int) $id)) {
            throw new InvalidArgumentException('Unable to find file');
        }

        $verifyCode = $this->getUniqueCode($file);
        if ($code != $verifyCode) {
            throw new InvalidArgumentException('Invalid hash');
        }

        return $file;
    }

    public function getTempDirectory()
    {
        $folder = \Yii::$app->get("config")->get("attachment.temp.foler", "temps");
        \Yii::$app->session->open();
        // 不使用ID,避免同账号多人登录
        $userTempPath = $folder . DIRECTORY_SEPARATOR . \Yii::$app->session->id;
        \Yii::$app->session->close();
        return $userTempPath;
    }

    public function getUserDirectory($uid)
    {
        $folder = \Yii::$app->get("config")->get("attachment.user.foler", "users");

        return $folder . DIRECTORY_SEPARATOR . $uid;
    }

    public $uploadsFolder;

    public function setStorageDirectory($path)
    {
        $this->uploadsFolder = FileHelper::normalizePath($path);
    }

    /**
     * Define the internal storage path.
     */
    public function getStorageDirectory()
    {
        if ($this->uploadsFolder == null) {
            $this->setStorageDirectory(\Yii::$app->get("config")->get('attachment.uploads.folder', "media"));
        }
        return $this->uploadsFolder;
    }

    protected function getPartitionDirectory()
    {
        return implode('/', array_slice(str_split($this->hash, 3), 0, 3));
    }

    public function getUrl()
    {
        return \Yii::$app->get("fileStorage")->getPathUrl($this->getPath());
    }

    public function getFile()
    {
        return \Yii::$app->get("fileStorage")->get($this->getPath());
    }

    public function getPath()
    {
        return $this->getStorageDirectory() . DIRECTORY_SEPARATOR . $this->getPartitionDirectory() . DIRECTORY_SEPARATOR . $this->hash . "." . $this->extension;
    }

    public function getAbsolutePath()
    {
        return \Yii::$app->get("fileStorage")->getPath($this->getPath());
    }

    /**
     *
     * @param UploadedFile $uploadedFile
     */
    public function uploadFromPost($uploadedFile)
    {
        if ($uploadedFile === null)
            return;

        $this->name = ltrim(pathinfo(' ' . $uploadedFile->name,PATHINFO_FILENAME));
        $this->extension = $uploadedFile->getExtension();
        $this->size = $uploadedFile->size;
        $this->type = $uploadedFile->type;
        $this->hash = $this->getHashName();

        $this->uploadFile($uploadedFile->tempName, $this->hash . "." . $this->extension);

        return $this;
    }

    public function uploadFromFile($filePath)
    {
        if ($filePath === null)
            return;

        $filePath = \Yii::$app->get("fileStorage")->get(\Yii::$app->get("fileStorage")->getRelativePath($filePath));

        $this->name = ltrim(pathinfo(' ' .$filePath->getPath(), PATHINFO_FILENAME));
        $this->extension = pathinfo($filePath->getPath(), PATHINFO_EXTENSION);
        $this->size = $filePath->getSize();
        $this->type = $filePath->getMimetype();
        $this->hash = $this->getHashName();
        $this->uploadFile(\Yii::$app->get("fileStorage")->getPath($filePath->getPath()), $this->hash . "." . $this->extension);
        return $this;
    }

    protected function getHashName()
    {
        if ($this->hash !== null)
            return $this->hash;
        $this->hash = str_replace('.', '', uniqid(null, true));
        return $this->hash;
    }

    protected function uploadFile($sourceUrl, $destinationFileName = null)
    {
        if (! $destinationFileName) {
            $destinationFileName = $this->hash;
        }
        $destinationPath = $this->getStorageDirectory() . DIRECTORY_SEPARATOR . $this->getPartitionDirectory();
        return \Yii::$app->get("fileStorage")->upload($sourceUrl, $destinationPath . DIRECTORY_SEPARATOR . $destinationFileName);
    }

    protected function deleteFile($fileName = null)
    {
        if (! $fileName)
            $fileName = $this->hash . "." . $this->extension;

        $directory = $this->getStorageDirectory() . DIRECTORY_SEPARATOR . $this->getPartitionDirectory();
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;

        \Yii::$app->get("fileStorage")->delete($filePath);
        $this->deleteEmptyDirectory($directory);
    }

    protected function deleteEmptyDirectory($dir = null)
    {
        if (\Yii::$app->get("fileStorage")->deleteEmptyDirectory($dir) == false) {
            return;
        }

        $dir = dirname($dir);
        if (\Yii::$app->get("fileStorage")->deleteEmptyDirectory($dir) == false) {
            return;
        }

        $dir = dirname($dir);
        if (\Yii::$app->get("fileStorage")->deleteEmptyDirectory($dir) == false) {
            return;
        }
    }

    /**
     * Generates and returns a thumbnail path.
     */
    public function getThumb($width, $height, $options = [])
    {
        $width = (int) $width;
        $height = (int) $height;

        $options = $this->getDefaultThumbOptions($options);

        $thumbFile = $this->getThumbFilename($width, $height, $options);
        $thumbPath = $this->getStorageDirectory() . DIRECTORY_SEPARATOR . $this->getPartitionDirectory() . DIRECTORY_SEPARATOR . $thumbFile;

        if (! \Yii::$app->get("fileStorage")->has($thumbPath)) {
            $this->makeThumbStorage($thumbFile, $thumbPath, $width, $height, $options);
        }
        return \Yii::$app->get("fileStorage")->getPathUrl($thumbPath);
    }

    /**
     * Generates a thumbnail filename.
     *
     * @return string
     */
    protected function getThumbFilename($width, $height, $options)
    {
        return 'thumb_' . $this->primaryKey . '_' . $width . 'x' . $height . '_' . $options['offset'][0] . '_' . $options['offset'][1] . '_' . $options['mode'] . '.' . $options['extension'];
    }

    /**
     * Returns the default thumbnail options.
     *
     * @return array
     */
    protected function getDefaultThumbOptions($overrideOptions = [])
    {
        $defaultOptions = [
            'mode' => 'auto',
            'offset' => [
                0,
                0
            ],
            'quality' => 95,
            'extension' => 'jpg'
        ];

        if (! is_array($overrideOptions)) {
            $overrideOptions = [
                'mode' => $overrideOptions
            ];
        }

        $options = array_merge($defaultOptions, $overrideOptions);

        $options['mode'] = strtolower($options['mode']);

        if ((strtolower($options['extension'])) == 'auto') {
            $options['extension'] = strtolower($this->extension);
        }

        return $options;
    }

    /**
     * @todo-hass  用到temp文件夹最好使用localfilesystem
     */
    protected function makeThumbStorage($thumbFile, $thumbPath, $width, $height, $options)
    {
        $tempThumb = $this->getTempDirectory().DIRECTORY_SEPARATOR.$thumbFile;

        /**
         *1.首先得把文件保存到temps文件夹中
         *2.缩略图完成后.再保存到目标目录中
         */


        if(!\Yii::$app->get("fileStorage")->has($this->getPath()))
        {
            return ;
        }

         \Yii::$app->get("fileStorage")->getFileSystem()->copy($this->getPath(), $tempThumb);

         Image::thumbnail(\Yii::$app->get("fileStorage")->getPath($tempThumb), $width, $height)->save(\Yii::$app->get("fileStorage")->getPath($thumbPath));

         \Yii::$app->get("fileStorage")->delete($tempThumb);
    }

    public function deleteThumbs()
    {
        $collection = $this->getThumbs();
        if (! empty($collection)) {
            \Yii::$app->get("fileStorage")->deleteFiles($collection);
        }
    }

    public function getThumbs()
    {
        $pattern = 'thumb_' . $this->primaryKey . '_';

        $directory = $this->getStorageDirectory() . DIRECTORY_SEPARATOR . $this->getPartitionDirectory();
        $allFiles = \Yii::$app->get("fileStorage")->listFolderContents($directory);

        $collection = [];
        foreach ($allFiles as $file) {
            if (StringHelper::startsWith($file["basename"], $pattern)) {
                $collection[] = $file["path"];
            }
        }
        return $collection;
    }



}
