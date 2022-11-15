<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment;

use MobilePayPhp\MobilePay\AppPayment\Exception\InvalidArgumentException;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\DateTimeFactoryTest
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
