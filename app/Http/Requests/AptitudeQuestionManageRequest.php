<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AptitudeQuestionManageRequest extends FormRequest
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
            "questions.*" => [
                'required',
            ],
            "sorts.*" => [
                'required',
                'numeric',
                'digits_between:0,99999',
            ],
            "score_apples.*" => [
                'required',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
            "score_mints.*" => [
                'required',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
            "score_maples.*" => [
                'required',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],

            "question" => [
                'required_',
            ],
            "sort" => [
                'required',
                'numeric',
                'digits_between:0,99999',
            ],
            "score_apple" => [
                'required',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
            "score_mint" => [
                'required',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
            "score_maple" => [
                'required',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
        ];
    }
}
