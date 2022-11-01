<?php

declare(strict_types=1);

namespace Jschaedl\Api;

use Jschaedl\Api\Exception\ServerException;

trait RetryTrait
{
    /**
     * @throws \Exception
     */
    private function retry(callable $callback, int $maxRetries = 3, bool $addJitter = false): ResponseInterface
    {
        $attempt = 0;
        $try = true;

        while ($try) {
            $result = null;
            $exception = null;

            $this->wait($attempt, $addJitter);

            try {
                /** @var ResponseInterface $result */
                $result = call_user_func($callback);
                if (!$result instanceof ResponseInterface) {
                    throw new \RuntimeException('return-type of $callback should be of type ResponseInterface');
                }
            } catch (ServerException $serverException) {
                $exception = $serverException;
            }

            $retry = ++$attempt;

            if ($retry >= $maxRetries && !is_null($exception)) {
                throw $exception;
            }

            $try = $retry < $maxRetries && !is_null($exception);
        }

        return $result;
    }

    private function wait(int $attempt, bool $addJitter): void
    {
        if ($attempt > 0) {
            $waitTime = 1 == $attempt ? 100 : 2 ** $attempt * 100; // exponential strategy
            $waitTime = $addJitter ? random_int(0, $waitTime) : $waitTime; // adding randomness
            // wait
            usleep($waitTime * 1000);
        }
    }
}
