<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace hass\area\shortcode;
use Maiorano\Shortcodes\Contracts\ShortcodeInterface;
use Maiorano\Shortcodes\Contracts\AliasInterface;
use Maiorano\Shortcodes\Contracts\ContainerAwareInterface;
use Maiorano\Shortcodes\Contracts\Traits\Shortcode;
use Maiorano\Shortcodes\Contracts\Traits\Alias;
use Maiorano\Shortcodes\Contracts\Traits\ContainerAware;
use hass\area\models\Area;
use yii\helpers\Html;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 1.0
*/
class AreaShortcode implements ShortcodeInterface, AliasInterface, ContainerAwareInterface
{
    use Shortcode,   Alias, ContainerAware;
    /**
     * @var string
     */
    protected $name = "area";

    /**
     * @var array
     */
    protected $alias = [];
    /**
     * @var \Maiorano\Shortcodes\Manager\ManagerInterface
    */
    protected $manager;

    /**
     * @param string $name
     * @param array $atts
     * @param callable $callback
     */
    public function __construct()
    {
    }

    public function handle($content = null, array $atts = [])
    {
        $id = $atts["id"];

        $headerClass  =  isset($atts["headerclass"])?$atts["headerclass"]:"";
        $bodyClass  =  isset($atts["bodyclass"])?$atts["bodyclass"]:"";
        $blockClass  =  isset($atts["blockclass"])?$atts["blockclass"]:"";


       $model =  Area::findOne($id);

       $blocks = $model->getBlocks();
       $result = "";
       foreach ($blocks as $block)
       {
           $widget = $block["widget"];

            $header = Html::tag("h3",$block->title);

            $content = Html::tag("div",$header,["class"=>$headerClass]);

           $body =$widget::widget(["model"=>$block]);
           $content .= Html::tag("div",$body,["class"=>$bodyClass]);

           $result .= Html::tag("div",$content,["class"=>$blockClass]);
       }

       return $result;
    }
}