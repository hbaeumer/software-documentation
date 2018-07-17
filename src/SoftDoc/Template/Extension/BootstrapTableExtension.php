<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 30.05.18
 * Time: 00:41
 */

namespace Hbaeumer\SoftDoc\Template\Extension;


use Twig_Extension;

class BootstrapTableExtension extends Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('table', [$this, 'createTable'], ['is_safe' => ['html']])
        ];
    }


    public function createTable(array $content, string $caption = null, array $head)
    {


        $string = '<table class="table">';
        if (is_string($caption)) {
            $string .= '<caption><h4>'. $caption. '</h4></caption>';
        }
        $string .= '<tr>';
        foreach (array_values($head) as $headValue) {
            $string .= '<th>'.$headValue.'</th>';
        }
        $horst = null;
        $string .= '</tr>';
        foreach ($content as $value) {
            $string .= '<tr>';

            foreach (array_keys($head) as $key) {
                if (array_key_exists($key, $value)) {
                    $string .= '<td>'.$value[$key].'</td>';
                }
            }
            $foo = null;
            $string .= '</tr>';
        }

        $string .= '</table>';

        return $string;

    }



}