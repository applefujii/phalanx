<?php
/**
 * 休業日判定
 * 
 * @author Fumio Mochizuki
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;
use Yasumi\Yasumi;

class HolidayRule implements Rule
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
        $date = new Carbon($value);
        // 曜日の取得
        $week = $date->isoFormat('E');
        // 年の取得
        $year = $date->isoFormat('YYYY');
        // その年の祝日の取得
        $holidays = Yasumi::create('Japan', $year);

        if ($week >= 6) {
            return false;
        } else if ($holidays->isHoliday($date)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attributeに土・日曜日、祝日は入力できません。';
    }
}
