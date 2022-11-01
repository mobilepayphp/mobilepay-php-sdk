<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\Id
 *
 * @group unit
 */
final class IdTest extends TestCase
{
    public function test_it_can_create_new__id(): void
    {
        $id = Id::create();

        static::assertTrue(Uuid::isValid($id->toString()));
        static::assertTrue(Uuid::isValid($id->getId()));
    }

    public function test_it_can_create__id_from_string(): void
    {
        $id = Id::fromString('8a4d5be1-cdf9-45a3-b1aa-47a1e976c5b9');

        static::assertSame('8a4d5be1-cdf9-45a3-b1aa-47a1e976c5b9', $id->toString());
        static::assertSame('8a4d5be1-cdf9-45a3-b1aa-47a1e976c5b9', $id->getId());
    }
}
