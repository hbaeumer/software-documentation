<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Console\Command;


use DI\Annotation\Inject;
use Hbaeumer\SoftDoc\Creator\ClassPageCreator;
use Hbaeumer\SoftDoc\Creator\DashboardCreator;
use Hbaeumer\SoftDoc\Parser\ClassParser;
use Hbaeumer\SoftDoc\Reader\CheckStyleReader;
use Hbaeumer\SoftDoc\Reader\PMDReader;
use Hbaeumer\SoftDoc\Service\FilenameService;
use PhpParser\Builder\Class_;
use PhpParser\Node;
use PhpParser\NodeDumper;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use Roave\BetterReflection\BetterReflection;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class RunCommand extends AbstractCommand
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
            ->setName('run')
            ->setDescription('run the SoftDoc');
        $this->setDefinition([
            new InputArgument('source', InputArgument::OPTIONAL, 'source', getcwd() . '/src/'),
            new InputOption('output', 'o', InputOption::VALUE_OPTIONAL, 'output directory', getcwd() . '/docs')
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
        $filenameService = new FilenameService();
        foreach ($files as $file) {
            $projectFiles[] = $file;
//            var_dump($file->getRelativePathname());
            $classes = $this->get_php_classes($file->getContents());
//            var_dump($classes);
            foreach ($classes as $class) {
                var_dump($class);
                $classInfo = (new BetterReflection())->classReflector()->reflect($class);

                $html = $this->classCreator->create($classInfo);
                $filename = $outputDir.'/'.$filenameService->getFilename($classInfo);
                $this->filesystem->dumpFile($filename, $html);

            }




//            $output->writeln($file->getRelativePathname());
        }





//
//        fopen($file, 'w+');
//
//
        $pmd = $this->pmdReader->read(__DIR__ . '/../../../../build/reports/phpmd.xml');
        $this->dashboardCreator->setPmd($pmd);
//
        $html = $this->dashboardCreator->create();
        $this->filesystem->dumpFile($outputDir . '/index.html', $html);
    }

    private function file_get_php_classes($filepath) {
        $php_code = file_get_contents($filepath);
        $classes = $this->get_php_classes($php_code);
        return $classes;
    }

    private function get_php_classes($phpcode) {
//        var_dump($php_code);
        $classes = array();

        $namespace = 0;
        $tokens = token_get_all($phpcode);
        $count = count($tokens);
        $dlm = false;
        for ($i = 2; $i < $count; $i++) {

            if ((isset($tokens[$i - 2][1]) && ($tokens[$i - 2][1] == T_NAMESPACE || $tokens[$i - 2][1] == "namespace")) ||
                ($dlm && $tokens[$i - 1][0] == T_NS_SEPARATOR && $tokens[$i][0] == T_STRING)) {

                if (!$dlm) $namespace = 0;
                if (isset($tokens[$i][1])) {

                    $namespace = $namespace ? $namespace . "\\" . $tokens[$i][1] : $tokens[$i][1];

                    $dlm = true;
                }
            }
            elseif ($dlm && ($tokens[$i][0] != T_NS_SEPARATOR) && ($tokens[$i][0] != T_STRING)) {
                $dlm = false;
            }
            if (($tokens[$i - 2][0] == T_CLASS || (isset($tokens[$i - 2][1]) && $tokens[$i - 2][1] == T_CLASS))
                && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                $class_name = $tokens[$i][1];
                $classes[] = $namespace.'\\'.$class_name;
            }
        }




        return $classes;
    }
}