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
    
    public $migrationName = "migration";
    
    public $migrationPath;
       
    public $tableSchemas;
    
    public $tableDatas;

    /**
     * @var string
     */
    public $tableOption = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * @var string
     */
    public $foreignKeyOnDelete = 'CASCADE';

    /**
     * @var string
     */
    public $foreignKeyOnUpdate = 'CASCADE';

    /**
     * @return array
     */
    function rules()
    {
        return [
          [["migrationName","migrationPath","tableSchemas","tableDatas","tableOption","foreignKeyOnDelete","foreignKeyOnUpdate"],'safe']
        ];
    }

    public static function getTableNames()
    {
      $tables = \Yii::$app->db->getSchema()->getTableNames('', TRUE);
      return array_combine($tables,$tables);
    }

}
