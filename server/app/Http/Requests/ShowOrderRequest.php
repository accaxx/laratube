<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\YoutubeController;

class ShowOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dropdown_order' => 'required|in:' . implode(',', array_keys(YoutubeController::ORDER_TYPE)),
        ];
    }

    public function messages()
    {
        return [
            'dropdown_order.required' => '並び順は必ず選択してください。',
            'dropdown_order.in'   => '選択肢から選んでください。',
        ];
    }

}
