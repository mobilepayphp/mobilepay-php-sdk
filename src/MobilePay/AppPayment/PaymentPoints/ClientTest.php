<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\PaymentPoints;

use MobilePayPhp\Api\ClientInterface;
use MobilePayPhp\Api\RequestInterface;
use MobilePayPhp\Api\Response;
use MobilePayPhp\Api\ResponseInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\Client
 *
 * @uses \MobilePayPhp\Api\Response
 * @uses \MobilePayPhp\Api\Validation\ValidationRule
 * @uses \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointResponse
 * @uses \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsRequest
 * @uses \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsResponse
 * @uses \MobilePayPhp\MobilePay\AppPayment\PaymentPoints\PaymentPointState
 * @uses \MobilePayPhp\MobilePay\Id
 *
 * @group integration
 */
final class ClientTest extends TestCase
{
    public function test_getPaymentPoints(): void
    {
        $client = new Client(new MockPaymentPointsClient(new Response(200, [
            'pageSize' => 10,
            'paymentPoints' => [[
                'paymentPointId' => '56cefd9e-71a4-403c-927a-28f4f35fcc2d',
                'paymentPointName' => 'Test',
                'state' => 'active',
            ]],
        ])));

        $paymentPointRequest = $client->getPaymentPoints();

        static::assertSame(10, $paymentPointRequest->getPageSize());
        static::assertNull($paymentPointRequest->getNextPageNumber());
        static::assertCount(1, $paymentPoints = $paymentPointRequest->getPaymentPoints());
        static::assertSame('56cefd9e-71a4-403c-927a-28f4f35fcc2d', $paymentPoints[0]->getPaymentPointId()->toString());
        static::assertSame('Test', $paymentPoints[0]->getPaymentPointName());
        static::assertTrue($paymentPoints[0]->getState()->isActive());
    }
}

class MockPaymentPointsClient implements ClientInterface
{
    public function __construct(
        private readonly ResponseInterface $response
    ) {
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        return $this->response;
    }
}
