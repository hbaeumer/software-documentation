<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Template\Extension;


use Hbaeumer\SoftDoc\Reader\Method;
use Hbaeumer\SoftDoc\Reader\PdependReader;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflection\ReflectionMethod;
use Roave\BetterReflection\Reflection\ReflectionParameter;
use Roave\BetterReflection\Reflection\ReflectionProperty;
use Roave\BetterReflection\Reflector\ClassReflector;

final class ClassSynopsis extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('class_synopsis', [$this, 'createClassSynopsis'], ['is_safe' => ['html']]),
            new \Twig_SimpleFilter('metric_table', [$this, 'metricTable'], ['is_safe' => ['html']])
        ];
    }

    public function metricTable(ReflectionClass $class)
    {
        $string = '<table class="table">';
        $string .= '<caption><h4>'.$class->getShortName().'</h4></caption>';
        $string .= '<thead>';
        $string .= '<tr>';
        $string .= '<th></th><th>CCN</th><th>CCN2</th><th>CLOC</th><th>ELOC</th><th>LLOC</th><th>LOC</th><th>NLOC</th><th>NPATH</th>';
        $string .= '</tr>';
        $string .= '</thead>';
        $reader = new PdependReader(__DIR__. '/../../../../build/reports/summary.xml');

        foreach ($class->getMethods(\ReflectionProperty::IS_PUBLIC) as $method) {
            $content = $reader->findMethod($method->getDeclaringClass()->getName().'::'.$method->getName());
            $string .= '<tr>';
            $string .= '<td>'.$method->getDeclaringClass()->getShortName().'::'.$method->getName().'</td>';
            if ($content instanceof Method) {
                $string .= '<td>'.$content->getCCN().'</td>';
                $string .= '<td>'.$content->getCCN2().'</td>';
                $string .= '<td>'.$content->getCloc().'</td>';
                $string .= '<td>'.$content->getEloc().'</td>';
                $string .= '<td>'.$content->getLloc().'</td>';
                $string .= '<td>'.$content->getLoc().'</td>';
                $string .= '<td>'.$content->getNloc().'</td>';
                $string .= '<td>'.$content->getNpath().'</td>';
            }
            $string .= '</tr>';
            ;
        }

        $string .= '</table>';

        return $string;

    }

    private function hal(ReflectionMethod $method)
    {
        $ast = $method->getBodyAst();

    }

    public function createClassSynopsis(ReflectionClass $classReflector)
    {
        $string = '';
        $string .= 'class '. $classReflector->getShortName();
        $string .= $this->getParents($classReflector);
        $string .= $this->getInterfaces($classReflector);
        $string .= PHP_EOL.'{';
        $string .= PHP_EOL;


        foreach ($classReflector->getConstants() as $key => $constant) {
            $string .= '    '.$classReflector->getShortName().'::'.$key.' = '.$constant.';';
            $string .= PHP_EOL;
        }

        foreach ($classReflector->getProperties(\ReflectionProperty::IS_PUBLIC) as $probs) {
                $string .= '    public $'.$probs->getName(). (($probs->getDefaultValue())?' = \''.$probs->getDefaultValue():'').'\';';
                $string .= PHP_EOL;
//            }
        }

        foreach ($classReflector->getMethods(\ReflectionProperty::IS_PUBLIC) as $method) {

//        if ($method->getModifiers() === \ReflectionProperty::IS_PUBLIC) {
            $paramters = $method->getParameters();
            $array = [];
            /** @var ReflectionParameter $parameter */
            foreach ($paramters as $parameter) {

                $type = ($parameter->getType())??implode('|',$parameter->getDocBlockTypeStrings());

                $array[] = $type.' $'.$parameter->getName();
            }

            $returnTypes = [];
            try {
                foreach ($method->getDocBlockReturnTypes() as $type ) {
                    $returnTypes[(string)$type] =(string)$type;
                }
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
            }

            if ($method->getReturnType()) {
                $returnTypes[(string)$method->getReturnType()] = (string) $method->getReturnType();
            }

            $return = (!empty($returnTypes))?':'.implode('|', $returnTypes):'';




            $string .= '    public '.$method->getName().'('.implode(', ', $array).')'.$return. ';';

            $string .= PHP_EOL;
//        }

        }

        $string .= '}';
//        return $string;
        return $string;
    }

    protected function getParents(ReflectionClass $classReflector)
    {
        $string = '';
        if (!empty($classReflector->getParentClass())) {
            $string .= ' extends ';

            $string .= $classReflector->getParentClass()->getShortName();
        }

        return $string;
    }

    protected function getInterfaces(ReflectionClass $classReflector)
    {
        $string = '';
        if (!empty($classReflector->getInterfaceNames())) {
            $string .= ' implements ';

            $string .= implode(', ', $classReflector->getInterfaceNames());
        }

        return $string;

    }

}