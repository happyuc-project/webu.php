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
use Webu\Validators\BlockHashValidator;
use Webu\Validators\QuantityValidator;
use Webu\Formatters\HexFormatter;
use Webu\Formatters\QuantityFormatter;

class GetTransactionByBlockHashAndIndex extends HucMethod
{
    /**
     * validators
     * 
     * @var array
     */
    protected $validators = [
        BlockHashValidator::class, QuantityValidator::class
    ];

    /**
     * inputFormatters
     * 
     * @var array
     */
    protected $inputFormatters = [
        HexFormatter::class, QuantityFormatter::class
    ];

    /**
     * outputFormatters
     * 
     * @var array
     */
    protected $outputFormatters = [];

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