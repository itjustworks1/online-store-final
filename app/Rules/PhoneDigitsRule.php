<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneDigitsRule implements ValidationRule
{
    public function __construct(
        protected ?string $country = null,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $digits = preg_replace('/\D+/', '', (string) $value) ?? '';

        if ($digits === '') {
            $fail('Введите номер телефона.');

            return;
        }

        $range = $this->resolveCountryRange($digits);
        $length = strlen($digits);

        $min = (int) ($range['min_digits'] ?? 10);
        $max = (int) ($range['max_digits'] ?? 15);

        if ($length < $min || $length > $max) {
            $fail(sprintf(
                'Номер телефона должен содержать от %d до %d цифр.',
                $min,
                $max
            ));
        }
    }

    protected function resolveCountryRange(string $digits): array
    {
        $countries = config('phone.countries', []);
        $default = $countries[config('phone.default_country', 'global')] ?? [
            'min_digits' => 10,
            'max_digits' => 15,
        ];

        $country = $this->country ? ($countries[$this->country] ?? null) : null;

        if ($country) {
            return $country;
        }

        $matched = collect($countries)
            ->filter(fn (array $country): bool => ! empty($country['dial_code']))
            ->sortByDesc(fn (array $country): int => strlen((string) $country['dial_code']))
            ->first(function (array $country) use ($digits): bool {
                $dialCode = preg_replace('/\D+/', '', (string) $country['dial_code']) ?? '';

                return $dialCode !== '' && str_starts_with($digits, $dialCode);
            });

        return $matched ?? $default;
    }
}
