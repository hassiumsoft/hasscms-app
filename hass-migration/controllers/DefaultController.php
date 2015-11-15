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
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 1.0
 */
class DefaultController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $initialTabLevel = 0;
        $output = new OutputString(['tabLevel' => $initialTabLevel]);
        $output_drop = new OutputString();
        $tables_value = '';
        if (isset($_POST['MigrationUtility'])) {
            $array = [];
            $array['inserts'] = [];
            $array['fk'] = [];
            $array['indexes'] = [];

            $foreignKeyOnUpdate = $_POST['MigrationUtility']['ForeignKeyOnUpdate'];
            $foreignKeyOnDelete = $_POST['MigrationUtility']['ForeignKeyOnDelete'];
            $tables_value = $_POST['MigrationUtility']['tables'];
            $ifThen = 1; //$_POST['MigrationUtility']['addIfThenStatements'];
            $addTableInserts = $_POST['MigrationUtility']['addTableInserts'];
            $tableOptions = [];
            $tableOptions['mysql'] = [$_POST['MigrationUtility']['mysql'], $_POST['MigrationUtility']['mysql_options']];
            $tableOptions['mssql'] = [$_POST['MigrationUtility']['mssql'], $_POST['MigrationUtility']['mssql_options']];
            $tableOptions['pgsql'] = [$_POST['MigrationUtility']['pgsql'], $_POST['MigrationUtility']['pgsql_options']];
            $tableOptions['sqlite'] = [$_POST['MigrationUtility']['sqlite'], $_POST['MigrationUtility']['sqlite_options']];

            $tables = trim($tables_value);
            $tables = preg_replace('/\s+/', ',', $tables);
            $tables = explode(',', $tables);

            $output->addStr('$tables = Yii::$app->db->schema->getTableNames();');
            $output->addStr('$dbType = $this->db->driverName;');

            foreach ($tableOptions as $k => $item) {
                $output->addStr('$tableOptions_' . $k . ' = "' . (($item[0]) ? $item[1] : '') . '";');
            }

            foreach ($tables as $table) {
                if (empty($table)) {
                    continue;
                }
                $columns = \Yii::$app->db->getTableSchema($table);
                $prefix = \Yii::$app->db->tablePrefix;
                $table_prepared = str_replace($prefix, '', $table);
                $output->tabLevel = $initialTabLevel;
                foreach ($tableOptions as $dbType => $item) {
                    if (!$item[0]) {
                        continue;
                    }

                    $output->addStr('/* ' . strtoupper($dbType) . ' */');
                    $output->addStr('if (!in_array(\'' . $table . '\', $tables))  { ');
                    if ($ifThen) {
                        $output->addStr('if ($dbType == "' . $dbType . '") {');
                        $output->tabLevel++;
                    }
                    $output->addStr('$this->createTable(\'{{%' . $table_prepared . '}}\', [');
                    $output->tabLevel++;
                    // Ordinary columns
                    $k = 0;
                    foreach ($columns->columns as $column) {
                        $appUtility = new AppUtility($column, $dbType);
                        $output->addStr($appUtility->string . "',");
                        if ($column->isPrimaryKey) {
                            $output->addStr($k . " => 'PRIMARY KEY (`" . $column->name . "`)',");
                        }
                        $k++;

                    }

                    $output->tabLevel--;
                    $output->addStr('], $tableOptions_' . strtolower($dbType) . ');');
                    if (in_array($dbType, ['mysql', 'mssql', 'pgsql']) && !empty($columns->foreignKeys)) {
                        foreach ($columns->foreignKeys as $fk) {
                            $link_table = '';
                            foreach ($fk as $k => $v) {
                                if ($k == '0') {
                                    $link_table = $v;
                                } else {
                                    $link_to_column = $k;
                                    $link_column = $v;
                                    $str = '$this->addForeignKey(';
                                    $str .= '\'fk_' . $link_table . '_' . explode('.', microtime('usec'))[1] . '_' . substr("000" . sizeof($array['fk']), 2) . "',";
                                    $str .= '\'{{%' . $table . '}}\', ';
                                    $str .= '\'' . $link_to_column . '\', ';
                                    $str .= '\'{{%' . $link_table . '}}\', ';
                                    $str .= '\'' . $link_column . '\', ';
                                    $str .= '\'' . $foreignKeyOnDelete . '\', ';
                                    $str .= '\'' . $foreignKeyOnUpdate . '\' ';
                                    $str .= ');';
                                    $array['fk'][] = $str;

                                }
                            }
                        }


                    }

                    $table_indexes = Yii::$app->db->createCommand('SHOW INDEX FROM `' . $table . '`')->queryAll();

                    foreach ($table_indexes as $item) {
                        if ($item['Key_name'] != 'PRIMARY' && $item['Seq_in_index'] == 1) {

                            $unique = ($item['Non_unique']) ? '' : '_UNIQUE';
                            $array['indexes'][] = [
                                'name'   => 'idx' . $unique . '_' . $item['Column_name'] . '_' . explode('.', microtime('usec'))[1] . '_' . substr("000" . sizeof($array['indexes']), -2),
                                'unique' => (($item['Non_unique']) ? 0 : 1),
                                'column' => $item['Column_name'],
                                'table'  => $item['Table'],
                            ];
                        }
                    }

                    if ($ifThen) {
                        $output->tabLevel--;
                        $output->addStr('}');
                    }
                    $output->addStr('}');
                    $output->addStr(' ');

                }

                if ($addTableInserts) {
                    $data = Yii::$app->db->createCommand('SELECT * FROM `' . $table . '`')->queryAll();
                    foreach ($data as $row) {
                        $out = '$this->insert(\'{{%' . $table . '}}\',[';
                        foreach ($columns->columns as $column) {
                            $out .= "'" . $column->name . "'=>'" . addslashes($row[ $column->name ]) . "',";
                        }
                        $out = rtrim($out, ',') . ']);';
//                        $output->addStr($out);
                        $array['inserts'][] = $out;

                    }
                }

            }

            /* INDEXES */
            if (sizeof($array['indexes'])) {
                $output->addStr(' ');
                foreach ($array['indexes'] as $item) {
                    $str = '$this->createIndex(\'' . $item['name'] . '\',\'' . $item['table'] . '\',\'' . $item['column'] . '\',' . $item['unique'] . ');';
                    $output->addStr($str);
                }
            }

            /* FK */
            if (sizeof($array['fk'])) {
                $output->addStr(' ');
                $output->addStr('$this->execute(\'SET foreign_key_checks = 0\');');
                foreach ($array['fk'] as $item) {
                    $output->addStr($item);
                }
                $output->addStr('$this->execute(\'SET foreign_key_checks = 1;\');');
            }

            /* INSERTS */
            if (sizeof($array['inserts'])) {
                $output->addStr(' ');
                $output->addStr('$this->execute(\'SET foreign_key_checks = 0\');');
                foreach ($array['inserts'] as $item) {
                    $output->addStr($item);
                }
                $output->addStr('$this->execute(\'SET foreign_key_checks = 1;\');');
            }

            /* DROP TABLE */
            foreach ($tables as $table) {
                if (!empty($table)) {
//                    $output_drop->addStr('$this->dropTable(\'' . $table . '\');');
                    $output_drop->addStr('$this->execute(\'SET foreign_key_checks = 0\');');
                    $output_drop->addStr('$this->execute(\'DROP TABLE IF EXISTS `' . $table . '`\');');
                    $output_drop->addStr('$this->execute(\'SET foreign_key_checks = 1;\');');
                }
            }
        }
        $model = new MigrationUtility();
        $model->tables = $tables_value;

        /* Save Post state */
        if (isset($_POST['MigrationUtility'])) {
            foreach ($_POST['MigrationUtility'] as $k => $v) {
                $model[ $k ] = $v;
            }

//            print_r($model->attributes); exit;
        }

        return $this->render(
            'index',
            [
                'model'       => $model,
                'output'      => $output->output(),
                'output_drop' => $output_drop->output(),
                'tables'      => self::getTables()
            ]
        );
    }


    protected function mysql_direct($table)
    {
        print_r(Yii::$app->db);
        exit;

        $link = mysql_connect('mysql_host', 'mysql_user', 'mysql_password')
        or die('Could not connect: ' . mysql_error());
        echo 'Connected successfully';
        mysql_select_db('my_database') or die('Could not select database');

// Performing SQL query
        $query = 'SELECT * FROM my_table';
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
        echo "<table>\n";
        while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
            echo "\t<tr>\n";
            foreach ($line as $col_value) {
                echo "\t\t<td>$col_value</td>\n";
            }
            echo "\t</tr>\n";
        }
        echo "</table>\n";

// Free resultset
        mysql_free_result($result);

// Closing connection
        mysql_close($link);

    }

    /**
     * @return \string[]
     */
    public function getTables()
    {
        return \Yii::$app->db->getSchema()->getTableNames('', TRUE);
    }

}

/**
 * Class OutputString
 *
 * @author  Nils Lindentals <nils@dfworks.lv>
 *
 * @package c006\utility\migration\controllers
 */
class OutputString extends Object
{

    /**
     * @var string
     */
    public $nw = "\n";

    /**
     * @var string
     */
    public $tab = "\t";

    /**
     * @var string
     */
    public $outputStringArray = array();

    /**
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
