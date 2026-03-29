<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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

    public function rules()
    {
        return [
            'postcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'postcode.required' => '郵便番号は必須です',
            'postcode.regex' => '郵便番号はXXX-XXXX形式で入力してください',
            'address.required' => '住所は必須です',
        ];
    }

}
