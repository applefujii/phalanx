<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\AptitudeQuestion;

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
            "question" => [
                'required_',
            ],
            "sort" => [
                'required',
                'numeric',
                'max:999',
                'min:0',
                //自身と論理削除されたものを除いてユニーク
                Rule::unique(AptitudeQuestion::class)->ignore($this->id)->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            "scores.*" => [
                'nullable',
                'regex:/(^[+-]?\d+$|^F{1}$)/u',// 整数かF
                'max:6',
            ],
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'scores.*.regex' => '半角数字の整数かFを入力してください。',
            'scores.*.max' => '6桁以下で入力してください。',
        ];
    }
}

