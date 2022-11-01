<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use Jschaedl\MobilePay\AppPayment\Exception\InvalidArgumentException;

/**
 * @see \Jschaedl\MobilePay\AppPayment\DateTimeFactoryTest
 */
final class DateTimeFactory
{
    public static function fromString(string $dateTimeString): \DateTimeImmutable
    {
        if (!$date = \DateTimeImmutable::createFromFormat(\DateTimeImmutable::ISO8601, $dateTimeString)) {
            throw new InvalidArgumentException('Given datetime string has wrong format. Please use "\DateTimeImmutable::ISO8601"');
        }

        return $date;
    }
}
