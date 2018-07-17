<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 03.06.18
 * Time: 21:12
 */

namespace Hbaeumer\SoftDoc\Test\Unit\Reader;


use Hbaeumer\SoftDoc\Reader\CheckStyleReader;
use PHPUnit\Framework\TestCase;

class CheckStyleReaderTest extends TestCase
{

    public function testReadSimpleFile()
    {
        $service = new CheckStyleReader();
        $file = __DIR__.'/../../_data/checkstyle.xml';
        $output = $service->read($file);
        $actual = $output;

        $expected = [
            'file1.php' => [
                [
                    'line' => '9',
                    'column' => '1',
                    'severity' => 'error',
                    'message' => 'm1',
                    'source' => 's1'
                ],
            ]
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testReadSimpleFile2()
    {
        $service = new CheckStyleReader();
        $file = __DIR__.'/../../_data/checkstyle2.xml';
        $output = $service->read($file);
        $actual = $output;

        $expected = [
            'file1.php' => [
                [
                    'line' => '9',
                    'column' => '1',
                    'severity' => 'error',
                    'message' => 'm1',
                    'source' => 's1'
                ],
                [
                    'line' => '51',
                    'column' => '15',
                    'severity' => 'error',
                    'message' => 'm2',
                    'source' => 's2'
                ],
            ],
            'file2.php' => [
                [
                    'line' => '19',
                    'column' => '1',
                    'severity' => 'error',
                    'message' => 'm3',
                    'source' => 's3'
                ],
                [
                    'line' => '123',
                    'column' => '15',
                    'severity' => 'error',
                    'message' => 'm4',
                    'source' => 's4'
                ],
            ],
        ];
//        var_dump($expected);
        $this->assertEquals($expected, $actual);
    }


}