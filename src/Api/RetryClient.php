<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

/**
 * Client implementation which provides a retry option of failed requests due to network and server errors using this strategy:
 * Retrying requests up to a fixed number of times using an exponential backoff with jitter strategy.
 *
 * @see https://mobilepaydev.github.io/MobilePay-Payments-API/docs/app-payments/build-basics#retry-policy
 * @see \MobilePayPhp\Api\RetryClientTest
 */
final class RetryClient implements ClientInterface
{
    use RetryTrait;

    public function __construct(
        private readonly ClientInterface $client,
        private readonly int $maxRetries = 3,
        private readonly bool $addJitter = true,
    ) {
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        return $this->retry(
            fn (): ResponseInterface => $this->client->request($request),
            $this->maxRetries,
            $this->addJitter
        );
    }
}
