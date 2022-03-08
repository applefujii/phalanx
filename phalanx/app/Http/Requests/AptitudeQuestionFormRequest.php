<?php
/**
 * 適性診断フォームのバリデーション
 *
 * @author Fumio Mochizuki
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AptitudeQuestionFormRequest extends FormRequest
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
            'answers.*.answer'    => [
                'required',
                Rule::in(config('const.option')),
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
            'answers.*.answer.required' => 'いずれかを選択してください。',
        ];
    }
}
