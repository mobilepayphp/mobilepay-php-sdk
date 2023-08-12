<?php

declare(strict_types=1);

namespace MobilePayPhp\Api\Validation;

use MobilePayPhp\Api\Validation\Exception\InvalidArgumentException;

/**
 * @see \MobilePayPhp\Api\Validation\ValidationTraitTest
 */
trait ValidationTrait
{
    /**
     * @param array<string, mixed> $data
     *
     * @throws InvalidArgumentException
     */
    final public static function validate(array $data, ValidationRule ...$validationRules): void
    {
        // 1. all mandatory are there
        $neededProperties = array_filter(
            array_map(fn (ValidationRule $validationRule): ?string => $validationRule->isMandatory() ? $validationRule->getName() : null, $validationRules)
        );

        if ($missingData = array_diff_key(array_flip($neededProperties), $data)) {
            throw new InvalidArgumentException(sprintf('data has missing properties: %s', implode(', ', array_keys($missingData))));
        }

        // 2. all mandatory are not empty
        $emptyProperties = self::findEmptyProperties($neededProperties, $data);
        if (!empty($emptyProperties)) {
            throw new InvalidArgumentException(sprintf('empty data for properties: %s', implode(', ', $emptyProperties)));
        }

        // 3. all (mandatory and optional) have the correct type
        $invalidProperties = self::findInvalidProperties($validationRules, $data);
        if (!empty($invalidProperties)) {
            throw new InvalidArgumentException(sprintf('invalid type for properties: %s', implode(', ', $invalidProperties)));
        }
    }

    /**
     * @return mixed[]
     */
    private static function findEmptyProperties(array $neededProperties, array $data): array
    {
        $emptyProperties = [];
        foreach ($neededProperties as $neededProperty) {
            if (\array_key_exists($neededProperty, $data) && empty($data[$neededProperty])) {
                $emptyProperties[] = $neededProperty;
            }
        }

        return $emptyProperties;
    }

    /**
     * @return mixed[]
     */
    private static function findInvalidProperties(array $validationRules, array $data): array
    {
        $invalidProperties = [];
        foreach ($validationRules as $validationRule) {
            if (\array_key_exists($validationRule->getName(), $data)
                && \gettype($data[$validationRule->getName()]) !== $validationRule->getType()
                && null !== $data[$validationRule->getName()]
            ) {
                $invalidProperties[] = $validationRule->getName();
            }
        }

        return $invalidProperties;
    }
}
