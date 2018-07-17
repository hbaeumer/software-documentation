<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @copyright 2010-2018 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor\Filter;

use Zend\Filter\FilterChain;

/**
 * Retrieves a series of filters to manipulate a specific Descriptor with during building.
 */
class ClassFactory
{
    /** @var FilterChain[] */
    protected $chains = [];

    /**
     * Retrieves the filters for a class with a given FQCN.
     *
     * @param string $fqcn
     *
     * @return FilterChain
     */
    public function getChainFor($fqcn)
    {
        if (!isset($this->chains[$fqcn])) {
            $this->chains[$fqcn] = new FilterChain();
        }

        return $this->chains[$fqcn];
    }
}
