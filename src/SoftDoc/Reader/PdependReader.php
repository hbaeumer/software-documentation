<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Reader;


final class PdependReader
{

    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    /**
     * PdependReader constructor.
     *
     * @param $xml
     */
    public function __construct($file)
    {
        $this->read($file);
    }


    private function read($file)
    {
        $this->xml = simplexml_load_file($file);


    }

    /**
     * @param string $method
     *
     * @return Method
     */
    public function findMethod(string $method)
    {
        ///metrics/package/class[@fqname='Hbaeumer\SoftDoc\Parser\ClassParser']/method[@name='createFile']
        ///
        ///

        $search = explode('::', $method);
        $xpath = '/metrics/package/class[@fqname=\'%s\']/method[@name=\'%s\']';
        $path = vsprintf($xpath, $search);

        $result = $this->xml->xpath($path);

        if (is_array($result) && array_key_exists(0, $result)) {
            return new Method($result[0]);
        }

        return null;

    }

}