<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\AptitudeQuestion;

class AptitudeQuestionManageAllRequest extends FormRequest
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
            "aptitude_questions.*.question" => [
                'required',
            ],
            "aptitude_questions.*.sort" => [
                'required',
                'numeric',
                'max:999',
                'min:0',
                'distinct'// 重複ダメ
            ],
            "aptitude_questions.*.scores.*" => [
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
            'aptitude_questions.*.scores.*.regex' => '半角数字の整数かFを入力してください。',
            'aptitude_questions.*.scores.*.max' => '6桁以下で入力してください。',
        ];
    }
}

