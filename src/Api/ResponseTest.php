<?php

declare(strict_types=1);

namespace Jschaedl\Api;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Jschaedl\Api\Response
 *
 * @group unit
 */
final class ResponseTest extends TestCase
{
    public function test_it_can_create_a__response(): void
    {
        $response = new Response(200, ['items' => ['firstname' => 'Jan', 'lastname' => 'Schädlich']]);

        static::assertSame(200, $response->getStatusCode());

        static::assertArrayHasKey('items', $response->getBody());
        static::assertArrayHasKey('firstname', $response->getBody()['items']);
        static::assertArrayHasKey('lastname', $response->getBody()['items']);

        static::assertSame('Jan', $response->getBody()['items']['firstname']);
        static::assertSame('Schädlich', $response->getBody()['items']['lastname']);
    }
}
