<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * @covers \Jschaedl\MobilePay\AppPayment\PaymentPointsGateway
 * @covers \Jschaedl\Api\Client
 *
 * @uses \Jschaedl\MobilePay\AppPayment\GatewayTestTrait
 * @uses \Jschaedl\Api\IsGetTrait
 * @uses \Jschaedl\Api\Response
 * @uses \Jschaedl\Api\Validation\ValidationRule
 * @uses \Jschaedl\MobilePay\AppPayment\Id
 * @uses \Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointResponse
 * @uses \Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsRequest
 * @uses \Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsResponse
 * @uses \Jschaedl\MobilePay\AppPayment\PaymentPoints\PaymentPointState
 * @uses \Jschaedl\MobilePay\AppPayment\ResponseHandler
 *
 * @group integration
 */
final class PaymentPointsGatewayTest extends TestCase
{
    use GatewayTestTrait;
    use MatchesSnapshots;

    public function test_paymentPoints(): void
    {
        $mobilePayClient = $this->getMobilePayClient();
        $gateway = new PaymentPointsGateway($mobilePayClient);

        $response = $gateway->getPaymentPoints();

        $this->assertMatchesObjectSnapshot($response);
    }
}
