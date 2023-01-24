<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Exception;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    function SaveProduct(Request $request)
    {
        if ($this->validating($request)) {
            $foto = $request->file('foto');

            $name = time() . '.' . $foto->getClientOriginalExtension();

            $foto->move('fotos/', $name);

            $prod = new Produto();

            $prod->nome = $request->nome;
            $prod->preco = $request->preco;
            $prod->foto = $name;
            $prod->peso = $request->peso;
            $prod->quantidade = $request->quantidade;
            $prod->tipo_id = $request->tipo_id;

            try {
                $prod->save();
                return response()->json([
                    'success' => 'Produto registado com sucesso'
                ]);
            } catch (Exception $e) {
                dd($e);
                return response()->json([
                    'error' => 'erro inesperado'
                ]);
            }
        } else {
            return response()->json([
                'warning' => 'Preencha os dados correctamente!!'
            ]);
        }
    }

    function validating($request)
    {
        try {
            $request->validate([
                'nome' => '|required|string|max:50|unique:produtos,nome',
                'tipo_id' => 'required',
                'foto' => 'required',
                'preco' => 'required',
                'quantidade' => 'required'
            ]);
            return true;
        } catch (\Illuminate\Validation\ValidationException $th) {
            return false;
        }
    }
}
