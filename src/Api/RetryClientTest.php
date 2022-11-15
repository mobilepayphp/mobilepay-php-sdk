<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

use MobilePayPhp\Api\Exception\ServerException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\Api\RetryClient
 *
 * @uses \MobilePayPhp\Api\Exception\ResponseException
 * @uses \MobilePayPhp\Api\Exception\ServerException
 *
 * @group integration
 */
final class RetryClientTest extends TestCase
{
    public function test_client_is_called_three_times(): void
    {
        $testRequest = new TestRequest();
        $traceableClient = new TestClient();
        $retryClient = new RetryClient($traceableClient, 3, true);

        try {
            $retryClient->request($testRequest);
        } catch (\Exception) {
            static::assertCount(3, $traceableClient->requests);
        }
    }
}

class TestClient implements ClientInterface
{
    public array $requests = [];

    public function request(RequestInterface $request): ResponseInterface
    {
        $this->requests[] = $request;

        throw new ServerException(500, 'retry client test');
    }
}

class TestRequest implements RequestInterface
{
    use IsGetTrait;

    public function getUri(): string
    {
        return 'test';
    }
}
