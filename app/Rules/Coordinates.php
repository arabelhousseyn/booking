<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Validator;

class Coordinates implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        try {
            $coordinates = explode(',', $value);
            $validator1 = Validator::make(['data' => $coordinates[0]], ['data' => ['numeric', 'between:-90,90']]);
            $validator2 = Validator::make(['data' => $coordinates[1]], ['data' => ['numeric', 'between:-180,180']]);

            if ($validator1->fails() || $validator2->fails()) {
                $fail(trans('exceptions.coordinates'));
            }
        } catch (\Exception $exception) {
            $fail(trans('exceptions.coordinates'));
        }
    }
}
