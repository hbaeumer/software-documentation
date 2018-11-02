<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 06.07.18
 * Time: 21:38
 */

namespace Hbaeumer\SoftDoc\Creator;


use Hbaeumer\SoftDoc\Template\Extension\ClassSynopsis;
use Hbaeumer\SoftDoc\Template\Extension\MethodExtension;
use phpDocumentor\Descriptor\Interfaces\ClassInterface;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Twig\Environment;

class ClassPageCreator
{

    /**
     * @var Environment
     */
    private $twig;

    /**
     * ClassPageCreator constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {

        $this->twig = $twig;
        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addExtension(new MethodExtension());
        $twig->addExtension(new ClassSynopsis());
    }


    /**
     * @param ReflectionClass $reflectionClass
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function create(ReflectionClass $reflectionClass): string
    {

        $html = $this->twig->render(
            'class.html.twig',
            [
                'class'=> $reflectionClass,
            ]
        );
        return $html;
    }


    public function test()
    {
        $b = 50;
        $a = 100;
        while ($b != 0) {
            if ($a > $b) {
                $a = $a-$b;
            } else {
                $b = $b-$a;
            }
        }
        return $a;

    }

}