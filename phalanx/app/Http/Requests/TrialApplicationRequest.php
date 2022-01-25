<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\HolidayRule;

class TrialApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:50',
            ],
            'name_kana' => [
                'required',
                'regex:/^[ァ-ヴー\s　]+$/u',
                'max:50',
            ],
            'office_id' => [
                'required',
                Rule::exists('offices', 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'desired_date' => [
                'required',
                'date',
                new HolidayRule(),
            ],
            'email' => [
                'required',
                'email:rfc',
            ],
            'phone_number' => [
                'required',
                'regex:/^[0-9-]+$/u',
            ],
            'comment' => [
                'max:500',
            ],
        ];
    }
}
