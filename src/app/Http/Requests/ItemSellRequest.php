<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemSellRequest extends FormRequest
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
            'price' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'categories' => ['required', 'array', 'min:1', 'max:2'],
            'categories.*' => ['exists:categories,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'name.string' => '商品名を文字列で入力してください',
            'name.max' => '商品名を191文字以内で入力してください',
            'price.required' => '価格は必須項目です',
            'price.integer' => '価格は整数で入力してください',
            'price.min' => '価格は1以上の整数でなければなりません',
            'description.required' => '説明は必須項目です',
            'description.string' => '説明は文字列として入力してください',
            'image.required' => '画像を選択してください',
            'image.image' => '添付するファイルは画像ファイルである必要があります',
            'image.mimes' => '画像はjpeg,png,jpg,gifのいずれかの形式である必要があります',
            'image.max' => '画像のサイズは2MB以下である必要があります',
            'image.uploaded' => '画像のアップロードに失敗しました。ファイルサイズが大きすぎる可能性があります',
            'categories.required' => 'カテゴリーを1つ以上選択してください',
            'categories.min' => 'カテゴリーは1つ以上選択してください',
            'categories.max' => 'カテゴリーは最大2つまで選択できます',
            'categories.*.exists' => '選択されたカテゴリーが存在しません',
        ];
    }
}
