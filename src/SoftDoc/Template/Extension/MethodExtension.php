<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Template\Extension;


use Hbaeumer\SoftDoc\Reader\Method;
use Hbaeumer\SoftDoc\Reader\PdependReader;
use Hbaeumer\SoftDoc\Service\FilenameService;
use phpDocumentor\Reflection\DocBlockFactory;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflection\ReflectionMethod;
use Roave\BetterReflection\Reflection\ReflectionParameter;
use Roave\BetterReflection\Reflector\ClassReflector;



final class MethodExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('method_template', [$this, 'methodRender'], ['is_safe' => ['html']]),
            new \Twig_SimpleFilter('simple_method', [$this, 'simpleMethodRender'], ['is_safe' => ['html']]),
        ];
    }


    public function simpleMethodRender(ReflectionMethod $method)
    {
        $reader = new PdependReader(__DIR__. '/../../../../build/reports/summary.xml');
        $content = $reader->findMethod($method->getDeclaringClass()->getName().'::'.$method->getName());
        $foo = '';
        if ($content instanceof Method) {
            $foo = $content->getCCN();
        }
        return $method->getName() .(($this->getDescription($method) == '')?'':' — '.$this->getDescription($method)). $foo;

    }

    public function methodRender(ReflectionMethod $method)
    {
        if (!$method->isPublic()) {
            return '';
        }

        $factory = DocBlockFactory::createInstance();
//        var_dump($method->getDocComment());
        if (!empty($method->getDocComment())) {
            $docBlock = $factory->create($method->getDocComment());
            if ($docBlock->hasTag('internal')){
                return '';
            }
        }

        $id = 'ss'.uniqid();

        $string = '';
        $string .= $this->getHeadline($method);
        $string .= '<div class="box-body">';
        $string .= '<div class=".nav-tabs-custom">';
        $string .='<ul class="nav nav-tabs">';
        $string .= '<li class="active"><a href="#'.$id.'desc" data-toggle="tab" aria-expanded="true">Description</a></li>';
        $string .= '<li><a href="#'.$id.'code" data-toggle="tab" aria-expanded="true">Code</a></li>';
        $string .='</ul>';
        //
        //              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Tab 1</a></li>
        //              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tab 2</a></li>
        //              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li>
        //              <li class="dropdown">
        //                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        //                  Dropdown <span class="caret"></span>
        //                </a>
        //                <ul class="dropdown-menu">
        //                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
        //                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
        //                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
        //                  <li role="presentation" class="divider"></li>
        //                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
        //                </ul>
        //              </li>
        //              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
        //            </ul>
        $string .= '<div class="tab-content">';

        $string .= '<div class="tab-pane active" id="'.$id.'desc">';
        $string .= $this->getDescription($method);
        $string .='</div>';

        $string .= '<div class="tab-pane" id="'.$id.'code">';
        $string .= '<pre><code class="php">'.$method->getBodyCode().'</code></pre>';
        $string .='</div>';

        $string .='</div>';


//<div class="tab-content">
//              <div class="tab-pane active" id="tab_1">
//                <b>How to use:</b>
//
//                <p>Exactly like the original bootstrap tabs except you should use
//                  the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
//                A wonderful serenity has taken possession of my entire soul,
//                like these sweet mornings of spring which I enjoy with my whole heart.
//                I am alone, and feel the charm of existence in this spot,
//                which was created for the bliss of souls like mine. I am so happy,
//                my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
//                that I neglect my talents. I should be incapable of drawing a single stroke
//                at the present moment; and yet I feel that I never was a greater artist than now.
//              </div>
//              <!-- /.tab-pane -->
//              <div class="tab-pane" id="tab_2">
//                The European languages are members of the same family. Their separate existence is a myth.
//                For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
//                in their grammar, their pronunciation and their most common words. Everyone realizes why a
//                new common language would be desirable: one could refuse to pay expensive translators. To
//                achieve this, it would be necessary to have uniform grammar, pronunciation and more common
//                words. If several languages coalesce, the grammar of the resulting language is more simple
//                and regular than that of the individual languages.
//              </div>
//              <!-- /.tab-pane -->
//              <div class="tab-pane" id="tab_3">
//                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
//                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
//                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
//                It has survived not only five centuries, but also the leap into electronic typesetting,
//                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
//                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
//                like Aldus PageMaker including versions of Lorem Ipsum.
//              </div>
//              <!-- /.tab-pane -->
//            </div>

//        $string .= '<pre>'.json_encode($method->getAst()->getStmts(), JSON_PRETTY_PRINT).'</pre>';

        return $string.'</div></div>';

    }

    private function getLink(ReflectionClass $class)
    {
        $fileLinkService = new FilenameService();
        return '<a href="'.$fileLinkService->getFilename($class).'">'.$class->getName().'</a>';
    }

    private function getDescription(ReflectionMethod $method)
    {

        $string = '';
        $docBlock = '';
        $factory = DocBlockFactory::createInstance();
//        var_dump($method->getDocComment());
        if (empty($method->getDocComment())) {
            try {
                if ($method->getDeclaringClass()->getParentClass()) {
                    $docBlock = $method->getDeclaringClass()->getParentClass()->getMethod($method->getName())->getDocComment();
                };
            } catch (\OutOfBoundsException $exception) {
            }

        } else {
            $docBlock = $method->getDocComment();
        }

        if (!empty($docBlock)) {
            $docBlock = $factory->create($docBlock);

//        var_dump($docBlock->getDescription()->render());
            $string .= (string)$docBlock->getSummary();
//            $string .= (new MarkdownExtension())->markdown((string)$docBlock->getDescription());
        }


        //
//            {% for method in class.methods  %}
//                {{ method|method_template }}
//            {% endfor %}
//        </div>
        return $string;


    }

    private function getHeadline(ReflectionMethod $method)
    {
//        <div class="box">
//        <div class="box-header with-border">
//            <h2 class="box-title">Methods</h2>
//
//            <div class="box-tools pull-right">
//                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
//                    <i class="fa fa-minus"></i></button>
//            </div>
//        </div>
//        <div class="box-body">
//            {% for method in class.methods  %}
//                {{ method|method_template }}
//            {% endfor %}
//        </div>
//        <!-- /.box-body -->
//    </div>


        $string = '<div class="box"><div class="box-header with-border"><h3 class="box-title">';

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

        $string .= (!empty($returnTypes))?''.implode('|', $returnTypes):'void';


        $string .= ' <strong>'.$method->getName().'</strong>(';

        $paramters = $method->getParameters();

        /** @var ReflectionParameter $parameter */
        foreach ($paramters as $parameter) {



            $type = ($parameter->getType())??implode('|',$parameter->getDocBlockTypeStrings());
            try {
                if ($parameter->getClass()) {
                    $type = $this->getLink($parameter->getClass());
                }
            } catch (\Exception $exception) {
            }

            $string .= $type.' $'.$parameter->getName().', ';
        }
        $string .= ')';
        $string .= '</h3><br/>';

        $string .= ((bool)($method->getModifiers() & \ReflectionMethod::IS_PUBLIC))?'<span class="label label-success">public</span> ':'';
        $string .= ((bool)($method->getModifiers() & \ReflectionMethod::IS_STATIC))?'<span class="label label-warning">static</span> ':'';


        return $string .'</div></div>';
    }
}