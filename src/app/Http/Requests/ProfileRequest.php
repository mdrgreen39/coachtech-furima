<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'img_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'postcode' => ['nullable', 'string', 'max:8'],
            'address' => ['nullable', 'string', 'max:191'],
            'building' => ['nullable', 'string', 'max:191'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください',
            'name.string' => 'ユーザー名を文字列で入力してください',
            'name.max' => 'ユーザー名を191文字以内で入力してください',
            'image.image' => '添付するファイルは画像ファイルである必要があります',
            'image.mimes' => '画像はjpeg,png,jpg,gifのいずれかの形式である必要があります',
            'image.max' => '画像のサイズは2MB以下である必要があります',
            'postcode.string' => '郵便番号は文字列で入力してください',
            'postcode.max' => '郵便番号は8文字以内で入力してください',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は191文字以内で入力してください',
            'building.string' => '建物名は文字列で入力してください',
            'address.max' => '建物名は191文字以内で入力してください',
        ];
    }
}
