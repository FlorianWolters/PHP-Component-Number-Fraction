<?php
/**
 * FlorianWolters\Component\Math\BasicArithmeticOperationInterface
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
 * The interface {@see BasicArithmeticOperationProviderInterface} provides the
 * four basic arithmetic operations *addition*, *subtraction*, *multiplication*
 * and *division*.
 *
 * @since Interface available since Release 0.1.0
 */
interface BasicArithmeticOperationInterface
{
    /**
     * Returns the sum of this object with the specified object.
     *
     * The sum should be calculated as follow:
     * /---code php
     * $result = $this + $other;
     * \---
     *
     * @param BasicArithmeticOperationInterface $other The object to add to this
     *    object.
     *
     * @return object The sum of this object with the specified object.
     */
    public function add(self $other);

    /**
     * Returns the difference of this object with the specified object.
     *
     * The difference should be calculated as follow:
     * /---code php
     * $result = $this - $other;
     * \---
     *
     * @param BasicArithmeticOperationInterface $other The object to subtract
     *    from this object.
     *
     * @return object The difference of this object with the specified object.
     */
    public function subtract(self $other);

    /**
     * Returns the product of this object with the specified object.
     *
     * The product should be calculated as follow:
     * /---code php
     * $result = $this * $other;
     * \---
     *
     * @param BasicArithmeticOperationInterface $other The object to
     *    multiplicate with this object.
     *
     * @return object The product of this object with the specified object.
     */
    public function multiplyBy(self $other);

    /**
     * Returns the quotient of this object with the specified object.
     *
     * The quotient should be calculated as follow:
     * /---code php
     * $result = $this / $other;
     * \---
     *
     * @param BasicArithmeticOperationInterface $other The object to divide
     *    through this object.
     *
     * @return object The quotient of this object with the specified object.
     */
    public function divideBy(self $other);
}
