<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class UpdatePenjualanDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->request->replace($this->only([
            'detail_id',
            'barang_id',
            'jumlah'
        ]));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        foreach ($this->input('barang_id') as $index => $barang_id) {
            $rules['barang_id.' . $index] = 'bail|required|integer|exists:m_barang,barang_id';
            $rules['detail_id.' . $index] = 'bail|required|integer|exists:t_penjualan_detail,detail_id';
            $rules['jumlah.' . $index] = [
                'bail',
                'required',
                'integer',
                function ($attribute, $value) use ($barang_id, $index) {
                    $stok_jumlah = DB::table('t_stok')
                        ->where('barang_id', $barang_id)
                        ->value('stok_jumlah');
                    $previousStok = DB::table('t_penjualan_detail')
                        ->where('detail_id', $this->input('detail_id.' . $index))
                        ->value('jumlah');
                    $previousBarangId = DB::table('t_penjualan_detail')
                        ->where('detail_id', $this->input('detail_id.' . $index))
                        ->value('barang_id');
                    $currentStok = DB::table('t_stok')
                        ->where('barang_id', $previousBarangId)
                        ->value('stok_jumlah');

                    if (strval($previousBarangId) === $barang_id) {
                        if (($stok_jumlah + $previousStok) < $value) {
                            throw new HttpResponseException(response()->json([
                                'success' => false,
                                'message' => 'Penjualan Detail Validation data failed',
                                'errors' => $attribute . ' index must be less than or equal to stok_jumlah = ' . ($stok_jumlah + $previousStok) . ' in t_stok',
                            ], 422));
                        }
                        DB::table('t_stok')
                            ->where('barang_id', $barang_id)
                            ->update(['stok_jumlah' => ($previousStok + $currentStok)]);
                    } else {
                        if ($value > $stok_jumlah) {
                            throw new HttpResponseException(response()->json([
                                'success' => false,
                                'message' => 'Penjualan Detail Validation data failed',
                                'errors' => $attribute . ' index must be less than or equal to stok_jumlah = ' . $stok_jumlah . ' in t_stok',
                            ], 422));
                        }
                        DB::table('t_stok')
                            ->where('barang_id', $previousBarangId)
                            ->update(['stok_jumlah' => ($previousStok + $currentStok)]);
                    }

                    $this->merge([
                        'harga' . $index => DB::table('m_barang')
                            ->where('barang_id', '=', $barang_id)
                            ->value('harga_jual'),
                    ]);
                },
            ];
        }

        return $rules;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Penjualan Detail Validation data failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
