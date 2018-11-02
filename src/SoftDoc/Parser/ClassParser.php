<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Parser;


use Roave\BetterReflection\Reflection\ReflectionClass;

final class ClassParser
{
    public function parse(ReflectionClass $reflection)
    {
        $this->createFile($reflection);
    }

    private function createFile(ReflectionClass $reflection)
    {
        $filename = __DIR__.'/'.$reflection->getName().'test.puml';
        var_dump($filename);
        $handle = fopen($filename, 'w+');
        fwrite($handle, '@startuml');
        fwrite($handle, PHP_EOL);

        fwrite($handle, 'class '. $reflection->getName(). '{');
        fwrite($handle, PHP_EOL);

        foreach ($reflection->getProperties() as $probs) {

            if ($probs->getModifiers() === \ReflectionProperty::IS_PUBLIC) {
                fwrite($handle, '+ '.$probs->getName());
                fwrite($handle, PHP_EOL);
            }
        }
        foreach ($reflection->getMethods() as $method) {

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


            $modifier = [
                \ReflectionProperty::IS_PUBLIC => '+',
                \ReflectionProperty::IS_PROTECTED => '#',
                \ReflectionProperty::IS_PRIVATE => '-',
            ];

            fwrite($handle, (($modifier[$method->getModifiers()])??'{static}').' '.$method->getName().'('.implode(', ', $array).')'.$return);

            fwrite($handle, PHP_EOL);
//        }

        }
        fwrite($handle, '}');
        fwrite($handle, PHP_EOL);



//        if ($reflection->getParentClass()) {
//            $parent = $reflection->getParentClass();
//
//            fwrite($handle, 'class '. $parent->getName());
//            fwrite($handle, PHP_EOL);
//            fwrite($handle, $reflection->getParentClass()->getName().' <|-- '. $reflection->getName());
//            fwrite($handle, PHP_EOL);
//            fwrite($handle, PHP_EOL);
////            $this->getInterfaces($parent, $handle);
//        }

        $this->getParent($reflection, $handle);

        $this->getInterfaces($reflection, $handle);

        $this->getTraits($reflection, $handle);




        fwrite($handle, PHP_EOL);
        fwrite($handle, '@enduml');
        fclose($handle);
        var_dump(file_get_contents($filename));


    }

    private function getTraits(ReflectionClass $reflection, $handle)
    {
        foreach ($reflection->getTraits() as $trait) {
            fwrite($handle, PHP_EOL);
            fwrite($handle, 'abstract class ' . $trait->getName().' <<T,orchid>>');
            fwrite($handle, PHP_EOL);
            fwrite($handle, $trait->getName().' <|-- '. $reflection->getName());
            fwrite($handle, PHP_EOL);
        }

    }


    private function getParent(ReflectionClass $reflection, $handle)
    {
        if ($reflection->getParentClass()) {
            $parent = $reflection->getParentClass();


            fwrite($handle, (($parent->isAbstract())?'abstract class ':'class '). $parent->getName());
            fwrite($handle, PHP_EOL);
            fwrite($handle, $reflection->getParentClass()->getName().' <|-- '. $reflection->getName());
            fwrite($handle, PHP_EOL);
            fwrite($handle, PHP_EOL);
//            $this->getInterfaces($parent, $handle);
            $this->getParent($parent, $handle);
            $this->getTraits($parent, $handle);
        }
    }


    private function getInterfaces(ReflectionClass $reflection, $handle)
    {
        foreach ($reflection->getInterfaceNames() as $interface) {
            fwrite($handle, PHP_EOL);
            fwrite($handle, 'interface '. $interface);
            fwrite($handle, PHP_EOL);
            fwrite($handle, $interface.' <|.. '. $reflection->getName());
        }

    }

    private function createFile2(ReflectionClass $reflection)
    {

        $handle = fopen(__DIR__.'/test.puml', 'w+');
        fwrite($handle, '@startuml');
        fwrite($handle, PHP_EOL);

        fwrite($handle, 'class '. $reflection->getName().'{');
        fwrite($handle, PHP_EOL);
//        foreach ($reflection->getProperties() as $probs) {
//
//            if ($probs->getModifiers() === \ReflectionProperty::IS_PUBLIC) {
//                fwrite($handle, '+ '.$probs->getName());
//                fwrite($handle, PHP_EOL);
//            }
//        }
//        foreach ($reflection->getMethods() as $method) {
//
//            if ($method->getModifiers() === \ReflectionProperty::IS_PUBLIC) {
//                $paramters = $method->getParameters();
//                $string = '';
//                /** @var ReflectionParameter $parameter */
//                foreach ($paramters as $parameter) {
//                    $string .= $parameter->getType().' '.$parameter->getName().' ';
//                }
//                fwrite($handle, '+ '.$method->getName().'('.$string.')');
//                fwrite($handle, PHP_EOL);
//            }
//
//        }
        fwrite($handle, PHP_EOL);

        fwrite($handle, '}');
        fwrite($handle, PHP_EOL);

        if ($reflection->getParentClass()) {
            $parent = $reflection->getParentClass();
            fwrite($handle, 'class '. $reflection->getParentClass()->getName().'{');
            fwrite($handle, PHP_EOL);
//            foreach ($parent->getProperties() as $probs) {
//
//                if ($probs->getModifiers() === \ReflectionProperty::IS_PUBLIC) {
//                    fwrite($handle, $probs->getName());
//                    fwrite($handle, PHP_EOL);
//                }
//            }
//            foreach ($parent->getMethods() as $method) {
//
//                if ($method->getModifiers() === \ReflectionProperty::IS_PUBLIC) {
//                    fwrite($handle, $method->getName().'()');
//                    fwrite($handle, PHP_EOL);
//                }
//
//            }
            fwrite($handle, '}');
            fwrite($handle, PHP_EOL);
            fwrite($handle, $reflection->getName() .' --|>'.$reflection->getParentClass()->getName());
            fwrite($handle, PHP_EOL);
        }


        fwrite($handle, PHP_EOL);
        fwrite($handle, '@enduml');
        fclose($handle);


    }

}