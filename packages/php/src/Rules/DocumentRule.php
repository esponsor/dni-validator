<?php

namespace Esponsor\DniValidator\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

abstract class DocumentRule implements ValidationRule
{
    protected object $validator;

    abstract protected function message(): string;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! $this->validator->validate($value)) {
            $fail($this->message());
        }
    }
}
