<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\YoutubeController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\ViewErrorBag;

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
            'dropdown_order'    => 'required|in:' . implode(',', array_keys(YoutubeController::ORDER_TYPE)),
            'display_columns'   => 'required|array',
            'display_columns.*' => 'in:' . implode(',', array_keys(YoutubeController::DISPLAY_OPTION_COLUMN)),
            'display_values'    => 'nullable',
            'display_values.*'  => 'in:' . implode(',', array_keys(YoutubeController::DISPLAY_OPTION_VALUE)),
            'page_token'        => 'nullable|max:10',
        ];
    }

    public function messages()
    {
        return [
            'dropdown_order.required'  => '並び順は必ず選択してください。',
            'dropdown_order.in'        => '並び順は選択肢から選んでください。',
            'display_columns.required' => '表示する項目は最低一つ選択してください。',
            'display_columns.*.in'     => '表示する項目は選択肢の中から選んでください。',
            'display_values.*.in'      => '表示する値は選択肢の中から選んでください。',
            'page_token.max'           => 'ページトークンでエラーが生じています。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = new ViewErrorBag();
        $errors->put('default', $validator->errors());
        $this->session()->flash('errors', $errors);
        throw new HttpResponseException(
            redirect()->back()->with(['display_option' => $this->session()->get('display_option')])
        );
    }

}
