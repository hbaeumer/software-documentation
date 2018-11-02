<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 01.06.18
 * Time: 00:11
 */

namespace Hbaeumer\SoftDoc\Template\Extension;


use Twig_Extension;

class MarkdownExtension extends Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdown', [$this, 'markdown'], ['is_safe' => ['html']])
        ];
    }

    public function markdown(string $content): string
    {

        $parseDown = new \Parsedown();

        $string = $parseDown->parse($content);

        return $string;

    }
}