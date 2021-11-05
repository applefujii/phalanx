<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AptitudeQuestionManageEditRequest extends FormRequest
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
                'max:999',
                'min:0',
            ],
            "score_apples.*" => [
                'nullable',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
            "score_mints.*" => [
                'nullable',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
            "score_maples.*" => [
                'nullable',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
        ];
    }
}

