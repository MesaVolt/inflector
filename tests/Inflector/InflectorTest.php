<?php
declare(strict_types=1);

namespace MesaVolt\Tests\Inflector;

use MesaVolt\Inflector\Inflector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class InflectorTest extends TestCase
{
    public function test_simplePlural(): void
    {
        $this->assertEquals('développeur', Inflector::plural('développeur', 1));
        $this->assertEquals('développeurs', Inflector::plural('développeur', 2));
        $this->assertEquals('kilo', Inflector::plural('kilo', 1.5));
        $this->assertEquals('kilos', Inflector::plural('kilo', 2.5));
        $this->assertEquals('développeur', Inflector::plural('développeur', ['test']));
        $this->assertEquals('développeurs', Inflector::plural('développeur', ['test', 'array']));
    }

    #[DataProvider('dataProvider_exceptions')]
    public function test_exceptions(string $singular, string $expectedPlural): void
    {
        $this->assertEquals($singular, Inflector::plural($singular, 1));
        $this->assertEquals($expectedPlural, Inflector::plural($singular, 2));
    }

    public static function dataProvider_exceptions(): array
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
            ['joujou', 'joujoux'],
            ['pou', 'poux'],

            // -ail
            ['éventail', 'éventails'],
            ['corail', 'coraux'],
        ];
    }

    public function test_invalidCriteria(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('got string');
        Inflector::plural('cheval', 'abc');
    }
}
