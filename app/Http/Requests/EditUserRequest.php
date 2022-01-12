<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\IdentiferRule;
use App\Rules\KatakanaRule;
use App\Rules\AsciiRule;
use App\Models\User;

class EditUserRequest extends FormRequest
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
            // 'user_type_id' => ['prohibited'],
            'office_id' => ['required', 'exists:offices,id'],
            'name' => ['required', 'string', 'max:255'],
            'name_katakana' => ['required', 'string', 'max:255', new KatakanaRule],
            'login_name' => [
                'required',
                'string',
                new IdentiferRule,
                'min:3',
                'max:30',
                Rule::unique(User::class)->ignore($this->id)->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'password' => ['nullable', 'string', new AsciiRule, 'min:8', 'max:30', 'confirmed'],
        ];
    }
}
