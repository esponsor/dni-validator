<?php

namespace Esponsor\DniValidator\Tests;

use InvalidArgumentException;

final class AssertSpec
{
    private const SUBJECTS = ['person', 'organization', 'either'];

    private const VALIDATIONS = ['checksum', 'structural', 'length'];

    private const REASONS = ['checksum', 'length', 'format', 'component', 'other'];

    /**
     * @param  mixed  $value
     */
    public static function assertValid(mixed $value, string $path): void
    {
        if (! is_array($value) || array_is_list($value)) {
            throw new InvalidArgumentException("{$path}: spec must be a JSON object");
        }

        self::assertNonEmptyString($value['country'] ?? null, 'country', $path);
        self::assertNonEmptyString($value['type'] ?? null, 'type', $path);
        self::assertNonEmptyString($value['name'] ?? null, 'name', $path);
        self::assertNonEmptyString($value['subject'] ?? null, 'subject', $path);
        self::assertNonEmptyString($value['validation'] ?? null, 'validation', $path);

        if (! in_array($value['subject'], self::SUBJECTS, true)) {
            throw new InvalidArgumentException(
                "{$path}: subject must be one of ".implode(', ', self::SUBJECTS)
            );
        }

        if (! in_array($value['validation'], self::VALIDATIONS, true)) {
            throw new InvalidArgumentException(
                "{$path}: validation must be one of ".implode(', ', self::VALIDATIONS)
            );
        }

        if (! is_array($value['valid'] ?? null) || ! array_is_list($value['valid'])) {
            throw new InvalidArgumentException("{$path}: valid must be an array of strings");
        }

        foreach ($value['valid'] as $index => $entry) {
            if (! is_string($entry)) {
                throw new InvalidArgumentException("{$path}: valid[{$index}] must be a string");
            }
        }

        if (! is_array($value['invalid'] ?? null) || ! array_is_list($value['invalid'])) {
            throw new InvalidArgumentException("{$path}: invalid must be an array");
        }

        foreach ($value['invalid'] as $index => $entry) {
            if (! is_array($entry) || array_is_list($entry)) {
                throw new InvalidArgumentException(
                    "{$path}: invalid[{$index}] must be an object with value and reason"
                );
            }

            self::assertNonEmptyString($entry['value'] ?? null, "invalid[{$index}].value", $path);
            self::assertNonEmptyString($entry['reason'] ?? null, "invalid[{$index}].reason", $path);

            if (! in_array($entry['reason'], self::REASONS, true)) {
                throw new InvalidArgumentException(
                    "{$path}: invalid[{$index}].reason must be one of ".implode(', ', self::REASONS)
                );
            }
        }

        if (array_key_exists('patterns', $value)) {
            if (! is_array($value['patterns']) || ! array_is_list($value['patterns'])) {
                throw new InvalidArgumentException("{$path}: patterns must be an array of strings");
            }

            foreach ($value['patterns'] as $index => $pattern) {
                if (! is_string($pattern)) {
                    throw new InvalidArgumentException("{$path}: patterns[{$index}] must be a string");
                }
            }
        }

        if (array_key_exists('format_cases', $value)) {
            if (! is_array($value['format_cases']) || array_is_list($value['format_cases'])) {
                throw new InvalidArgumentException("{$path}: format_cases must be an object");
            }

            foreach ($value['format_cases'] as $input => $expected) {
                if (! is_string($expected)) {
                    throw new InvalidArgumentException("{$path}: format_cases[{$input}] must be a string");
                }
            }
        }
    }

    private static function assertNonEmptyString(mixed $value, string $label, string $path): void
    {
        if (! is_string($value) || $value === '') {
            throw new InvalidArgumentException("{$path}: {$label} must be a non-empty string");
        }
    }
}
