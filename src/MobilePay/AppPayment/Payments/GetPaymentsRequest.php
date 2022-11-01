<?php

declare(strict_types=1);

namespace Jschaedl\MobilePay\AppPayment\Payments;

use Jschaedl\Api\IsGetTrait;
use Jschaedl\Api\RequestInterface;

/**
 * @see \Jschaedl\MobilePay\AppPayment\Payments\GetPaymentsRequestTest
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
