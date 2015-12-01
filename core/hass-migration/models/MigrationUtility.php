<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\migration\models;

use yii\base\Model;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class MigrationUtility extends Model
{

    /**
     * @var string
     */
    public $tables = '';

    /**
     * @var string
     */
    public $mysql = TRUE;
    /**
     * @var bool
     */
    public $mssql = FALSE;
    /**
     * @var bool
     */
    public $pgsql = FALSE;
    /**
     * @var bool
     */
    public $sqlite = FALSE;

    /**
     * @var string
     */
    public $mysql_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    /**
     * @var string
     */
    public $mssql_options = '';
    /**
     * @var string
     */
    public $pgsql_options = '';
    /**
     * @var string
     */
    public $sqlite_options = '';


    /**
     * @var array
     */
    public $databaseTables = [];

    /**
     * @var bool
     */
    public $addIfThenStatements = TRUE;

    /**
     * @var string
     */
    public $tableOptions = '';

    /**
     * @var bool
     */
    public $addTableInserts = FALSE;

    /**
     * @var string
     */
    public $ForeignKeyOnDelete = 'CASCADE';

    /**
     * @var string
     */
    public $ForeignKeyOnUpdate = 'NO ACTION';

    /**
     * @return array
     */
    function rules()
    {
        return [
            [['tables', 'databaseTables', 'databaseType'], 'required'],
            ['tableOptions', 'default', 'value' => '']
        ];
    }


}
