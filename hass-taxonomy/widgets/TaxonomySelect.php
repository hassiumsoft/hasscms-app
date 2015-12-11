<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\taxonomy\widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class TaxonomySelect extends InputWidget
{
    public function init() {
        parent::init();
        TaxonomySelectAsset::register($this->view);
    }

    public function run() {
        return  $this->render('taxonomy', [
            'tree' => Html::getAttributeValue($this->model, $this->attribute),
            "name"=>Html::getInputName($this->model, $this->attribute)
        ]);
    }
}

?>