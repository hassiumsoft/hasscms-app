<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\attachment\components;

use creocoder\flysystem\LocalFilesystem;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class FileStorage extends \yii\base\Component
{

    /**
     *
     * @var string Relative or absolute URL of the Library root folder.
     */
    protected $baseUrl;

    /**
     *
     * @var \creocoder\flysystem\LocalFilesystem
     */
    protected $fileSystem;

    /**
     * medias thumbs users temp
     *
     * {@inheritDoc}
     *
     * @see \yii\base\Object::init()
     */
    public function init()
    {
        if ($this->getFileSystem() == null) {
            $localStroageFolder = self::validatePath(\Yii::$app->get("config")->get('attachment.local.root', '@webroot/storage/uploads'));
            $this->fileSystem = new LocalFilesystem([
                "path" => $localStroageFolder
            ]);
        }
        if ($this->baseUrl == null) {
            $this->setBaseUrl(rtrim(\Yii::$app->get("config")->get('attachment.local.baseurl', '@web/storage/uploads'), '/'));
        }
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setBaseUrl($url)
    {
        $this->baseUrl = \Yii::getAlias($url);
        if (! preg_match("/(\/\/|http|https)/", $this->baseUrl)) {
            $this->baseUrl = \Yii::$app->getRequest()->getHostInfo() . $this->baseUrl;
        }
    }

    public function setFileSystem($config)
    {
        $this->fileSystem = \Yii::createObject($config);
        return $this->fileSystem;
    }

    /**
     *
     * @return \creocoder\flysystem\LocalFilesystem
     */
    public function getFileSystem()
    {
        return $this->fileSystem;
    }

    public static function validatePath($path)
    {
        $path = \Yii::getAlias($path);

        $path = str_replace('\\', '/', $path);
        $path = "/".trim($path, '/');

        return $path;
    }

    /**
     * Checks if directory is empty then deletes it,
     * three levels up to match the partition directory.
     */
    public function deleteEmptyDirectory($folder = null)
    {
        if (! $this->isDirectoryEmpty($folder))
            return false;

        $this->getFileSystem()->deleteDir($folder);

        return true;
    }

    public function isDirectoryEmpty($folder)
    {
        if (!$folder) return null;
        $folder = self::validatePath($folder);
        return count($this->getFilesystem()->listContents($folder)) === 0;
    }

    public function listFolderContents($folder,$filter = null)
    {
        $folder = self::validatePath($folder);

        return $this->getFilesystem()->listContents($folder);
    }

    public function deleteFiles($paths)
    {
        foreach ($paths as $path) {
            $path = self::validatePath($path);
            $this->getFileSystem()->delete($path);
        }
    }


    public function has($path)
    {
        return $this->getFilesystem()->has($path);
    }

    /**
     * 删除文件
     *
     * @param unknown $path
     */
    public function delete($path)
    {
        if ($this->getFilesystem()->has($path) && $this->getFilesystem()->delete($path)) {
            return true;
        }
        return false;
    }

    public function upload($filePath, $newFilePath, $overwrite = false)
    {
        $stream = fopen($filePath, 'r+');

        if ($overwrite) {
            $success = $this->getFilesystem()->putStream($newFilePath, $stream);
        } else {
            $success = $this->getFilesystem()->writeStream($newFilePath, $stream);
        }

        fclose($stream);

        if ($success) {
            return true;
        }

        return false;
    }

    /**
     * Returns a file contents.
     *
     * @param string $path
     *            Specifies the file path relative the the Library root.
     * @return \League\Flysystem\File
     */
    public function get($path)
    {
        $path = self::validatePath($path);
        return $this->getFileSystem()->get($path);
    }

    /**
     * Puts a file to the library.
     *
     * @param string $path
     *            Specifies the file path relative the the Library root.
     * @param string $contents
     *            Specifies the file contents.
     * @return boolean
     */
    public function put($path, $contents)
    {
        $path = self::validatePath($path);
        return $this->getFileSystem()->put($path, $contents);
    }

    public function getPathUrl($path)
    {
        $path = $this->validatePath($path);
        return $this->baseUrl . $path;
    }

    public function getPath($path)
    {
        return $this->getFileSystem()
            ->getAdapter()
            ->applyPathPrefix($path);
    }

    public function getRelativePath($path)
    {
        $storageFolderNameLength = strlen($this->getFileSystem()->path);
        if (substr($path, 0, $storageFolderNameLength) == $this->getFileSystem()->path) {
            return substr($path, $storageFolderNameLength);
        }
        return $path;
    }

    /**
     * Returns a public file path from an absolute one
     * eg: /home/mysite/public_html/welcome -> /welcome
     * @param  string $path Absolute path
     * @return string
     */
    public function urlToPath($url)
    {
        return trim(str_replace([$this->baseUrl,"\\"], ["","/"], $url),'/\\');
    }
}
