<?php

namespace Gameball\Exception;

/**
 * The base interface for Gameball exceptions.
 */

// TODO: remove this check once we drop support for PHP 5
if (\interface_exists(\Throwable::class, false)) {

    interface ExceptionInterface extends \Throwable
    {
    }
} else {

    // phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses
    interface ExceptionInterface
    {
    }
    // phpcs:enable
}
