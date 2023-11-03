<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $endpoint = config('services.google_recaptcha');

        /* dd(config('services.google_recaptcha')); */

        $response = Http::asForm()->post($endpoint['url'], [
            'secret' => $endpoint['secret_key'],
            'response' => $value,
        ])->json();

        if($response['success'] === false) {
            $fail('Xác thực captcha không thành công. Vui lòng thử lại!');
        }
    }

        /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
/*     public function passes($attribute, $value)
    {
        $endpoint = config('services.google_recaptcha');

        return false;

        $response = Http::asForm()->post($endpoint['url'], [
            'secret' => $endpoint['secret_key'],
            'response' => $value,
        ])->json();

        if(  $response['success'] && $response['score'] > 0.5) {
            return true;
        }

        return false;
    } */

    /**
     * Get the validation error message.
     *
     * @return string
     */
/*     public function message()
    {
        return 'Xác thực Captcha không thành công. Vui lòng thử lại.';
    } */
}
