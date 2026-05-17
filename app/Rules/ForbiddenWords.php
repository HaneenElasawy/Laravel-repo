<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ForbiddenWords implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $forbiddenWords = ['spam', 'fake', 'badword'];

        foreach ($forbiddenWords as $word) {
            if (str_contains(strtolower($value), $word)) {
                $fail("The :attribute contains forbidden words.");
            }
        }
    }
}
