<?php

namespace MesaVolt\Inflector;

abstract class Inflector
{
    /**
     * Transforms a singular expression into its plural equivalent, if the criteria is considered as greater than 1.
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
            throw new \InvalidArgumentException(sprintf('Invalid argument provided to %s - expected countable, array or numeric, got %s', __METHOD__, get_class($criteria)));
        }

        if ($count <= 1) {
            return $singular;
        }

        if (!$plural) {
            $_auExceptions = ['landau', 'sarrau', 'bleu', 'pneu'];
            $_alExceptions = ['aval', 'bal', 'carnaval', 'chacal', 'cérémonial', 'festival', 'pal', 'régal'];
            $_ouExceptions = ['bijou', 'caillou', 'chou', 'genou', 'hibou', ''];
            $_ailExceptions = ['bail', 'corail', 'émail', 'fermail', 'gemmail', 'soupirail', 'travail', 'vantail', 'ventail', 'vitrail'];

            if (!in_array($singular, $_auExceptions, true) && (self::endsWith($singular, 'au') || self::endsWith($singular, 'eau') || self::endsWith($singular, 'eu'))) {
                $plural = $singular.'x';
            } elseif (!in_array($singular, $_alExceptions, true) && self::endsWith($singular, 'al')) {
                $plural = substr($singular, 0, strlen($singular) - strlen('al')).'aux';
            } elseif (in_array($singular, $_ouExceptions, true) && self::endsWith($singular, 'ou')) {
                $plural = $singular.'x';
            } elseif (in_array($singular, $_ailExceptions, true) && self::endsWith($singular, 'ail')) {
                $plural = substr($singular, 0, strlen($singular) - strlen('ail')).'aux';
            } else {
                $plural = $singular.'s';
            }
        }

        return $plural;
    }

    /**
     * Returns true if the specified $haystack ends with the specified $needle.
     */
    private static function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        if ($length === 0) {
            return false;
        }

        return substr($haystack, -$length) === $needle;
    }
}
