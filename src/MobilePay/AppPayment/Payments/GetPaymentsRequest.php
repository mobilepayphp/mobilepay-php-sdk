<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment\Payments;

use MobilePayPhp\Api\IsGetTrait;
use MobilePayPhp\Api\RequestInterface;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\Payments\GetPaymentsRequestTest
 */
final class GetPaymentsRequest implements RequestInterface
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

        return '/v1/payments'.(empty($query) ? '' : ('?'.$query));
    }
}
