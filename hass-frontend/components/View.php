<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\components;

use yii\base\InvalidParamException;
use yii\helpers\FileHelper;
use Yii;
use yii\helpers\Html;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class View extends \yii\web\View
{

    private $_viewFiles = [];

    public function renderRead($pathMap, $params = [], $context = null)
    {
        foreach ($pathMap as $viewFile) {
            
            $viewFile = $this->findViewFile($viewFile, $context);
            $viewFile = $this->findViewFileByDefault($viewFile);
            if (is_file($viewFile)) {
                break;
            }
        }
        
        if ($viewFile == null) {
            throw new InvalidParamException("The view file does not exist: $viewFile");
        }
        
        return $this->renderFile($viewFile, $params, $context);
    }

    public function findViewFileByDefault($viewFile)
    {
        $viewFile = Yii::getAlias($viewFile);
        // defaultExtension>php
        $pathParts = pathinfo($viewFile);
        if ($pathParts["extension"] == 'php') {
            $path = $pathParts["dirname"] . DIRECTORY_SEPARATOR . $pathParts["filename"] . '.' . $this->defaultExtension;
            
            if ($this->theme !== null) {
                $path = $this->theme->applyTo($path);
            }
            
            if (is_file($path)) {
                $viewFile = $path;
            } else {
                if ($this->theme !== null) {
                    $viewFile = $this->theme->applyTo($viewFile);
                }
            }
        }
        
        return $viewFile;
    }

    /**
     * Renders a view file.
     *
     * If [[theme]] is enabled (not null), it will try to render the themed version of the view file as long
     * as it is available.
     *
     * The method will call [[FileHelper::localize()]] to localize the view file.
     *
     * If [[renderers|renderer]] is enabled (not null), the method will use it to render the view file.
     * Otherwise, it will simply include the view file as a normal PHP file, capture its output and
     * return it as a string.
     *
     * @param string $viewFile
     *            the view file. This can be either an absolute file path or an alias of it.
     * @param array $params
     *            the parameters (name-value pairs) that will be extracted and made available in the view file.
     * @param object $context
     *            the context that the view should use for rendering the view. If null,
     *            existing [[context]] will be used.
     * @return string the rendering result
     * @throws InvalidParamException if the view file does not exist
     */
    public function renderFile($viewFile, $params = [], $context = null)
    {
        $viewFile = $this->findViewFileByDefault($viewFile);
        
        if (is_file($viewFile)) {
            $viewFile = FileHelper::localize($viewFile);
        } else {
            throw new InvalidParamException("The view file does not exist: $viewFile");
        }
        
        $oldContext = $this->context;
        if ($context !== null) {
            $this->context = $context;
        }
        $output = '';
        $this->_viewFiles[] = $viewFile;
        
        if ($this->beforeRender($viewFile, $params)) {
            Yii::trace("Rendering view file: $viewFile", __METHOD__);
            $ext = pathinfo($viewFile, PATHINFO_EXTENSION);
            if (isset($this->renderers[$ext])) {
                if (is_array($this->renderers[$ext]) || is_string($this->renderers[$ext])) {
                    $this->renderers[$ext] = Yii::createObject($this->renderers[$ext]);
                }
                /* @var $renderer ViewRenderer */
                $renderer = $this->renderers[$ext];
                $output = $renderer->render($this, $viewFile, $params);
            } else {
                $output = $this->renderPhpFile($viewFile, $params);
            }
            $this->afterRender($viewFile, $params, $output);
        }
        
        array_pop($this->_viewFiles);
        $this->context = $oldContext;
        
        return $output;
    }

    public function getViewFile()
    {
        return end($this->_viewFiles);
    }

    /**
     *
     * @param string $title            
     * @param string $keywords            
     * @param string $description            
     */
    public function setMetaData($title = "",  $description = "",$keywords = "")
    {
        $this->registerMetaTag([
            'name' => 'description',
            'content' => Html::encode($description)
        ]);
        
        $this->registerMetaTag([
            'name' => 'keywords',
            'content' => Html::encode($keywords)
        ]);
        
        $this->title = ! empty($title) ? $title . ' - ' . Yii::$app->name : Yii::$app->name;
    }
}
