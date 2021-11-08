<?php

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
     * ラジオボタンが未選択なら空のrequestを作成
     */
    protected function prepareForValidation()
    {
        $score_apples = $this->score_apples;
        $answers = array();
        foreach ($score_apples as $id => $value) {
            $answers += array($id => $this->answers[$id] ?? null);
        }
        $this->merge([
            'answers' => $answers,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'answers'    => 'required|array',
            "answers.*" => [
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
            'answers.*.required' => 'いずれかを選択してください。',
        ];
    }
}
