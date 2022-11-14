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

        if ($maxRetries < 0) {
            throw new \RuntimeException('$maxRetries cannot be negative');
        }

        while ($try) {
            $result = null;
            $exception = null;

            $this->wait($attempt, $addJitter);

            try {
                /** @var ResponseInterface $result */
                $result = $callback();
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
        if ($attempt <= 0) {
            return;
        }

        // exponential strategy
        $waitTime = (1 + 2 ** $attempt) * 100;

        if ($addJitter) {
            // jitter by +/- 25%
            $waitTime *= random_int(75, 125) / 100;
        }

        usleep((int) $waitTime * static::getWaitTimeFactor());
    }

    private function getWaitTimeFactor(): int
    {
        return 500;
    }
}
