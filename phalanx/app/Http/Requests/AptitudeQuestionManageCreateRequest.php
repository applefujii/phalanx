<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AptitudeQuestionManageCreateRequest extends FormRequest
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
            "question" => [
                'required_',
            ],
            "sort" => [
                'required',
                'numeric',
                'max:999',
                'min:0',
            ],
            "score_apple" => [
                'nullable',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
            "score_mint" => [
                'nullable',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
            "score_maple" => [
                'nullable',
                'regex:/^[0-9F-]+$/u',
                'max:6',
            ],
        ];
    }
}

