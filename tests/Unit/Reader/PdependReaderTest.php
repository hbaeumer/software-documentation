<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Test\Unit\Reader;


use Hbaeumer\SoftDoc\Reader\PdependReader;
use Hbaeumer\SoftDoc\Reader\PMDReader;
use PHPUnit\Framework\TestCase;

final class PdependReaderTest extends TestCase
{

    public function testRead()
    {
        $reader = new PdependReader(__DIR__. '/../../_data/summary.xml');
        $content = $reader->findMethod('Hbaeumer\SoftDoc\Parser\ClassParser::createFile');
//        var_dump($content);
        $this->assertEquals(9, $content->getCCN());
    }

}