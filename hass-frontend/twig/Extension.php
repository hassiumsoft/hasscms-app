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


class Extension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * Creates new instance
     *
     * @param array $uses namespaces and classes to use in the template
     */
    public function __construct()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $options = [
            'is_safe' => ['html'],
        ];
        
        $class = new \ReflectionClass("\\hass\\frontend\\helpers\\ViewHelper");
        
        $methods  =  $class->getMethods(\ReflectionMethod::IS_STATIC);
        
        $functions = [];
        
        foreach ($methods  as $method)
        {
            $functions[] = new \Twig_SimpleFunction($method->name, ["\\hass\\frontend\\helpers\\ViewHelper", $method->name], $options);
        }
       
        return $functions;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'hass-twig';
    }
}