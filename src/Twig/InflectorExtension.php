<?php

namespace MesaVolt\Twig;

use MesaVolt\Inflector\Inflector;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class InflectorExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('plural', [Inflector::class, 'plural']),
        ];
    }
}
