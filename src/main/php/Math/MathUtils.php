<?php
/**
 * FlorianWolters\Component\Math\MathUtils
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
 * The class {@see MathUtils} contains methods for performing basic numeric
 * operations such as the elementary exponential, logarithm, square root, and
 * trigonometric functions.
 *
 * @since Class available since Release 0.1.0
 */
final class MathUtils
{
    /**
     * The `float` value closest to `e`, the base of the natural logarithm.
     *
     * @var float
     */
    const E = 2.718281828459045;

    /**
     * The double value closest to `pi`, the ratio of a circle's circumference
     * to its diameter.
     *
     * @var float
     */
    const PI = 3.141592653589793;

    // @codeCoverageIgnoreStart

    /**
     * {@see MathUtils} instances should *NOT* be constructed in standard
     * programming.
     *
     * Instead, the class should be used as:
     * /---code php
     * Math::abs(-1);
     * \---
     */
    protected function __construct()
    {
    }

    // @codeCoverageIgnoreEnd

    /**
     * Returns the absolute value of the argument.
     *
     * @param float|integer $number The value whose absolute value has to be
     *    computed.
     *
     * @return float|int The argument if it is positive, otherwise the negation
     *    of the argument.
     */
    public static function abs($number)
    {
        return \abs($number);
    }

    /**
     * Returns the double conversion of the most negative (closest to negative
     * infinity) int value which is greater than the argument.
     *
     * @param float $number The value whose closest integer value has to be
     *    computed.
     *
     * @return int The ceiling of the argument.
     */
    public static function ceil($number)
    {
        return (int) \ceil($number);
    }

    /**
     * Returns the double conversion of the most positive (closest to positive
     * infinity) integer value less than or equal to the argument.
     *
     * @param float $number The value whose closest integer value has to be
     *    computed.
     *
     * @return int The flooring of the argument.
     */
    public static function floor($number)
    {
        return (int) \floor($number);
    }

    /**
     * Returns the greatest common divisor (gcd) of two values.
     *
     * @param int $first  An argument.
     * @param int $second Another argument.
     *
     * @return int The greatest common divisor of `$first` and `$second`.
     */
    public static function gcd($first, $second)
    {
        return (0 === $second)
            ? $first
            : self::gcd($second, ($first % $second));
    }

    /**
     * Returns the least common multiple (lcm) of two values.
     *
     * @param int $first  An argument.
     * @param int $second Another argument.
     *
     * @return int The least common multiple of `$first` and `$second`.
     */
    public static function lcm($first, $second)
    {
        return (self::abs($first * $second) / self::gcd($first, $second));
    }

    /**
     * Returns the greater of two values.
     *
     * That is, the result is the argument closer to positive infinity. If the
     * arguments have the same value, the result is that same value. If either
     * value is NaN, then the result is NaN. Unlike the numerical comparison
     * operators, this method considers negative zero to be strictly smaller
     * than positive zero. If one argument is positive zero and the other
     * negative zero, the result is positive zero.
     *
     * @param mixes $first  An argument.
     * @param mixed $second Another argument.
     *
     * @return mixed The larger of `$first` and `$second`.
     */
    public static function max($first, $second)
    {
        return ($first > $second)
            ? $first
            : $second;
    }

    /**
     * Returns the smaller of two values.
     *
     * That is, the result is the value closer to negative infinity. If the
     * arguments have the same value, the result is that same value. If either
     * value is *NaN*, then the result is *NaN*. Unlike the numerical comparison
     * operators, this method considers negative zero to be strictly smaller
     * than positive zero. If one argument is positive zero and the other is
     * negative zero, the result is negative zero.
     *
     * @param mixed $first  An argument.
     * @param mixed $second Another argument.
     *
     * @return mixed The smaller of `$first` and `$second`.
     */
    public static function min($first, $second)
    {
        return ($first < $second)
            ? $first
            : $second;
    }
}
