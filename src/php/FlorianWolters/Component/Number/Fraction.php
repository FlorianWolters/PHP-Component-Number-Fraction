<?php
namespace FlorianWolters\Component\Number;

use \InvalidArgumentException;
use FlorianWolters\Component\Core\ComparableInterface;
use FlorianWolters\Component\Core\DebugPrintInterface;
use FlorianWolters\Component\Core\EqualityInterface;
use FlorianWolters\Component\Math\ArithmeticException;
use FlorianWolters\Component\Math\BasicArithmeticOperationInterface;
use FlorianWolters\Component\Math\BasicArithmeticOperationTrait;
use FlorianWolters\Component\Math\MathUtils;

/**
 * An object of class {@link Fraction} wraps a fraction
 * (`numerator/denominator`) into an object.
 *
 * A {@link Fraction} is a `Number` implementation that stores {@link Fraction}s
 * accurately.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2011-2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL 3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Number-Fraction
 * @since     Class available since Release 0.1.0
 */
class Fraction implements
    BasicArithmeticOperationInterface,
    ComparableInterface,
    DebugPrintInterface,
    EqualityInterface
{
    // TODO Or use a static class `BasicArithmeticOperationUtils` instead?
    use BasicArithmeticOperationTrait;

    /**
     * The numerator of this {@link Fraction}.
     *
     * @var integer
     */
    private $numerator;

    /**
     * The denominator of this {@link Fraction}.
     *
     * @var integer
     */
    private $denominator;

    /**
     * `true` if this {@link Fraction} should be reduced; `false` otherwise.
     *
     * @var boolean
     */
    private $reduce = false;

    /**
     * Constructs a new {@link Fraction} object with the specified numerator and
     * denominator.
     *
     * @param integer $numerator   The numerator of the {@link Fraction}.
     * @param integer $denominator The denominator of the {@link Fraction}.
     * @param boolean $reduce      `true` if the {@link Fraction} should be
     *                             reduced; `false` otherwise.
     *
     * @throws ArithmeticException If the denominator is `0`.
     */
    public function __construct($numerator, $denominator = 1, $reduce = true)
    {
        $numerator = \intval($numerator);
        $denominator = \intval($denominator);

        if (0 === $denominator) {
            // The denominator is zero.
            throw new ArithmeticException('The denominator must not be zero.');
        }

        if (0 > $denominator) {
            // The denominator is negative. St the sign of the entire fraction.
            $numerator *= -1;
            $denominator *= -1;
        }

        $this->numerator = $numerator;
        $this->denominator = $denominator;
        $this->reduce = $reduce;

        if (true === $this->reduce) {
            // TODO See comment for method reduceThis.
            $this->reduceThis();
        }
    }

    /**
     * Converts a `float` to a {@link Fraction} and tries to keep the maximal
     * possible precision.
     *
     * @param float $real The `float` to convert to a {@link Fraction} object.
     *
     * @return Fraction A new {@link Fraction} object.
     */
    public static function fromReal($real)
    {
        $real = \floatval($real);

        // Keep the original sign, so that the numerator could be converted
        // later.
        $negative = ($real < 0);
        if (true === $negative) {
            $real *= -1;
        }

        // Get the part before the floating point.
        $integer = \floor($real);
        // Make the float belonging to the interval [0, 1).
        $real = ($real - $integer);
        // Strip the zero and the floating point.
        $real = \substr($real, 2);

        // Try to get an integer for the numerator.
        do {
            $length = \strlen($real);
            $numerator = (($integer * \pow(10, $length)) + $real);
            $real = \substr($real, 0, -1);
        } while ($numerator > \intval($numerator));

        if (true === $negative) {
            $numerator *= -1;
        }

        $numerator = \intval($numerator);
        $denominator = \pow(10, $length);

        return new self($numerator, $denominator);
    }

    /**
     * Converts a `string` to a {@link Fraction}.
     *
     * @param string $str The `string` to convert to a {@link Fraction} object.
     *
     * @return Fraction A new {@link Fraction} object.
     * @throws InvalidArgumentException If the `string` is invalid.
     */
    public static function fromString($str)
    {
        $valid = \preg_match(
            '#^(-)? *?(\d+) *?/ *?(-)? *?(\d+)$#',
            \trim($str),
            $matches
        );

        if (false === $valid) {
            throw new InvalidArgumentException(
                'The string representation of the {@link Fraction} is invalid.'
            );
        }

        $numerator = $matches[2];
        $denominator = $matches[4];

        if ($matches[1] xor $matches[3]) {
            // There is one '-' sign => the {@link Fraction} is negative.
            $numerator *= -1;
        }

        return new self($numerator, $denominator);
    }

    /**
     * Returns the numerator of this {@link Fraction}.
     *
     * @return integer The numerator.
     * @see getDenominator
     */
    public function getNumerator()
    {
        return $this->numerator;
    }

    /**
     * Returns the denominator of this {@link Fraction}.
     *
     * @return integer The denominator.
     * @see getNumerator
     */
    public function getDenominator()
    {
        return $this->denominator;
    }

    /**
     * Returns the value of this {@link Fraction} as a `float`.
     *
     * @return float The numeric value represented by this object after
     *               conversion to type `float`.
     * @see intValue
     * @see __toString
     */
    public function floatValue()
    {
        return ($this->numerator / $this->denominator);
    }

    /**
     * Returns the value of this {@link Fraction} as an `integer`.
     *
     * @return integer The numeric value represented by this object after
     *                 conversion to type `integer`.
     * @see floatValue
     * @see __toString
     */
    public function intValue()
    {
        return (integer) $this->floatValue();
    }

    /**
     * Checks whether this {@link Fraction} is reduced.
     *
     * @return boolean `true` if this {@link Fraction} is reduced; `false`
     *                 otherwise.
     */
    public function isReduced()
    {
        return (1 === $this->gcd());
    }

    /**
     * Returns a {@link Fraction} that is the positive equivalent of this {@link
     * Fraction}.
     *
     * More precisely:
     * /---code php
     * $result = $this >= 0 ? $this : -$this;
     * \---
     *
     * @return Fraction This {@link Fraction} if this {@link Fraction} is
     *                  positive, or a new positive {@link Fraction} with the
     *                  opposite signed numerator.
     */
    public function abs()
    {
        return (0 <= $this->floatValue())
            ? $this
            : $this->negate();
    }

    /**
     * Returns the greatest common divisor (gcd) of this {@link Fraction}.
     *
     * @return integer the greatest common divisor.
     * @see lcm
     */
    public function gcd()
    {
        return MathUtils::gcd($this->numerator, $this->denominator);
    }

    /**
     * Returns the least common multiple (lcm) of two {@link Fraction}s.
     *
     * @param Fraction $other Another {@link Fraction}.
     *
     * @return integer The least common multiple.
     * @see gcd
     */
    public function lcm(Fraction $other)
    {
        return MathUtils::lcm($this->denominator, $other->denominator);
    }

    /**
     * Returns a new {@link Fraction} that is the negative (-{@link Fraction})
     * of this {@link Fraction}.
     *
     * @return Fraction A new {@link Fraction} with the opposite signed
     *                  numerator.
     */
    public function negate()
    {
        return new self(-$this->numerator, $this->denominator);
    }

    /**
     * Returns the reciprocal of this {@link Fraction}.
     *
     * @return Fraction The reciprocal of this {@link Fraction}.
     */
    public function reciprocal()
    {
        return new self($this->denominator, $this->numerator);
    }

    /**
     * Returns the reduction of this {@link Fraction}.
     *
     * @return Fraction The reduction of this {@link Fraction}.
     */
    public function reduce()
    {
        $gcd = $this->gcd();

        return (1 < $gcd)
            ? new self($this->numerator / $gcd, $this->denominator / $gcd)
            : $this;
    }

    /**
     * Reduces this {@link Fraction}.
     *
     * Modifies the numerator and denumerator of this {@link Fraction}.
     *
     * @return Fraction This {@link Fraction}.
     * @todo Is there a better solution than this for usage in the constructor?
     */
    private function reduceThis()
    {
        $gcd = $this->gcd();

        if (1 < $gcd) {
            $this->numerator /= $gcd;
            $this->denominator /= $gcd;
        }
    }

    // Implementation of interface
    // FlorianWolters\Component\Math\BasicArithmeticOperationInterface.

    /**
     * {@inheritdoc}
     */
    public function add(BasicArithmeticOperationInterface $other)
    {
        $denominator = $this->lcm($other);
        $numerator = (($this->numerator * $denominator) / $this->denominator)
            + (($other->numerator * $denominator) / $other->denominator);

        return new self(
            $numerator,
            $denominator,
            $this->reduce
        );
    }

    /**
     * {@inheritdoc}
     */
    public function subtract(
        BasicArithmeticOperationInterface $other
    ) {
        return $this->add(
            new self(($other->numerator * -1), $other->denominator)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function multiplyBy(
        BasicArithmeticOperationInterface $other
    ) {
        return new self(
            ($this->numerator * $other->numerator),
            ($this->denominator * $other->denominator)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function divideBy(
        BasicArithmeticOperationInterface $other
    ) {
        return $this->multiplyBy($other->reciprocal());
    }

    // Implementation of interface
    // FlorianWolters\Component\Core\DebugPrintInterface.

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->numerator . '/' . $this->denominator;
    }

    // Implementation of interface
    // FlorianWolters\Component\Core\ComparableInterface.

    /**
     * {@inheritdoc}
     */
    public function compareTo(ComparableInterface $other)
    {
        $lcm = MathUtils::lcm($this->denominator, $other->denominator);
        $firstComp = (($this->numerator * $lcm) / $this->denominator);
        $secondComp = (($other->numerator * $lcm) / $other->denominator);

        return ($firstComp < $secondComp)
            ? -1
            : \intval($firstComp > $secondComp);
    }

    // Implementation of interface
    // FlorianWolters\Component\Core\EqualInterface.

    /**
     * {@inheritdoc}
     */
    public function equals(EqualityInterface $other = null)
    {
        return ($this->numerator / $this->denominator)
            == ($other->numerator / $other->denominator);
    }
}
