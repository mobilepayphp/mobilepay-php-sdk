<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

use Psr\Http\Client\ClientInterface as PsrClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class Client implements ClientInterface
{
    public function __construct(
        private readonly PsrClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly ResponseHandlerInterface $responseHandler,
        private readonly string $apiHost,
        private readonly string $apiKey
    ) {
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        $psr7Request = $this->requestFactory->createRequest($request->getMethod(), $this->apiHost.$request->getUri());

        // todo: add custom header
        //        foreach($request->getHeaders() as $header) {
        //            $psr7Request = $psr7Request->withHeader($header->getName(), $header->getValue());
        //        }

        $psr7Request = $psr7Request
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Authorization', 'Bearer '.$this->apiKey)
        ;

        $requestBody = $request->getBody();
        if (null !== $requestBody) {
            $psr7Request = $psr7Request->withBody(
                $this->streamFactory->createStream(
                    // todo: add custom encoder
                    json_encode($requestBody, JSON_THROW_ON_ERROR)
                )
            );
        }

        $psr7Response = $this->httpClient->sendRequest($psr7Request);

        $statusCode = $psr7Response->getStatusCode();
        $contents = $psr7Response->getBody()->getContents();

        return $this->responseHandler->handle(
            $statusCode,
            // todo: add custom decoder
            empty($contents) ? [] : json_decode($contents, true, 512, JSON_THROW_ON_ERROR)
        );
    }
}
