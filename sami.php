<?php
/**
 * FlorianWolters\Component\Number\Fraction
 *
 * PHP Version 5.4
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2011-2014 Florian Wolters (http://blog.florianwolters.de)
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Core-DebugPrint
 */

use Sami\Sami;

return new Sami(
    __DIR__ . '/src/main/php',
    [
        'theme' => 'enhanced',
        'title' => 'FlorianWolters\Component\Core\DebugPrint API',
        'build_dir' => __DIR__ . '/review/api',
        'cache_dir' => __DIR__ . '/build/sami',
        'default_opened_level' => 2
    ]
);
