<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Component\Parameters\Tests;

use Max107\Component\Parameters\Parameters;
use PHPUnit\Framework\TestCase;

class ParametersTest extends TestCase
{
    public function testCastToType()
    {
        $bag = new Parameters([
            'test' => '123.321',
            'test_boolean_true' => '1',
            'test_boolean_false' => '0',
            'test_alpha' => 'qwe123',
            'array' => [1, 2, 3],
        ]);
        $this->assertSame(123.321, $bag->getFloat('test'));
        $this->assertSame(0.0, $bag->getFloat('test_alpha'));

        $this->assertSame(123, $bag->getInt('test'));
        $this->assertSame(0, $bag->getInt('test_alpha'));

        $this->assertSame('123.321', $bag->get('test'));
        $this->assertSame('123321', $bag->getDigits('test'));
        $this->assertSame('qwe123', $bag->getAlnum('test_alpha'));
        $this->assertSame('qwe', $bag->getAlpha('test_alpha'));
        $this->assertTrue($bag->getBoolean('test_boolean_true'));
        $this->assertFalse($bag->getBoolean('test_boolean_false'));
        $this->assertInstanceOf(\Iterator::class, $bag->getIterator());
        $this->assertSame(['1', '2', '3'], $bag->filter('array', []));
        $this->assertCount(5, $bag);
        $this->assertSame([
            'test' => '123.321',
            'test_boolean_true' => '1',
            'test_boolean_false' => '0',
            'test_alpha' => 'qwe123',
            'array' => [1, 2, 3]
        ], $bag->all());
    }
}
