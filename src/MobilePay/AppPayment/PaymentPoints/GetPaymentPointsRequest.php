<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\PaymentPoints;

use Jschaedl\Api\IsGetTrait;
use Jschaedl\Api\RequestInterface;

/**
 * @see \Jschaedl\MobilePay\AppPayment\PaymentPoints\GetPaymentPointsRequestTest
 */
final class GetPaymentPointsRequest implements RequestInterface
{
    use IsGetTrait;

    public function __construct(private readonly ?int $pageNumber = null, private readonly ?int $pageSize = null)
    {
    }

    public function getUri(): string
    {
        $paginationData = [];
        if ($this->pageNumber) {
            $paginationData['pageNumber'] = $this->pageNumber;
        }
        if ($this->pageSize) {
            $paginationData['pageSize'] = $this->pageSize;
        }

        $query = http_build_query($paginationData);

        return '/v1/paymentpoints'.(empty($query) ? '' : ('?'.$query));
    }
}
