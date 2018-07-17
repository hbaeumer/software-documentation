<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 29.05.18
 * Time: 14:33
 */

namespace Hbaeumer\SoftDoc\Console;


use Hbaeumer\SoftDoc\Configuration;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration): void
    {
        $this->configuration = $configuration;
    }







}