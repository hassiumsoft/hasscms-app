<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace hass\gii\generators\extension;

use Yii;
use yii\gii\CodeFile;

/**
 * This generator will generate the skeleton files needed by an extension.
 *
 * @property string $keywordsArrayJson A json encoded array with the given keywords. This property is
 * read-only.
 * @property boolean $outputPath The directory that contains the module class. This property is read-only.
 *
 * @author Tobias Munk <schmunk@usrbin.de>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\extension\Generator
{
    public $vendorName="hassium";
    public $packageName = "hass-";
    public $namespace = "hass\\";
    public $type = "hass-core";
    public $keywords = "hass,hass plugin,hass theme,yii2,extension";
    public $title;
    public $description;
    public $outputPath = "@app/packages";
    public $license="GPL-3.0+";
    public $authorName="zhepama";
    public $authorEmail="zhepama@gmail.com";




    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $modulePath = $this->getOutputPath();
        $files[] = new CodeFile(
            $modulePath . '/' . $this->packageName . '/composer.json',
            $this->render("composer.json")
        );
        $files[] = new CodeFile(
            $modulePath . '/' . $this->packageName . '/AutoloadExample.php',
            $this->render("AutoloadExample.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/' . $this->packageName . '/README.md',
            $this->render("README.md")
        );


        $command = "<?php \n";
        $command .= "exec('composer config repositories.".$this->packageName." path ".realpath(\Yii::getAlias($this->outputPath)).DIRECTORY_SEPARATOR.$this->packageName."');\n";
        $command .= "exec('composer require {$this->vendorName}/{$this->packageName}:*@dev"."');\n";
        $command .= "exec('composer update {$this->vendorName}/{$this->packageName}"." -vvv ');\n";
        $command .= "exec('composer dump-autoload --optimize');\n";

     // file_put_contents($modulePath.'/update-create.php', $command);

      return $files;
    }



    /**
     * @return array options for type drop-down
     */
    public function optsType()
    {
        $licenses = [
            'hass-core',
            'hass-plugin',
            'hass-theme',
            'yii2-extension',
            'library',
        ];

        return array_combine($licenses, $licenses);
    }


}
