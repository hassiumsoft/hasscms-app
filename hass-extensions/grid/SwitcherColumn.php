<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\extensions\grid;

use yii\helpers\Html;
use hass\backend\enums\StatusEnum;
use yii\helpers\Url;
use hass\extensions\grid\assets\SwitcherAsset;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 1.0
 */
class SwitcherColumn extends  \hass\extensions\grid\DataColumn
{

    public $reload = 1;

    public function registerClientScript()
    {
        SwitcherAsset::register($this->grid->view);


        $js = <<<'EOT'
			var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
			elems.forEach(function(html) {
			  var switchery = new Switchery(html,{ size: 'small' });
			  jQuery(html).data('switchery', switchery);
			});

		    $('.js-switch').on('change', function(){
		        var switchery =  $(this).data("switchery");
		        switchery.disable();
		        var url =  $(this).data("url");
		        var reload =  $(this).data("reload");
		        var checked =  $(this).is(':checked') ? '1' : '0';
		        $.getJSON( url +'&value=' + checked, function(response){
		            if(response.status == false){
		                alert(response.content);
		                return;
		            }

		            if(reload){
		                location.reload();
		            }else{
		            	notify.success(response.content);
		            	switchery.enable();
		            }
		        });
		    });
EOT;
        $this->grid->view->registerJs($js,\yii\web\View::POS_READY); //因为可能会被pjax加载所以放在这里
    }
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $this->registerClientScript();

        $params = is_array($key) ? $key : ['id' => (string) $key];
        $params[0]='switcher';
        $params["attribute"] =$this->attribute;

        $result =  Html::checkbox('', $this->getDataCellValue($model, $key, $index) == StatusEnum::STATUS_ON, [
            'class' => 'js-switch',
            'data-url' => Url::to($params),
            'data-reload' => $this->reload
        ]);

        return $result;
    }
}
