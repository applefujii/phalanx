<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfficeRequest extends FormRequest
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
            'office_name' => ['required',"max:255",  Rule::unique('offices')->whereNull("deleted_at")->ignore($this->office)],
            "en_office_name" => ["required", "alpha_dash", "max:255", Rule::unique("offices")->whereNull("deleted_at")->ignore($this->office)],
            'sort' => ['required', "numeric", "min:0", "max:9999", Rule::unique('offices')->whereNull("deleted_at")->ignore($this->office)],
        ];
    }
}
