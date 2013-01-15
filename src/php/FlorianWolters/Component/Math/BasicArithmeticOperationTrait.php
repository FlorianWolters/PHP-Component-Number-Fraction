<?php

namespace FlorianWolters\Component\Math;

/**
 * TODO Add comment.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Math
 * @since     Trait available since Release 0.1.0
 * @todo      Create separated component containing this artifact.
 */
trait BasicArithmeticOperationTrait
{
    public static function addition(
        BasicArithmeticOperationInterface $first,
        BasicArithmeticOperationInterface $second
    ) {
        return $first->add($second);
    }

    public static function subtraction(
        BasicArithmeticOperationInterface $first,
        BasicArithmeticOperationInterface $second
    ) {
        return $first->subtract($second);
    }

    public static function multiplication(
        BasicArithmeticOperationInterface $first,
        BasicArithmeticOperationInterface $second
    ) {
        return $first->multiplyBy($second);
    }

    public static function division(
        BasicArithmeticOperationInterface $first,
        BasicArithmeticOperationInterface $second
    ) {
        return $first->divideBy($second);
    }
}
