<?php

declare(strict_types=1);

namespace MobilePayPhp\Api;

use JsonSchema\Validator;

trait JsonSchemaValidationTrait
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    private function validate(array $payload, string $schemaPath): void
    {
        // JsonSchema Validator needs an object
        if (false === $json = json_encode($payload, JSON_THROW_ON_ERROR)) {
            // todo throw ValidationException
            // throw ValidationException::jsonError();
        }

        $data = json_decode($json, false, 512, JSON_THROW_ON_ERROR);

        $this->validator->validate($data, (object) ['$ref' => 'file://'.$schemaPath]);

        if (!$this->validator->isValid()) {
            throw ValidationException::fromValidationErrors(array_map(static fn (array $error): \MobilePayPhp\Api\ValidationError => ValidationError::fromArray($error), $this->validator->getErrors()));
        }
    }
}

final class ValidationException extends \RuntimeException
{
    public function __construct(
        private readonly array $validationErrors
    ) {
    }

    public static function fromValidationErrors(array $validationErrors): self
    {
        return new self($validationErrors);
    }

    /**
     * @return mixed[]
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}

final class ValidationError
{
    public function __construct(
        private readonly string $property,
        private readonly string $message
    ) {
    }

    public static function fromArray(array $error): self
    {
        return new self($error['property'], $error['message']);
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
