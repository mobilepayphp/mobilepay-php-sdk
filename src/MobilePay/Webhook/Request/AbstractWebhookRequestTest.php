<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\Webhook\Request;

use MobilePayPhp\Api\RequestInterface;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

abstract class AbstractWebhookRequestTest extends TestCase
{
    abstract public function dataProvider(): \Generator;

    /**
     * @dataProvider dataProvider
     */
    public function test_request(string $expectedMethod, string $expectedUri, ?array $expectedBody, RequestInterface $request): void
    {
        assertSame($expectedMethod, $request->getMethod());
        assertSame($expectedUri, $request->getUri());
        assertSame($expectedBody, $request->getBody());
    }
}
