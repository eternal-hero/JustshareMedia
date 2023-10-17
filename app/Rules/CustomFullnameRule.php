<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomFullnameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(strlen($value) < 5) {
            return false;
        }
        $nameParts = explode(' ', $value);
        if(count($nameParts) == 2) {
            return true;
        }

        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please enter valid First and Last name ';
    }
}
