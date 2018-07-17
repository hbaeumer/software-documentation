<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 04.06.18
 * Time: 22:22
 */

namespace Hbaeumer\SoftDoc\Console\Command;


use Hbaeumer\SoftDoc\Configuration;
use Hbaeumer\SoftDoc\Console\Application;
use Symfony\Component\Console\Command\Command;


/**
 * Class AbstractCommand
 * @package Hbaeumer\SoftDoc\Console\Command
 * @method Application getApplication
 */
abstract class AbstractCommand extends Command
{

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->getApplication()->getConfiguration();
    }



}