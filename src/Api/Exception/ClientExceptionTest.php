<?php

declare(strict_types=1);

namespace Jschaedl\Api\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\Api\Exception\ClientException
 * @covers \Jschaedl\Api\Exception\ResponseException
 *
 * @group unit
 */
final class ClientExceptionTest extends TestCase
{
    public function test_it_can_be_created(): void
    {
        $exception = new ClientException(400, 'Bad Request');
        static::assertSame('400 Bad Request', $exception->getMessage());
    }

    /**
     * @dataProvider provideInvalidCodes
     */
    public function test_it_throws_InvalidArgumentException_on_non_4xx_code(int $invalidCode): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Class "Jschaedl\Api\Exception\ClientException" constructor argument $code must be a 4xx status code');

        new ClientException($invalidCode, 'invalid code');
    }

    public function provideInvalidCodes(): iterable
    {
        yield [500];
        yield [300];
        yield [200];
        yield [100];
    }
}
