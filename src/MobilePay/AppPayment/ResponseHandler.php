<?php

declare(strict_types=1);

namespace MobilePayPhp\MobilePay\AppPayment;

use MobilePayPhp\Api\Exception\ClientException;
use MobilePayPhp\Api\Exception\ServerException;
use MobilePayPhp\Api\Exception\UnexpectedResponseException;
use MobilePayPhp\Api\Response;
use MobilePayPhp\Api\ResponseHandlerInterface;
use MobilePayPhp\MobilePay\AppPayment\Exception\MobilePayClientException;

/**
 * @see \MobilePayPhp\MobilePay\AppPayment\ResponseHandlerTest
 */
final class ResponseHandler implements ResponseHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function handle(int $statusCode, array $body): Response
    {
        switch ($statusCode) {
            case 200: return new Response($statusCode, $body);
            case 204: return new Response($statusCode);
            case 400: throw new MobilePayClientException(400, $body);
            case 401: throw new ClientException(401, 'Unauthorized');
            case 403: throw new ClientException(403, 'Forbidden');
            case 404: throw new ClientException(404, 'Not Found');
            case 409: throw new MobilePayClientException(409, $body);
            case $statusCode >= 500: throw new ServerException($statusCode, 'Server error');
            default: throw new UnexpectedResponseException($statusCode, $body);
        }
    }
}
