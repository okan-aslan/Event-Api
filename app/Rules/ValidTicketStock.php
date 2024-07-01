<?php

namespace App\Rules;

use App\Models\Venue;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTicketStock implements ValidationRule
{
    protected $venueId;

    public function __construct($venueId)
    {
        $this->venueId = $venueId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $venue = Venue::findOrFail($this->venueId);

        if ($value > $venue->capacity) {
            $fail('The ticket stock cannot exceed the venue capacity.');
        }
    }
}
