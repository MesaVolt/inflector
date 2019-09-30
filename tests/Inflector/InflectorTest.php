<?php
declare(strict_types=1);

namespace MesaVolt\Tests\Inflector;

use MesaVolt\Inflector\Inflector;
use PHPUnit\Framework\TestCase;

final class InflectorTest extends TestCase
{
    public function test_simplePlural(): void
    {
        $this->assertEquals('développeur', Inflector::plural('développeur', 1));
        $this->assertEquals('développeurs', Inflector::plural('développeur', 2));
        $this->assertEquals('développeur', Inflector::plural('développeur', ['test']));
        $this->assertEquals('développeurs', Inflector::plural('développeur', ['test', 'array']));
    }

    /**
     * @dataProvider dataProvider_exceptions
     */
    public function test_exceptions(string $singular, string $expectedPlural): void
    {
        $this->assertEquals($singular, Inflector::plural($singular, 1));
        $this->assertEquals($expectedPlural, Inflector::plural($singular, 2));
    }

    public function dataProvider_exceptions(): array
    {
        return [
            // -au, -eau, -eu
            ['tuyau', 'tuyaux'],
            ['agneau', 'agneaux'],
            ['jeu', 'jeux'],
            ['pneu', 'pneus'],

            // -al
            ['arsenal', 'arsenaux'],
            ['aval', 'avals'],

            // -ou
            ['fou', 'fous'],
            ['bijou', 'bijoux'],

            // -ail
            ['éventail', 'éventails'],
            ['corail', 'coraux'],
        ];
    }
}
