<?php

/**
 * This file is part of webu.php package.
 * 
 * (c) Kuan-Cheng,Lai <alk03073135@gmail.com>
 * 
 * @author Peter Lai <alk03073135@gmail.com>
 * @license MIT
 */

namespace Webu\Methods\Huc;

use InvalidArgumentException;
use Webu\Methods\HucMethod;
use Webu\Formatters\BigNumberFormatter;

class Hashrate extends HucMethod
{
    /**
     * validators
     * 
     * @var array
     */
    protected $validators = [];
    
    /**
     * inputFormatters
     * 
     * @var array
     */
    protected $inputFormatters = [];

    /**
     * outputFormatters
     * 
     * @var array
     */
    protected $outputFormatters = [
        BigNumberFormatter::class
    ];

    /**
     * defaultValues
     * 
     * @var array
     */
    protected $defaultValues = [];

    /**
     * construct
     * 
     * @param string $method
     * @param array $arguments
     * @return void
     */
    // public function __construct($method='', $arguments=[])
    // {
    //     parent::__construct($method, $arguments);
    // }
}