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
        $questions = array();
        foreach ($score_apples as $id => $value) {
            $questions += array($id => $this->questions[$id] ?? null);
        }
        $this->merge([
            'questions' => $questions,
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
            'questions'    => 'required|array',
            "questions.*" => [
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
            'questions.*.required' => 'いずれかを選択してください。',
        ];
    }
}
