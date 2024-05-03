<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class KategoriRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * because in our website, there isn't login verification, we just make this authorize process true. This without role in database, middleware, policy and gate that we usually use in authorization process
         */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (in_array($this->getMethod(), ['PUT', 'PATCH'])) {
            return [
                'kategori_kode' => 'bail|required_without_all:kategori_nama|unique:m_kategori|string|min:4|max:10',
                'kategori_nama' => 'bail|required_without_all:kategori_kode|string|max:100'
            ];
        }

        return [
            'kategori_kode' => 'bail|required|unique:m_kategori,kategori_kode, ' . $this->route('kategori') . ',kategori_id|string|min:4|max:10',
            'kategori_nama' => 'bail|required|string|max:100'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Kategori Validation data failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
