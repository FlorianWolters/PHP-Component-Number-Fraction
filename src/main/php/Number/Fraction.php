<?php
/**
 * FlorianWolters\Component\Number\Fraction
 *
 * PHP Version 5.4
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2011-2014 Florian Wolters (http://blog.florianwolters.de)
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Number-Fraction
 */

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
 * An object of class {@see Fraction} wraps a fraction (`numerator/denominator`)
 * into an object.
 *
 * A {@see Fraction} is a `Number` implementation that stores {@see Fraction}s
 * accurately.
 *
 * @since Class available since Release 0.1.0
 */
class Fraction implements
    BasicArithmeticOperationInterface,
    ComparableInterface,
    DebugPrintInterface,
    EqualityInterface
{
    // TODO(wolters) Use a static class `BasicArithmeticOperationUtils` instead?
    use BasicArithmeticOperationTrait;

    /**
     * The numerator of this {@see Fraction}.
     *
     * @var int
     */
    private $numerator;

    /**
     * The denominator of this {@see Fraction}.
     *
     * @var int
     */
    private $denominator;

    /**
     * `true` if this {@see Fraction} should be reduced; `false` otherwise.
     *
     * @var bool
     */
    private $reduce = false;

    /**
     * Constructs a new {@see Fraction} object with the specified numerator and
     * denominator.
     *
     * @param int  $numerator   The numerator of the {@see Fraction}.
     * @param int  $denominator The denominator of the {@see Fraction}.
     * @param bool $reduce      `true` if the {@see Fraction} should be reduced;
     *    `false` otherwise.
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
            // The denominator is negative. Change the sign of the entire
            // fraction.
            $numerator *= -1;
            $denominator *= -1;
        }

        $this->numerator = $numerator;
        $this->denominator = $denominator;
        $this->reduce = $reduce;

        if (true === $this->reduce) {
            // TODO(wolters) See comment for method reduceThis.
            $this->reduceThis();
        }
    }

    /**
     * Converts a `float` to a {@see Fraction} and tries to keep the maximal
     * possible precision.
     *
     * @param float $real The `float` to convert to a {@see Fraction} object.
     *
     * @return Fraction A new {@see Fraction} object.
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
        $integer = MathUtils::floor($real);
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
     * Converts a `float` to a {@see Fraction} with the specified tolerance.
     *
     * @param float $real The `float` to convert to a {@see Fraction} object.
     * @param float $tolerance The tolerance.
     *
     * @return Fraction A new {@see Fraction} object.
     */
    public static function fromRealViaContinuedFractions($float, $tolerance = 1.e-6)
    {
        $negative = ($float < 0);

        if (true === $negative) {
            $float = MathUtils::abs($float);
        }

        $firstNumerator = 1;
        $secondNumerator = 0;
        $firstDenominator = 0;
        $secondDenominator = 1;
        $b = 1 / $float;

        do {
            $b = 1 / $b;
            $a = MathUtils::floor($b);
            $aux = $firstNumerator;
            $firstNumerator = $a * $firstNumerator + $secondNumerator;
            $secondNumerator = $aux;
            $aux = $firstDenominator;
            $firstDenominator = $a * $firstDenominator + $secondDenominator;
            $secondDenominator = $aux;
            $b -= $a;
        } while (MathUtils::abs($float - $firstNumerator / $firstDenominator) > $float * $tolerance);

        if (true === $negative) {
            $firstNumerator *= -1;
        }

        return new self((int) $firstNumerator, (int) $firstDenominator);
    }

    /**
     * Converts a `string` to a {@see Fraction}.
     *
     * @param string $str The `string` to convert to a {@see Fraction} object.
     *
     * @return Fraction A new {@see Fraction} object.
     * @throws InvalidArgumentException If the `string` is invalid.
     */
    public static function fromString($str)
    {
        $matches = [];

        $valid = \preg_match(
            '#^(-)? *?(\d+) *?/ *?(-)? *?(\d+)$#',
            \trim($str),
            $matches
        );

        if (1 !== $valid) {
            throw new InvalidArgumentException(
                'The string representation of the Fraction is invalid.'
            );
        }

        $numerator = $matches[2];
        $denominator = $matches[4];

        if ($matches[1] xor $matches[3]) {
            // There is one '-' sign => the fraction is negative.
            $numerator *= -1;
        }

        return new self($numerator, $denominator);
    }

    /**
     * Returns the numerator of this {@see Fraction}.
     *
     * @return int The numerator.
     * @see getDenominator
     */
    public function getNumerator()
    {
        return $this->numerator;
    }

    /**
     * Returns the denominator of this {@see Fraction}.
     *
     * @return int The denominator.
     * @see getNumerator
     */
    public function getDenominator()
    {
        return $this->denominator;
    }

    /**
     * Returns the value of this {@see Fraction} as a `float`.
     *
     * @return float The numeric value represented by this object after
     *    conversion to type `float`.
     * @see intValue
     * @see __toString
     */
    public function floatValue()
    {
        return ($this->numerator / $this->denominator);
    }

    /**
     * Returns the value of this {@see Fraction} as an `integer`.
     *
     * @return int The numeric value represented by this object after conversion
     *    to type `integer`.
     * @see floatValue
     * @see __toString
     */
    public function intValue()
    {
        return (integer) $this->floatValue();
    }

    /**
     * Checks whether this {@see Fraction} is reduced.
     *
     * @return bool `true` if this {@see Fraction} is reduced; `false`
     *    otherwise.
     */
    public function isReduced()
    {
        return (1 === $this->gcd());
    }

    /**
     * Returns a {@see Fraction} that is the positive equivalent of this {@see
     * Fraction}.
     *
     * More precisely:
     * /---code php
     * $result = $this >= 0 ? $this : -$this;
     * \---
     *
     * @return Fraction This {@see Fraction} if this {@see Fraction} is
     *    positive, or a new positive {@see Fraction} with the opposite signed
     *    numerator.
     */
    public function abs()
    {
        return (0 <= $this->floatValue())
            ? $this
            : $this->negate();
    }

    /**
     * Returns the greatest common divisor (gcd) of this {@see Fraction}.
     *
     * @return int The greatest common divisor.
     * @see lcm
     */
    public function gcd()
    {
        return MathUtils::gcd($this->numerator, $this->denominator);
    }

    /**
     * Returns the least common multiple (lcm) of two {@see Fraction}s.
     *
     * @param Fraction $other Another {@see Fraction}.
     *
     * @return int The least common multiple.
     * @see gcd
     */
    public function lcm(Fraction $other)
    {
        return MathUtils::lcm($this->denominator, $other->denominator);
    }

    /**
     * Returns a new {@see Fraction} that is the negative (-{@see Fraction})
     * of this {@see Fraction}.
     *
     * @return Fraction A new {@see Fraction} with the opposite signed
     *    numerator.
     */
    public function negate()
    {
        return new self(-$this->numerator, $this->denominator);
    }

    /**
     * Returns the reciprocal of this {@see Fraction}.
     *
     * @return Fraction The reciprocal of this {@see Fraction}.
     */
    public function reciprocal()
    {
        return new self($this->denominator, $this->numerator);
    }

    /**
     * Returns the reduction of this {@see Fraction}.
     *
     * @return Fraction The reduction of this {@see Fraction}.
     */
    public function reduce()
    {
        $gcd = $this->gcd();

        return (1 < $gcd)
            ? new self($this->numerator / $gcd, $this->denominator / $gcd)
            : $this;
    }

    /**
     * Reduces this {@see Fraction}.
     *
     * Modifies the numerator and denumerator of this {@see Fraction}.
     *
     * @return Fraction This {@see Fraction}.
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
    public function subtract(BasicArithmeticOperationInterface $other)
    {
        return $this->add(
            new self(($other->numerator * -1), $other->denominator)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function multiplyBy(BasicArithmeticOperationInterface $other)
    {
        return new self(
            ($this->numerator * $other->numerator),
            ($this->denominator * $other->denominator)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function divideBy(BasicArithmeticOperationInterface $other)
    {
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
