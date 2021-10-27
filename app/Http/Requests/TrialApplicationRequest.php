<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'max:100',
            ],
            'name_kana' => [
                'required',
                'regex:/^[ァ-ヴー]+$/u',
                'max:100',
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
            ],
            'email' => [
                'required',
                'email:rfc',
            ],
            'phone_number' => [
                'required',
                'regex:/^[0-9-]+$/u',
            ],
        ];
    }
}
