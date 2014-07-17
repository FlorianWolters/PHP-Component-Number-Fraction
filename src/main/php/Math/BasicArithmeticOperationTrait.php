<?php
/**
 * FlorianWolters\Component\Math\BasicArithmeticOperationTrait
 *
 * PHP Version 5.4
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2011-2014 Florian Wolters (http://blog.florianwolters.de)
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Math
 * @todo      Create separated component containing this artifact.
 */

namespace FlorianWolters\Component\Math;

/**
 * A class using the trait BasicArithmeticOperationTrait implements the four
 * basic arithmetic operations *addition*, *subtraction*, *multiplication* and
 * *division*.
 *
 * @since Trait available since Release 0.1.0
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
