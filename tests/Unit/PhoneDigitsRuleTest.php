<?php

namespace Tests\Unit;

use App\Rules\PhoneDigitsRule;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PhoneDigitsRuleTest extends TestCase
{
    public function test_phone_rule_accepts_common_country_formats_by_digit_count(): void
    {
        $valid = Validator::make([
            'phone' => '+7 999 123-45-67',
        ], [
            'phone' => ['required', new PhoneDigitsRule()],
        ]);

        $this->assertFalse($valid->fails());
    }

    public function test_phone_rule_rejects_too_short_numbers(): void
    {
        $invalid = Validator::make([
            'phone' => '12345',
        ], [
            'phone' => ['required', new PhoneDigitsRule()],
        ]);

        $this->assertTrue($invalid->fails());
    }
}
