<?php
//https://sharemycode.fr/u69
namespace App\Tests\Service;

use App\Service\Utils;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
    public function puissanceProvider()
    {
        return [
            '2 puissance 3'  => [2, 3, 8],
            '1000 puissance 0' => [1000, 0, 1],
            '0 puissance 0' => [0, 0, 1],
            '1000 puissance 2'  => [1000, 2, 1000000]
        ];
    }

    /**
     * @dataProvider puissanceProvider
     */
    public function testPuissance($a, $b, $expected)
    {
        $res = Utils::puissance($a, $b);
        $this->assertSame($expected, $res);
    }
    public function testPuissanceThrowsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $a = 5;
        $n = -5;
        $res = Utils::puissance($a, $n);
    }
}

