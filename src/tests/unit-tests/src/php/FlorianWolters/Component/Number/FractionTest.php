<?php
namespace FlorianWolters\Component\Number;

/**
 * Test class for {@link Fraction}.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2011-2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL 3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Number-Fraction
 * @since     Class available since Release 0.1.0
 *
 * @covers FlorianWolters\Component\Number\Fraction
 */
class FractionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class name of the class under test.
     *
     * @var string
     */
    private static $classNameUnderTest;

    /**
     * The first operand to use in arithmetical operations.
     *
     * @var Fraction
     */
    private $firstFraction;

    /**
     * The second operand to use in arithmetical operations.
     *
     * @var Fraction
     */
    private $secondFraction;

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        self::$classNameUnderTest = __NAMESPACE__ . '\Fraction';
        $this->firstFraction = new Fraction(8, 16);
        $this->secondFraction = new Fraction(3, 9);
    }

    /**
     * @return void
     *
     * @group specification
     * @test
     * @testdox The definition of the class Fraction is correct.
     */
    public function testClassDefinition()
    {
        $reflectedClass = new \ReflectionClass(self::$classNameUnderTest);
        $this->assertTrue($reflectedClass->inNamespace());
        $this->assertFalse($reflectedClass->isAbstract());
        $this->assertFalse($reflectedClass->isFinal());
        $this->assertTrue($reflectedClass->isInstantiable());
        $this->assertFalse($reflectedClass->isInterface());
        $this->assertFalse($reflectedClass->isInternal());
        $this->assertFalse($reflectedClass->isIterateable());
        $this->assertTrue($reflectedClass->isUserDefined());
    }

    /**
     * @return void
     *
     * @test
     * @testdox The definition of the constructor Fraction::__construct is correct.
     */
    public function testConstructorDefinition()
    {
        $reflectedConstructor = new \ReflectionMethod(
            self::$classNameUnderTest . '::__construct'
        );
        $this->assertFalse($reflectedConstructor->isAbstract());
        $this->assertTrue($reflectedConstructor->isConstructor());
        $this->assertFalse($reflectedConstructor->isFinal());
        $this->assertFalse($reflectedConstructor->isProtected());
    }

    /**
     * @return void
     *
     * @coversClass __construct
     * @group unit
     * @test
     * @testdox new Fraction(n, n) works correct.
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(self::$classNameUnderTest, new Fraction(1));
        $this->assertInstanceOf(self::$classNameUnderTest, new Fraction(1, 1));
    }

    /**
     * @return void
     *
     * @coversClass __construct
     * @expectedException FlorianWolters\Component\Math\ArithmeticException
     * @expectedExceptionMessage The denominator must not be zero.
     * @group unit
     * @test
     * @testdox new Fraction(n, 0) throws an ArithmeticException.
     */
    public function testConstructorThrowsArithmeticException()
    {
        new Fraction(1, 0);
    }

    /**
     * @return void
     *
     * @coversClass getNumerator
     * @group unit
     * @test
     * @testdox Fraction::getNumerator() should return the numerator of the fixture (1).
     */
    public function testGetNumerator()
    {
        $this->assertEquals(1, $this->firstFraction->getNumerator());
    }

    /**
     * @return void
     *
     * @coversClass getDenominator
     * @group unit
     * @test
     * @testdox Fraction::Denominator() should return the denominator of the fixture (2).
     */
    public function testGetDenominator()
    {
        $this->assertEquals(2, $this->firstFraction->getDenominator());
    }

    /**
     * @return void
     *
     * @coversClass floatValue
     * @group unit
     * @test
     * @testdox Fraction::floatValue() should return the float value of the fixture (0.5).
     */
    public function testFloatValue()
    {
        $this->assertEquals(.5, $this->firstFraction->floatValue());
    }

    /**
     * @return void
     *
     * @coversClass intValue
     * @group unit
     * @test
     * @testdox Fraction::intValue() should return the int value of the fixture (0).
     */
    public function testIntValue()
    {
        $this->assertEquals(0, $this->firstFraction->intValue());
    }

    /**
     * @return void
     *
     * @coversClass __toString
     * @group unit
     * @test
     * @testdox Fraction::__toString() should return the string representation of the fixture ('1/2').
     */
    public function testMagicToString()
    {
        $this->assertEquals('1/2', $this->firstFraction->__toString());
    }

    /**
     * @return void
     *
     * @coversClass equals
     * @group unit
     * @test
     */
    public function testEqualsIfEqual()
    {
        $this->assertTrue($this->firstFraction->equals(new Fraction(2, 4)));
    }

    /**
     * @return void
     *
     * @coversClass equals
     * @group unit
     * @test
     */
    public function testEqualsIfNotEqual()
    {
        $this->assertFalse($this->firstFraction->equals(new Fraction(1, 4)));
    }

    /**
     * @return void
     *
     * @coversClass compareTo
     * @group unit
     * @test
     */
    public function testCompareToDetectsEqual()
    {
        $this->assertEquals(
            0,
            $this->firstFraction->compareTo(new Fraction(2, 4))
        );
    }

    /**
     * @return void
     *
     * @coversClass compareTo
     * @group unit
     * @test
     */
    public function testCompareToDetectsGreaterThan()
    {
        $this->assertEquals(
            1,
            $this->firstFraction->compareTo(new Fraction(1, 4))
        );
    }

    /**
     * @return void
     *
     * @coversClass compareTo
     * @group unit
     * @test
     */
    public function testCompareToDetectsLessThan()
    {
        $this->assertEquals(
            -1,
            $this->firstFraction->compareTo(new Fraction(3, 4))
        );
    }

    /**
     * @return void
     *
     * @coversClass isReduced
     * @group unit
     * @test
     */
    public function testIsReducedDetectsReduced()
    {
        $this->assertTrue($this->firstFraction->isReduced());
    }

    /**
     * Tests whether {@link Fraction::isReduced} detects a
     * {@link Fraction} which is not reduced.
     *
     * @return void
     * @see isReduced()
     *
     * @coversClass isReduced
     * @group unit
     * @test
     */
    public function testIsReducedDetectsNotReduced()
    {
        $fraction = new Fraction(2, 4, false);
        $this->assertFalse($fraction->isReduced());
    }

    /**
     * @return void
     *
     * @coversClass abs
     * @group unit
     * @test
     */
    public function testAbs()
    {
        $this->assertTrue($this->firstFraction->abs() === $this->firstFraction);
        $fraction = new Fraction(-1, 2);
        $this->assertEquals($this->firstFraction, $fraction->abs());
    }

    /**
     * @return void
     *
     * @coversClass gcd
     * @group unit
     * @test
     */
    public function testGcd()
    {
        $this->assertEquals(1, $this->firstFraction->gcd());
        $this->assertEquals(1, $this->secondFraction->gcd());
    }

    /**
     * @return void
     *
     * @coversClass lcm
     * @group unit
     * @test
     */
    public function testLcm()
    {
        $this->assertEquals(
            6,
            $this->firstFraction->lcm($this->secondFraction)
        );
    }

    /**
     * @return void
     *
     * @coversClass negate
     * @group unit
     * @test
     */
    public function testNegate()
    {
        $this->assertEquals(
            new Fraction(-1, 2),
            $this->firstFraction->negate()
        );
    }

    /**
     * @return void
     *
     * @coversClass reduce
     * @group unit
     * @test
     */
    public function testReduce()
    {
        $this->assertEquals(new Fraction(1, 2), $this->firstFraction->reduce());
        $this->assertEquals(new Fraction(1, 3), $this->secondFraction->reduce());

        $fraction = new Fraction(2, 4, false);
        $this->assertEquals(new Fraction(1, 2), $fraction->reduce());
    }

    /**
     * @return void
     *
     * @coversClass reciprocal
     * @group unit
     * @test
     */
    public function testReciprocal()
    {
        $this->assertEquals(
            new Fraction(2, 1),
            $this->firstFraction->reciprocal()
        );
    }

    /**
     * @return void
     *
     * @coversClass addition
     * @group unit
     * @test
     */
    public function testAddition()
    {
        $this->assertEquals(
            new Fraction(5, 6),
            Fraction::addition($this->firstFraction, $this->secondFraction)
        );
    }

    /**
     * @return void
     *
     * @coversClass add
     * @group unit
     * @test
     */
    public function testAdd()
    {
        $this->assertEquals(
            new Fraction(5, 6),
            $this->firstFraction->add($this->secondFraction)
        );
    }

    /**
     * @return void
     *
     * @coversClass subtraction
     * @group unit
     * @test
     */
    public function testSubtraction()
    {
        $this->assertEquals(
            new Fraction(1, 6),
            Fraction::subtraction($this->firstFraction, $this->secondFraction)
        );
    }

    /**
     * @return void
     *
     * @coversClass subtract
     * @group unit
     * @test
     */
    public function testSubtract()
    {
        $this->assertEquals(
            new Fraction(1, 6),
            $this->firstFraction->subtract($this->secondFraction)
        );
    }

    /**
     * @return void
     *
     * @coversClass multiplication
     * @group unit
     * @test
     */
    public function testMultiplication()
    {
        $this->assertEquals(
            new Fraction(1, 6),
            Fraction::multiplication($this->firstFraction, $this->secondFraction)
        );
    }

    /**
     * @return void
     *
     * @coversClass multiplyBy
     * @group unit
     * @test
     */
    public function testMultiplyBy()
    {
        $this->assertEquals(
            new Fraction(1, 6),
            $this->firstFraction->multiplyBy($this->secondFraction)
        );
    }

    /**
     * @return void
     *
     * @coversClass division
     * @group unit
     * @test
     */
    public function testDivision()
    {
        $this->assertEquals(
            new Fraction(3, 2),
            Fraction::division($this->firstFraction, $this->secondFraction)
        );
    }

    /**
     * @return void
     *
     * @coversClass divideBy
     * @group unit
     * @test
     */
    public function testDivideBy()
    {
        $this->assertEquals(
            new Fraction(3, 2),
            $this->firstFraction->divideBy($this->secondFraction)
        );
    }

    public function testConstructWithNegativeDenominatorReturnsNegativeNumerator()
    {
        $f= new Fraction(2,-3);
        $this->assertEquals(-2, $f->getNumerator());
        $this->assertEquals(3, $f->getDenominator());

    }

    /**
     *
     * @dataProvider rationalFloats
     *
     * @param float $real
     * @param int $num
     * @param int $den
     */
    public function testFromRealWithRationalValuesReturnsFraction($real, $num, $den)
    {
        $f = Fraction::fromReal($real);
        $this->assertInstanceOf(self::$classNameUnderTest, $f);
        $this->assertEquals($num, $f->getNumerator());
        $this->assertEquals($den, $f->getDenominator());
    }

    public function rationalFloats()
    {
        return [
            [1.2345, 2469, 2000],
            [0.3333, 3333, 10000],  //should be 1/3
            [-2.5, -25, 10],        //should be -5/2
        ];
    }

    /**
     *
     * @dataProvider rationalFloats2
     * @param float $real
     * @param int $num
     * @param int $den
     */
    public function testFromRealUsingContinuedFractionReturnsFraction($real, $num, $den)
    {
        $f = Fraction::fromRealViaContinuedFractions($real);
        $this->assertInstanceOf(self::$classNameUnderTest, $f);
        $this->assertEquals($num, $f->getNumerator());
        $this->assertEquals($den, $f->getDenominator());
    }

    /**
     * @see https://www.math.toronto.edu/mathnet/questionCorner/dectofract.html
     * for a possible way to ensure 0.33333n => 1/3 in the reduce() method
     *
     * @return array
     */
    public function rationalFloats2()
    {
        return [
            [1.2345, 2011, 1629],
            [0.3333, 3333, 10000],  //should be 1/3.
            [-2.5, -5, 2],
        ];
    }


    public function irrationalFloats()
    {
        return [
            //golden mean approximation. an irrational number- you'll never factor this - well,
            // you can up to the limit of float precision
            //[1.61803398874989484820, 161803398874989, 100000000000000],  //using existing function
            //[1.61803398874989484820, 987, 610],  //using continued fractions

            //Pi approximation 22/7 is a popular approximation but not correct
            //[M_PI, 314159265358979, 100000000000000], //using existing function
            //[M_PI, 355, 113], //using continued fractions

            //square root of 2 approximation- again - only up to the limit of float precision
            //other square and cube roots are irrational
            //[sqrt(2), 14142135623731, 10000000000000],  //using existing function
            //[sqrt(2), 1393, 985], //using continued fractions

            //euler's number approximation - float precision
            //[M_EULER, 57721566490153, 100000000000000], //using existing function
            //[M_EULER, 228, 395], //using continued fractions
        ];
    }
}
