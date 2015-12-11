<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\migration\controllers;

use hass\migration\models\MigrationUtility;
use Yii;
use yii\base\Object;
use hass\migration\AppUtility;
use hass\frontend\BaseController;
use yii\helpers\FileHelper;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DefaultController extends BaseController
{

    /**
     * @hass-todo 没有添加事务
     * @return string
     */
    public function actionIndex()
    {
        $model = new MigrationUtility();
        $upStr = new OutputString();
        $downStr = new OutputString();
        
        if ($model->load(\Yii::$app->getRequest()
            ->post())) {
            
            if (! empty($model->tableSchemas)) {
                list ($up, $down) = $this->generalTableSchemas($model->tableSchemas, $model->tableOption, $model->foreignKeyOnUpdate, $model->foreignKeyOnDelete);
                $upStr->outputStringArray = array_merge($upStr->outputStringArray, $up->outputStringArray);
                $downStr->outputStringArray = array_merge($downStr->outputStringArray, $down->outputStringArray);
            }
            
            if (! empty($model->tableDatas)) {
                list ($up, $down) = $this->generalTableDatas($model->tableDatas);
                $upStr->outputStringArray = array_merge($upStr->outputStringArray, $up->outputStringArray);
                $downStr->outputStringArray = array_merge($downStr->outputStringArray, $down->outputStringArray);
            }
            
            $path = Yii::getAlias($model->migrationPath);
            if (! is_dir($path)) {
                FileHelper::createDirectory($path);
            }
            
            $name = 'm' . gmdate('ymd_His') . '_' . $model->migrationName;
            $file = $path . DIRECTORY_SEPARATOR . $name . '.php';
            
            $content = $this->renderFile(Yii::getAlias("@hass/migration/views/migration.php"), [
                'className' => $name,
                'up' => $upStr->output(),
                'down' => $downStr->output()
            ]);
            file_put_contents($file, $content);
            $this->flash("success", "迁移成功，保存在".$file);            
        }
        
        if ($model->migrationPath == null) {
            $model->migrationPath = $this->module->migrationPath;
        }
        
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function generalTableSchemas($tables, $tableOption, $foreignKeyOnUpdate, $foreignKeyOnDelete)
    {
        $initialTabLevel = 0;
        $upStr = new OutputString([
            'tabLevel' => $initialTabLevel
        ]);
        
        $upStr->addStr('$this->execute(\'SET foreign_key_checks = 0\');');
        $upStr->addStr(' ');
        foreach ($tables as $table) {
            $upStr->tabLevel = $initialTabLevel;
            
            $prefix = \Yii::$app->db->tablePrefix;
            $table_prepared = str_replace($prefix, '', $table);
            
            // 添加表结构
            $upStr->addStr('$this->createTable(\'{{%' . $table_prepared . '}}\', [');
            $upStr->tabLevel ++;
            $k = 0;
            $tableSchema = \Yii::$app->db->getTableSchema($table);
            

            foreach ($tableSchema->columns as $column) {
                $appUtility = new AppUtility($column);
                $upStr->addStr($appUtility->string . "',");
            }
            if(!empty($tableSchema->primaryKey))
            {
                $upStr->addStr("'PRIMARY KEY (`" . implode("`,`", $tableSchema->primaryKey) . "`)'");
            }

            $upStr->tabLevel --;
            $upStr->addStr('], "' . $tableOption . '");');
            
            // 添加外键
            if (! empty($tableSchema->foreignKeys)) {
                $upStr->addStr(' ');
                $yy = 0;
                foreach ($tableSchema->foreignKeys as $fk) {
                    $link_table = '';
                    $ii = 0;
                    foreach ($fk as $k => $v) {
                        if ($k == '0') {
                            $link_table = $v;
                        } else {
                            $link_to_column = $k;
                            $link_column = $v;
                            $str = '$this->addForeignKey(';
                            $str .= '\'fk_' . $link_table . '_' . explode('.', microtime('usec'))[1] . '_' . $yy.$ii . "',";
                            $str .= '\'{{%' . $table . '}}\', ';
                            $str .= '\'' . $link_to_column . '\', ';
                            $str .= '\'{{%' . $link_table . '}}\', ';
                            $str .= '\'' . $link_column . '\', ';
                            $str .= '\'' . $foreignKeyOnDelete . '\', ';
                            $str .= '\'' . $foreignKeyOnUpdate . '\' ';
                            $str .= ');';
                            $upStr->addStr($str);
                        }
                        $ii ++;
                    }
                    $yy++;
                }
            }
            
            // 添加索引
            $tableIndexes = Yii::$app->db->createCommand('SHOW INDEX FROM `' . $table . '`')->queryAll();
            $ii = 0;
            foreach ($tableIndexes as $item) {
                if ($item['Key_name'] != 'PRIMARY' && $item['Seq_in_index'] == 1) {
                    if ($ii == 0) {
                        $upStr->addStr(' ');
                    }
                    $unique = ($item['Non_unique']) ? '' : '_UNIQUE';
                    $item = [
                        'name' => 'idx' . $unique . '_' . $item['Column_name'] . '_' . explode('.', microtime('usec'))[1] . '_' . $ii,
                        'unique' => (($item['Non_unique']) ? 0 : 1),
                        'column' => $item['Column_name'],
                        'table' => $item['Table']
                    ];
                    $str = '$this->createIndex(\'' . $item['name'] . '\',\'' . $item['table'] . '\',\'' . $item['column'] . '\',' . $item['unique'] . ');';
                    $upStr->addStr($str);
                    $ii ++;
                }
            }
            
            $upStr->addStr(' ');
        }
        $upStr->addStr('$this->execute(\'SET foreign_key_checks = 1;\');');
        
        $downStr = new OutputString();
        /* DROP TABLE */
        $downStr->addStr('$this->execute(\'SET foreign_key_checks = 0\');');
        foreach ($tables as $table) {
            if (! empty($table)) {
                $downStr->addStr('$this->execute(\'DROP TABLE IF EXISTS `' . $table . '`\');');
            }
        }
        $downStr->addStr('$this->execute(\'SET foreign_key_checks = 1;\');');
        
        return [
            $upStr,
            $downStr
        ];
    }

    public function generalTableDatas($tables)
    {
        $initialTabLevel = 0;
        $upStr = new OutputString([
            'tabLevel' => $initialTabLevel
        ]);
        $upStr->addStr('$this->execute(\'SET foreign_key_checks = 0\');');
        $upStr->addStr(' ');
        foreach ($tables as $table) {
            $upStr->addStr('/* Table ' . $table . ' */');
            $tableSchema = \Yii::$app->db->getTableSchema($table);
            $data = Yii::$app->db->createCommand('SELECT * FROM `' . $table . '`')->queryAll();
            foreach ($data as $row) {
                $out = '$this->insert(\'{{%' . $table . '}}\',[';
                foreach ($tableSchema->columns as $column) {
                    $out .= "'" . $column->name . "'=>'" . addslashes($row[$column->name]) . "',";
                }
                $out = rtrim($out, ',') . ']);';
                $upStr->addStr($out);
            }
            $upStr->addStr(' ');
        }
        $upStr->addStr('$this->execute(\'SET foreign_key_checks = 1;\');');
        $downStr = new OutputString();
        return [
            $upStr,
            $downStr
        ];
    }
}

/**
 * Class OutputString
 *
 * @author Nils Lindentals <nils@dfworks.lv>
 *        
 * @package c006\utility\migration\controllers
 */
class OutputString extends Object
{

    /**
     *
     * @var string
     */
    public $nw = "\n";

    /**
     *
     * @var string
     */
    public $tab = "\t";

    /**
     *
     * @var string
     */
    public $outputStringArray = array();

    /**
     *
     * @var int
     */
    public $tabLevel = 0;

    /**
     * Adds string to output string array with "tab" prefix
     *
     * @var string $str
     */
    public function addStr($str)
    {
        $str = str_replace($this->tab, '', $str);
        $this->outputStringArray[] = str_repeat($this->tab, $this->tabLevel) . $str;
    }

    /**
     * Returns string output
     */
    public function output()
    {
        return implode($this->nw, $this->outputStringArray);
    }
}
