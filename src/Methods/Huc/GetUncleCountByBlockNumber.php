<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Methods\Huc;

use InvalidArgumentException;
use Webu\Methods\HucMethod;
use Webu\Validators\TagValidator;
use Webu\Validators\QuantityValidator;
use Webu\Formatters\OptionalQuantityFormatter;
use Webu\Formatters\BigNumberFormatter;

class GetUncleCountByBlockNumber extends HucMethod
{
    /**
     * validators
     * 
     * @var array
     */
    protected $validators = [
        [
            TagValidator::class, QuantityValidator::class
        ]
    ];

    /**
     * inputFormatters
     * 
     * @var array
     */
    protected $inputFormatters = [
        OptionalQuantityFormatter::class
    ];

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
    protected $defaultValues = [
        'latest'
    ];

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