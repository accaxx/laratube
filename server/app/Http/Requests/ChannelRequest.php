<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChannelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'table_id' => 'required|integer|exists:channels,id',
        ];
    }

    public function messages()
    {
        return [
            'table_id.required' => 'チャンネル名を選択してください。',
            'table_id.exists'   => '選択肢から選んでください。',
        ];
    }

    public function getValidatorInstance()
    {
        $data = $this->all();
        $data['table_id'] = (int)$data['table_id'];
        $this->getInputSource()->replace($data);
        return parent::getValidatorInstance();
    }
}
