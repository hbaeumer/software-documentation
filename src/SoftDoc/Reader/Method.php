<?php
declare(strict_types=1);

namespace Hbaeumer\SoftDoc\Reader;


final class Method
{
    /**
     * @var \SimpleXMLElement
     */
    private $xml;


    /**
     * Method constructor.
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    public function getCCN()
    {
        return (int)$this->xml['ccn'];
    }
    public function getCCN2()
    {
        return (int)$this->xml['ccn2'];
    }

    public function getCloc()
    {
        return (int)$this->xml['cloc'];
    }

    public function getEloc()
    {
        return (int)$this->xml['eloc'];
    }

    public function getLloc()
    {
        return (int)$this->xml['lloc'];
    }
    public function getLoc()
    {
        return (int)$this->xml['loc'];
    }

    public function getNloc()
    {
        return (int)$this->xml['nloc'];
    }

    public function getNpath()
    {
        return (int)$this->xml['npath'];
    }


}