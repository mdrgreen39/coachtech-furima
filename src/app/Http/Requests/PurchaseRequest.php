<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'payment_method' => ['required', 'in:コンビニ,銀行振込,クレジットカード'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = auth()->user();

            // 配送先住所が登録されているか確認
            if (!$user || !$user->profile || empty($user->profile->address)) {
                $validator->errors()->add('address', '配送先が登録されていません');
            }

            // 郵便番号が登録されているか確認
            if (!$user || !$user->profile || empty($user->profile->postcode)) {
                $validator->errors()->add('postcode', '郵便番号が登録されていません');
            } elseif (!preg_match('/^\d{3}-\d{4}$/', $user->profile->postcode)) {
                $validator->errors()->add('postcode', '郵便番号は「123-4567」の形式で入力してください');
            }

            if (empty($user->name)) {
                $validator->errors()->add('name', '名前を登録してください');
            }
        });
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            'payment_method.in' => '無効な支払い方法が選択されています',
            'address.required' => '配送先を登録してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex' => '郵便番号は「123-4567」の形式で入力してください',
            'name.required' => '名前を登録してください',
        ];
    }
}
