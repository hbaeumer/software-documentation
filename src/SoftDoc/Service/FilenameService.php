<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Service;


use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflector\ClassReflector;

final class FilenameService
{

    public function getFilename(ReflectionClass $class)
    {
        return str_replace('\\','_',$class->getNamespaceName()).'_'.$class->getShortName().'.html';
    }

}