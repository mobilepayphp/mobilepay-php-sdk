<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

use MobilePayPhp\Api\Exception\ServerException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MobilePayPhp\Api\RetryTrait
 *
 * @uses \MobilePayPhp\Api\Response
 * @uses \MobilePayPhp\Api\Exception\ResponseException
 * @uses \MobilePayPhp\Api\Exception\ServerException
 *
 * @group integration
 */
final class RetryTraitTest extends TestCase
{
    public function test_no_retry(): void
    {
        $testRetry = new class() {
            use RetryTrait;

            public function run(): ResponseInterface
            {
                return $this->retry(fn (): ResponseInterface => new Response(200, ['done']));
            }
        };

        static::assertEquals(200, $testRetry->run()->getStatusCode());
    }

    public function test_retry_successful_before_max_attempts_reached(): void
    {
        $testRetry = new class() {
            use RetryTrait;

            public function run(): ResponseInterface
            {
                $attempt = 0;

                return $this->retry(
                    function () use (&$attempt): ResponseInterface {
                        ++$attempt;
                        if ($attempt <= 2) {
                            throw new ServerException(500, 'attempts reached');
                        }

                        return new Response(200, ['success']);
                    },
                    3,
                    true
                );
            }

            private function getWaitTimeFactor(): int
            {
                return 1;
            }
        };

        static::assertEquals(200, $testRetry->run()->getStatusCode());
    }

    public function test_retry_throws_exception_after_maximum_retries(): void
    {
        $testRetry = new class() {
            use RetryTrait;

            public function run(): ResponseInterface
            {
                $attempt = 0;

                return $this->retry(
                    function () use (&$attempt): ResponseInterface {
                        ++$attempt;
                        if ($attempt <= 2) {
                            throw new \Exception('max attempts reached');
                        }

                        return new Response(200, ['success']);
                    },
                    1,
                    true
                );
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('max attempts reached');

        $testRetry->run();
    }

    public function test_retry_re_throws_exception(): void
    {
        $testRetry = new class() {
            use RetryTrait;

            public function run(): ResponseInterface
            {
                return $this->retry(fn () => throw new \Exception('failure'));
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('failure');

        $testRetry->run();
    }

    public function test_retry_throws_exception_on_negative_attempts(): void
    {
        $testRetry = new class() {
            use RetryTrait;

            public function run(): ResponseInterface
            {
                return $this->retry(
                    fn (): ResponseInterface => new Response(200, ['success']),
                    -1,
                    true
                );
            }
        };

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('negative');

        $testRetry->run();
    }
}
