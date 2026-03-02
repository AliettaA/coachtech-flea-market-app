<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string', 'max:1000'],
            'price'        => ['required', 'integer', 'min:1'],
            'category_id'  => ['required', 'exists:categories,id'],
            'condition_id' => ['required', 'exists:conditions,id'],
            'image'        => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => '商品名を入力してください',
            'description.required'  => '商品説明を入力してください',
            'price.required'        => '価格を入力してください',
            'price.integer'         => '価格は数値で入力してください',
            'price.min'             => '価格は1円以上で入力してください',
            'category_id.required'  => 'カテゴリを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'image.required'        => '画像をアップロードしてください',
            'image.image'           => '画像ファイルをアップロードしてください',
            'image.mimes'           => 'jpeg,png形式の画像をアップロードしてください',
            'image.max'             => '画像サイズは2MB以内にしてください',
        ];
    }
}
