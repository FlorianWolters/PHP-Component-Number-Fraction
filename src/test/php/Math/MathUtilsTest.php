<?php
/**
 * FlorianWolters\Component\Math\MathUtilsTest
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
 * Test class for {@see MathUtils}.
 *
 * @since  Class available since Release 0.1.0
 * @covers FlorianWolters\Component\Math\MathUtils
 * @todo   Add more test cases.
 */
class MathUtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testConstantE()
    {
        $expected = 2.718281828459045;
        $actual = MathUtils::E;

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testConstantPI()
    {
        $expected = 3.141592653589793;
        $actual = MathUtils::PI;

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function absProvider()
    {
        return [
            [0, 0],
            [1, -1],
            [2, -2],
            [99, -99],
            [999, -999],
            [9999, -9999],
            [1, 1]
        ];
    }

    /**
     * @coversClass abs
     * @dataProvider absProvider
     * @test
     */
    public function testAbs($expected, $number)
    {
        $actual = MathUtils::abs($number);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function ceilProvider()
    {
        return [
            [0, 0],
            [-1, -1],
            [1, 1],
            [1, .1],
            [1, .4],
            [1, .9],
            [1, .6]
        ];
    }

    /**
     * @coversClass ceil
     * @dataProvider ceilProvider
     * @test
     */
    public function testCeil($expected, $number)
    {
        $actual = MathUtils::ceil($number);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function gcdProvider()
    {
        return [
            [0, 0, 0],
            [1, 1, 1],
            [1, 1, 2],
            [2, 2, 4],
            [-1, -1, -1]
        ];
    }

    /**
     * @coversClass gcd
     * @dataProvider gcdProvider
     * @test
     */
    public function testGcd($expected, $first, $second)
    {
        $actual = MathUtils::gcd($first, $second);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function lcmProvider()
    {
        return [
            [1, 1, 1],
            [36, 12, 18],
            [-1, -1, -1]
        ];
    }

    /**
     * @coversClass lcm
     * @dataProvider lcmProvider
     * @test
     */
    public function testLcm($expected, $first, $second)
    {
        $actual = MathUtils::lcm($first, $second);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function maxProvider()
    {
        return [
            [0, 0, 0],
            [0, 0, -1],
            [0, -1, 0],
            [1, 0, 1],
            [1, 1, 0],
            [0, 0, -.1],
            [0, -.1, 0]
        ];
    }

    /**
     * @coversClass max
     * @dataProvider maxProvider
     * @test
     */
    public function testMax($expected, $first, $second)
    {
        $actual = MathUtils::max($first, $second);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function minProvider()
    {
        return [
            [0, 0, 0],
            [-1, 0, -1],
            [-1, -1, 0],
            [0, 0, 1],
            [0, 1, 0],
            [-.1, 0, -.1],
            [-.1, -.1, 0]
        ];
    }

    /**
     * @coversClass min
     * @dataProvider minProvider
     * @test
     */
    public function testMin($expected, $first, $second)
    {
        $actual = MathUtils::min($first, $second);
        $this->assertEquals($expected, $actual);
    }
}
