<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class ProductValidator
{
    /**
     * Valida os dados de criação do produto.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateCreate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_type_id' => 'required|exists:product_types,id',
        ]);
    }
    public function validateUpdate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_type_id' => 'required|exists:product_types,id',
        ]);
    }
}
