<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 04.06.18
 * Time: 21:17
 */

namespace Hbaeumer\SoftDoc;


class Configuration
{
    private $json;

    /**
     * Configuration constructor.
     * @param $json
     */
    public function __construct(string $filename)
    {
        $this->json = json_decode(file_get_contents($filename), true);
    }

    public function getCheckstyleReports()
    {

        return $this->json['reports']['checkstyle'];
    }


}