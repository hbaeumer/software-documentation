<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 06.07.18
 * Time: 21:38
 */

namespace Hbaeumer\SoftDoc\Creator;


use phpDocumentor\Descriptor\Interfaces\ClassInterface;
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
    }


    public function create(ClassInterface $classDescriptor)
    {

        $html = $this->twig->render(
            'class.html.twig',
            [
                'class'=> $classDescriptor,
            ]
        );
        return $html;
    }

}