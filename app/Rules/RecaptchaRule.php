<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaRule implements ValidationRule
{
    const URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {

            $response = Http::asForm()->post(static::URL, [
                'secret' => config('services.recaptcha.RECAPTCHA_SECRET'),
                'response' => $value,
                'remoteip' => \request()->ip()
            ]);

            if(! $response->json('success')) {

                $fail('Recaptcha verification fails.');
            }
        }catch(\Throwable) {

            $fail('Recaptcha verification fails.');
        }
    }
}

