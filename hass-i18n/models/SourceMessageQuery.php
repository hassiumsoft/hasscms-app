<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\i18n\models;

use Yii;
use yii\db\ActiveQuery;
use hass\i18n\models\Message;
use hass\i18n\Module;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


class SourceMessageQuery extends ActiveQuery
{
    public function notTranslated()
    {
        $messageTableName = Message::tableName();
        $query = Message::find()->select($messageTableName . '.id');
        $i = 0;
        foreach (Module::getInstallLanguages() as $language) {
            if ($i === 0) {
                $query->andWhere($messageTableName . '.language = :language and ' . $messageTableName . '.translation is not null', [':language' => $language]);
            } else {
                $query->innerJoin($messageTableName . ' t' . $i, 't' . $i . '.id = ' . $messageTableName . '.id and t' . $i . '.language = :language and t' . $i . '.translation is not null', [':language' => $language]);
            }
            $i++;
        }
        $ids = $query->indexBy('id')->all();
        $this->andWhere(['not in', 'id', array_keys($ids)]);
        return $this;
    }

    public function translated()
    {
        $messageTableName = Message::tableName();
        $query = Message::find()->select($messageTableName . '.id');
        $i = 0;
        foreach (Module::getInstallLanguages() as $language) {
            if ($i === 0) {
                $query->andWhere($messageTableName . '.language = :language and ' . $messageTableName . '.translation is not null', [':language' => $language]);
            } else {
                $query->innerJoin($messageTableName . ' t' . $i, 't' . $i . '.id = ' . $messageTableName . '.id and t' . $i . '.language = :language and t' . $i . '.translation is not null', [':language' => $language]);
            }
            $i++;
        }
        $ids = $query->indexBy('id')->all();
        $this->andWhere(['in', 'id', array_keys($ids)]);
        return $this;
    }
}
