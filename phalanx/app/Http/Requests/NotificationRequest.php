<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $target_users = explode(',', $this->target_users);
        $old_target_users = explode(',', $this->old_target_users);
        $start_at = $this->start_date;
        $end_at = $this->end_date;
        if( $this->is_all_day == "0" ) {
            $start_at .= " " . $this->start_time . ":00";
            $end_at .= " " . $this->end_time . ":00";
        } else {
            $start_at .= " 00:00:00";
            $end_at .= " 23:59:59";
        }

        $this->merge([
            'target_users' => $target_users,
            'old_target_users' => $old_target_users,
            'start_at' => $start_at,
            'end_at' => $end_at,
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
            "content" => "required|max:500",
            "start_at" => "required|date_format:Y-m-d H:i:s",
            "end_at" => "required|date_format:Y-m-d H:i:s|after:now|after_or_equal:start_at",
            "is_all_day" => "required|boolean",
            "target_users" => "required|array|distinct",
            "target_users.*" => "required|integer"
        ];
    }

    /**
     * バリデーションルールのエラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            // 'start_at' => ':attributeは半角数字の整数かFを入力してください。',
            // 'end_at' => ':attributeは半角数字の整数かFを入力してください。',
        ];
    }
}
