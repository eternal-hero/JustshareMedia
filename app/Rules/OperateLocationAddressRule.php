<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OperateLocationAddressRule implements Rule
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
        if(request()->get('latitude') != '' && request()->get('longitude') != '' && strlen(request()->get('address')) > 4) {
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
        return 'Please enter valid :attribute ';
    }
}
