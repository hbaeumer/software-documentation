<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 31.05.18
 * Time: 22:21
 */

namespace Hbaeumer\SoftDoc\Reader;


class PMDReader
{
    private $violations = [];

    /**
     * @param string $file
     * @return array
     */
    public function read(string $file)
    {
        $pmd   = simplexml_load_file($file);

        foreach ($pmd->file as $file) {

            $fileName = (string)$file['name'];
            if (!array_key_exists($fileName, $this->violations)) {
                $this->violations[$fileName] = [];
            }
            foreach ($file->violation as $violation) {
                $arr = [
                    'message' => trim((string)$violation)
                ];
                $arr = array_merge($arr, ((array)$violation->attributes())['@attributes']);
                $this->violations[$fileName][] = $arr;
            }
        }
        return $this->violations;
    }
}