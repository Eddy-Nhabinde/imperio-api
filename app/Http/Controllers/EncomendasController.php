<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncomendasController extends Controller
{
    function novaEncomenda(Request $request)
    {
        if ($this->validating($request)) {
        }
    }

    function validating($request)
    {
        try {
            $request->validate([
                'cliente_id' => 'required_if:nome,null',
                'nome' => 'required_if:id,null|string|max:50|unique:produtos,nome',
                'valorPago' => 'required',
                'quantidade' => 'required',
                'valorPago' => 'required'
            ]);
            return true;
        } catch (\Illuminate\Validation\ValidationException $th) {
            return false;
        }
    }
}
