<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Template\Extension;


use Roave\BetterReflection\Reflection\ReflectionClass;

final class ClassMetricTable
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('metric_table', [$this, 'metricTable'], ['is_safe' => ['html']])
        ];
    }

    public function metricTable(ReflectionClass $class)
    {
        $string = '<table class="table">';
            $string .= '<caption><h4>caption</h4></caption>';
        $string .= '<tr>';
        $string .= '<th></th><th>CN</th><th>CN2</th>';
        $string .= '</tr>';

        $string .= '</table>';

        return $string;

    }

}