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
        $target_users = [];
        $old_target_users = [];
        $target_offices = [];
        $old_target_offices = [];

        if( $this->target_users != null )
            $target_users = explode(',', $this->target_users);
        if( $this->old_target_users != null )
            $old_target_users = explode(',', $this->old_target_users);
        if( $this->target_offices != null )
            $target_offices = explode(',', $this->target_offices);
        if( $this->old_target_offices != null )
            $old_target_offices = explode(',', $this->old_target_offices);
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
            'target_offices' => $target_offices,
            'old_target_offices' => $old_target_offices,
            'start_at' => $start_at,
            'end_at' => $end_at,
        ]);
        logger($this);
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
            "target_users" => "array|distinct",
            "target_users.*" => "integer",
            "target_offices" => "array|distinct",
            "target_offices.*" => "integer"
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
