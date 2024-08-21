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
        try
        {
            $recaptcha = new \ReCaptcha\ReCaptcha(config('services.recaptcha.secret'));

            $resp = $recaptcha->setExpectedHostname('api.rashm.com.sa')
                        ->setExpectedAction('/')
                        ->setScoreThreshold(0.5)
                        ->verify($value, request()->ip());

            if(! $resp->isSuccess()) {

                $fail('Recaptcha verification fails.');
            }
        } catch(\Throwable)
        {
            $fail('Recaptcha verification fails.');
        }
    }
}
