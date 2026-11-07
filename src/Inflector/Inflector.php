<?php

namespace MesaVolt\Inflector;

abstract class Inflector
{
    /**
     * Transforms a singular expression into its plural equivalent, if the criteria is 2 or more (French rule: 1.5 kilo, 2 kilos).
     *
     * ```php
     * Inflector::plural('cheval', 2)               // => chevaux
     * ```
     *
     * The third argument ($plural) can be specified, to easily pluralize a whole sentence or override the plural form:
     *
     * ```php
     * Inflector::plural('un petit cheval', 2, 'des petits chevaux')
     * Inflector::plural('cheval', 2, 'chevals')
     * ```
     *
     * @param array|\Countable|int|float|null $criteria
     */
    public static function plural(string $singular, $criteria, ?string $plural = null): string
    {
        if (is_array($criteria) || $criteria instanceof \Countable) {
            $count = count($criteria);
        } elseif (is_numeric($criteria)) {
            $count = $criteria;
        } elseif ($criteria === null) {
            return $singular;
        } else {
            throw new \InvalidArgumentException(sprintf('Invalid argument provided to %s - expected countable, array or numeric, got %s', __METHOD__, get_debug_type($criteria)));
        }

        if ($count < 2) {
            return $singular;
        }

        if (!$plural) {
            $_auExceptions = ['landau', 'sarrau', 'bleu', 'pneu'];
            $_alExceptions = ['aval', 'bal', 'carnaval', 'chacal', 'cérémonial', 'festival', 'pal', 'régal'];
            $_ouExceptions = ['bijou', 'caillou', 'chou', 'genou', 'hibou', 'joujou', 'pou'];
            $_ailExceptions = ['bail', 'corail', 'émail', 'fermail', 'gemmail', 'soupirail', 'travail', 'vantail', 'ventail', 'vitrail'];

            if (!in_array($singular, $_auExceptions, true) && (str_ends_with($singular, 'au') || str_ends_with($singular, 'eau') || str_ends_with($singular, 'eu'))) {
                $plural = $singular.'x';
            } elseif (!in_array($singular, $_alExceptions, true) && str_ends_with($singular, 'al')) {
                $plural = substr($singular, 0, strlen($singular) - strlen('al')).'aux';
            } elseif (in_array($singular, $_ouExceptions, true) && str_ends_with($singular, 'ou')) {
                $plural = $singular.'x';
            } elseif (in_array($singular, $_ailExceptions, true) && str_ends_with($singular, 'ail')) {
                $plural = substr($singular, 0, strlen($singular) - strlen('ail')).'aux';
            } else {
                $plural = $singular.'s';
            }
        }

        return $plural;
    }
}
