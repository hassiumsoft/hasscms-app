<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\frontend\twig;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


class DebugExtension extends \Twig_Extension 
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $options = [
            'needs_environment' => false,
            'needs_context' => false,
            'is_variadic' => false,
            'is_safe' => ['html'],
            'is_safe_callback' => null,
            'node_class' => 'Twig_Node_Expression_Function',
            'deprecated' => false,
            'alternative' => null,
        ];
        $functions = [
            new \Twig_SimpleFunction('pr','pr', $options),
            new \Twig_SimpleFunction('pc', 'pc', $options),
        ];
    
        return $functions;
    }
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'hass-debug';
    }
}