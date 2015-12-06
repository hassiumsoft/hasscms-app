<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\rbac\controllers;

use hass\base\BaseController;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;
use yii\helpers\Inflector;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class ToolController extends BaseController
{

    public function actionIndex()
    {
        $namespaces = \HassClassLoader::getHassCoreFile();
        
        $result = [];
        
        foreach ($namespaces as $namespace => $dir) {
            $controllerDir = $dir . DIRECTORY_SEPARATOR . "controllers";
            
            if (! is_dir($controllerDir)) {
                continue;
            }
            $files = FileHelper::findFiles($controllerDir);
            
            $moduleId = trim(substr($namespace, strrpos(rtrim($namespace, "\\"), "\\")), "\\");
            $result[$moduleId]["module"] = $moduleId;
            $result[$moduleId]["permissions"] = [];
            
            foreach ($files as $file) {
                
                $childDir = rtrim(pathinfo(substr($file, strpos($file, "controllers")+12),PATHINFO_DIRNAME),".");
       
                if($childDir)
                {
                    $class = $namespace . "controllers\\".str_replace("/", "\\", $childDir)."\\" . rtrim(basename($file), ".php");
           
                }
                else 
                {
                    $class = $namespace . "controllers\\". rtrim(basename($file), ".php");
                }
            
                $controllerId = Inflector::camel2id(str_replace("Controller", "", pathinfo($file, PATHINFO_FILENAME)));
                                
                $reflect = new \ReflectionClass($class);
                
                $methods = $reflect->getMethods(\ReflectionMethod::IS_PUBLIC);
                
                /** @var \ReflectionMethod $method */
                foreach ($methods as $method) {
                    if (! StringHelper::startsWith($method->name, "action")) {
                        continue;
                    }
                    
                    if ($method->name == "actions") {
                        $object = \Yii::createObject([
                            "class" => $class
                        ], [
                            $controllerId,
                            $moduleId
                        ]);
                        $actions = $method->invoke($object);
                        foreach ($actions as $actionId => $config) {
                            
                            $route = $moduleId . "/" . $controllerId . "/" . $actionId;
                            if($childDir)
                            {
                                $route = $moduleId . "/".$childDir."/" . $controllerId . "/" . $actionId;
                            }
                        
                            
                            $result[$moduleId]["permissions"][$route] = [
                                "type" => 2,
                                "description" => Inflector::camel2words($actionId)
                            ];
                        }
                        continue;
                    }
                    
                    $actionId = Inflector::camel2id(substr($method->name, 6));
                    
                    $route = $moduleId . "/" . $controllerId . "/" . $actionId;
                    
                    if($childDir)
                    {
                        $route = $moduleId . "/".$childDir."/" . $controllerId . "/" . $actionId;
                    }
                    
                    $result[$moduleId]["permissions"][$route] = [
                        "type" => 2,
                        "description" => Inflector::camel2words(substr($method->name, 6))
                    ];
                }
                
        
            }
        }
        $result = "<?php \n return ".var_export($result,true).";";
        file_put_contents(dirname(__DIR__)."/permissions.php", $result);
    }
}