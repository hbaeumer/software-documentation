<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 29.05.18
 * Time: 21:22
 */

namespace Hbaeumer\SoftDoc\Console\Command;


use DI\Annotation\Inject;
use Hbaeumer\SoftDoc\Creator\ClassPageCreator;
use Hbaeumer\SoftDoc\Creator\DashboardCreator;
use Hbaeumer\SoftDoc\Reader\CheckStyleReader;
use Hbaeumer\SoftDoc\Reader\PMDReader;
use phpDocumentor\Application\Builder\AssemblerFactoryFactory;
use phpDocumentor\Descriptor\Builder\AssemblerFactory;
use phpDocumentor\Descriptor\Filter\ClassFactory;
use phpDocumentor\Descriptor\Filter\Filter;
use phpDocumentor\Descriptor\ProjectDescriptor;
use phpDocumentor\Descriptor\ProjectDescriptorBuilder;
use phpDocumentor\Reflection\DocBlock\ExampleFinder;
use phpDocumentor\Reflection\File\LocalFile;
use phpDocumentor\Reflection\Php\Namespace_;
use phpDocumentor\Reflection\Php\ProjectFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Twig\Environment;

class RunOldCommand extends AbstractCommand
{

    /**
     * @Inject
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @Inject
     * @var DashboardCreator
     */
    private $dashboardCreator;


    /**
     * @Inject
     * @var ClassPageCreator
     */
    private $classCreator;


    /**
     * @Inject
     * @var CheckStyleReader
     */
    private $checkStyleReader;

    /**
     * @Inject
     * @var PMDReader
     */
    private $pmdReader;

    protected function configure()
    {
        $this
            ->setName('old')
            ->setDescription('run the SoftDoc');
        $this->setDefinition([
            new InputArgument('source', InputArgument::OPTIONAL, 'source', getcwd().'/src/'),
            new InputOption('output', 'o', InputOption::VALUE_OPTIONAL, 'output directory', getcwd().'/docs')
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $input->getArgument('source');
        $outputDir = $input->getOption('output');
        $output->writeln($source);
        $output->writeln($outputDir);
        $this->filesystem->mirror(__DIR__ . '/../../../../template/default/assets/', $outputDir);
        $output->writeln($outputDir);

        $finder = new Finder();
        $projectFiles = [];

        $files = $finder->files()->in($source)->files()->name('*.php');
        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $projectFiles[] = new LocalFile($file->getPathname());
        }


        $projectFactory = ProjectFactory::createInstance();

//        var_dump($projectFiles);

        $project = $projectFactory->create('test', $projectFiles);

//        $this->dashboardCreator->setProject($project);


        $styles = [];
        foreach ($this->getConfiguration()->getCheckstyleReports() as $files) {
            $styles = $this->checkStyleReader->read(__DIR__ . '/../../../../build/reports/checkstyle.xml');
            $styles = $this->checkStyleReader->read(__DIR__ . '/../../../../build/reports/phpstancs.xml');
        }


        $this->dashboardCreator->setCheckStyles($styles);


        $assembler = AssemblerFactoryFactory::create(new ExampleFinder());
        $buidler = new ProjectDescriptorBuilder($assembler, new Filter(new ClassFactory()));

        $buidler->setProjectDescriptor(new ProjectDescriptor('foo'));

        $buidler->build($project);

//        var_dump($buidler->getProjectDescriptor()->getNamespace());

//        var_dump($buidler);

        foreach ($buidler->getProjectDescriptor()->getFiles() as $item) {
            foreach ($item->getClasses() as $classes) {
                $html = $this->classCreator->create($classes);
                $filename = $outputDir.'/'.str_replace('\\','_',$classes->getFullyQualifiedStructuralElementName()).'.html';
                $this->filesystem->dumpFile($filename, $html);
                var_dump($filename);
            }
        };


//        foreach ($project->getNamespaces() as $key => $namespace) {
//            var_dump($key);
//            foreach ($namespace->getClasses() as $ckey => $class)
//            {
//                var_dump($ckey);
//                var_dump($class);
//            }
//
//            var_dump($namespace->getFunctions());
//
//        }


        fopen($file, 'w+');


        $pmd = $this->pmdReader->read(__DIR__ . '/../../../../build/reports/phpmd.xml');
        $this->dashboardCreator->setPmd($pmd);

        $html = $this->dashboardCreator->create();
        $this->filesystem->dumpFile($outputDir.'/index.html', $html);
    }


}