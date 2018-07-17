<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 29.05.18
 * Time: 23:50
 */

namespace Hbaeumer\SoftDoc\Creator;


use Hbaeumer\SoftDoc\Template\Extension\BootstrapTableExtension;
use Hbaeumer\SoftDoc\Template\Extension\MarkdownExtension;
use Hbaeumer\SoftDoc\Template\Extension\PMDTableExtension;
use phpDocumentor\Reflection\Php\Project;
use Twig\Environment;

class DashboardCreator
{
    /**
     * @var Environment
     */
    private $twig;


    /**
     * @var array
     */
    private $checkStyles = [];

    /**
     * @var array
     */
    private $pmd = [];

    /**
     * @var Project
     */
    private $project;

    /**
     * DashboardCreator constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $twig->addExtension(new BootstrapTableExtension());
        $twig->addExtension(new PMDTableExtension());
        $twig->addExtension(new MarkdownExtension());
        $this->twig = $twig;
    }

    /**
     * @param array $checkStyles
     */
    public function setCheckStyles(array $checkStyles): void
    {
        $this->checkStyles = $checkStyles;
    }

    /**
     * @param array $pmd
     */
    public function setPmd(array $pmd): void
    {
        $this->pmd = $pmd;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project): void
    {
        $this->project = $project;
    }




    public function create()
    {

        $html = $this->twig->render(
            'dashboard.html.twig',
            [
                'checkstyle'=> $this->checkStyles,
                'pmd' => $this->pmd,
                'readme' => file_get_contents(__DIR__ . '/../../../README.md'),
                'project' => $this->project,
            ]
        );
        return $html;
    }

}