<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 20.06.18
 * Time: 21:37
 */

namespace Hbaeumer\SoftDoc\Template\Extension;


use phpDocumentor\Descriptor\ClassDescriptor;
use Twig_Extension;

class SidebarMultilevel extends Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('table', [$this, 'createUl'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param ClassDescriptor[]
     */
    public function createUl(array $class)
    {
        var_dump($class);



    }

}