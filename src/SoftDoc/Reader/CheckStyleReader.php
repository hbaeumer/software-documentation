<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 29.05.18
 * Time: 23:59
 */

namespace Hbaeumer\SoftDoc\Reader;


class CheckStyleReader
{

    private $errors = [];

    /**
     * @param string $file
     * @return array
     */
    public function read(string $file)
    {
        $xml   = simplexml_load_file($file);

        foreach ($xml->file as $file) {
            $fileName = (string)$file['name'];

            if (!array_key_exists($fileName, $this->errors)) {
                $this->errors[$fileName] = [];
            }
            foreach ($file->error as $error) {
                $array = ((array)$error->attributes())['@attributes'];
                $this->errors[$fileName][] = $array;
            }
        }




        return $this->errors;
    }


}