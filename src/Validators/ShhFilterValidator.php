<?php

/**
 * This file is part of webu.php package.
 *
 * @author dreamxyp <dreamxyp@gmail.com>
 * @license MIT
 */

namespace Webu\Validators;

use Webu\Validators\IValidator;
use Webu\Validators\QuantityValidator;
use Webu\Validators\HexValidator;
use Webu\Validators\IdentityValidator;

class ShhFilterValidator
{
    /**
     * validate
     *
     * @param array $value
     * @return bool
     */
    public static function validate($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (isset($value['to']) && IdentityValidator::validate($value['to']) === false) {
            return false;
        }
        if (!isset($value['topics']) || !is_array($value['topics'])) {
            return false;
        }
        foreach ($value['topics'] as $topic) {
            if (is_array($topic)) {
                foreach ($topic as $subTopic) {
                    if (HexValidator::validate($subTopic) === false) {
                        return false;
                    }
                }
                continue;
            }
            if (HexValidator::validate($topic) === false) {
                if (!is_null($topic)) {
                    return false;
                }
            }
        }
        return true;
    }
}