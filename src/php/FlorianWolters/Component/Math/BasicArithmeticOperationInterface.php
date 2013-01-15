<?php
namespace FlorianWolters\Component\Math;

/**
 * The interface {@link BasicArithmeticOperationProviderInterface} provides the
 * four basic arithmetic operations *addition*, *subtraction*, *multiplication*
 * and *division*.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2012-2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Math
 * @since     Interface available since Release 0.1.0
 * @todo      Create separated component containing this artifact.
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
     *                                                 object.
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
     * @param BasicArithmeticOperationInterface $other The object to subtrac t
     *                                                 from this object.
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
     *                                                 multiplicate with this
     *                                                 object.
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
     *                                                 through this object.
     *
     * @return object The quotient of this object with the specified object.
     */
    public function divideBy(self $other);
}
