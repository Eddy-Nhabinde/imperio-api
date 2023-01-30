<?php

namespace App\Http\Controllers;

use App\Models\vendas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendasController extends Controller
{
    function novaVenda(Request $request)
    {
        if ($this->validating($request)) {
            try {
                vendas::create([
                    'user_id' => $request->cliente_id,
                    'nomeDoCliente' => $request->nome,
                    'valorPago' => $request->valorPago,
                    'produto_id' => $request->produto_id,
                    'quantidade' => $request->quantidade
                ]);

                $quantidade = DB::table('produtos')
                    ->select('quantidade')
                    ->where('id', $request->produto_id)
                    ->get();

                DB::table('produtos')
                    ->where('id', $request->produto_id)
                    ->update([
                        'quantidade' => $quantidade[0]->quantidade - $request->quantidade
                    ]);

                return response()->json(['success' => 'Venda feita com sucesso!']);
            } catch (Exception $th) {
                return response()->json(['error' => 'Erro inesperado!']);
            }
        } else {
            return response()->json(['warning' => 'Por favor preencha os campos correctamente']);
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
