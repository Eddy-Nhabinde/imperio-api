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

                DB::table('produtos')
                    ->where('id', $request->produto_id)
                    ->update([
                        'quantidade' => $this->getQuantidadeProduto($request->produto_id)  - $request->quantidade
                    ]);

                return response()->json(['success' => 'Venda feita com sucesso!']);
            } catch (Exception $th) {
                return response()->json(['error' => 'Erro inesperado!']);
            }
        } else {
            return response()->json(['warning' => 'Por favor preencha os campos correctamente']);
        }
    }

    function cancelarVenda(Request $request)
    {
        try {
            DB::table('vendas')
                ->where('id', $request->id)
                ->update([
                    'estado' => 'cancelada'
                ]);

            DB::table('produtos')
                ->where('id', $request->produto_id)
                ->update([
                    'quantidade' => $this->getQuantidadeProduto($request->produto_id) + $request->quantidade
                ]);

            return response()->json(['success' => 'Venda cancelada com sucesso!']);
        } catch (Exception $th) {
            dd($th);
        }
    }

    function getQuantidadeProduto($id)
    {
        try {
            $quantidade = DB::table('produtos')
                ->select('quantidade')
                ->where('id', $id)
                ->get();

            return $quantidade[0]->quantidade;
        } catch (Exception $th) {
            dd($th);
        }
    }

    function getVendas(Request $request)
    {
        try {
            $vendas = DB::table('vendas')
                ->join('produtos', 'produtos.id', '=', 'vendas.produto_id')
                ->join('tipos', 'tipos.id', '=', 'produtos.tipo_id')
                ->select('vendas.*', 'tipos.nome as tipo', 'produtos.foto')
                ->when($request, function ($query, $request) {
                    if (isset($request->estado)) {
                        return $query->where('estado',  $request->estado);
                    }
                })
                ->when($request, function ($query, $request) {
                    if (isset($request->dataInicial) && isset($request->dataFinal)) {
                        return $query->whereBetween('vendas.created_at', [$request->dataInicial . ' 00:00:00', $request->dataFinal . ' 23:59:59']);
                    } else if (isset($request->dataInicial)) {
                        return $query->where('vendas.created_at', '>=', $request->dataInicial . ' 00:00:00');
                    } else if (isset($request->dataFinal)) {
                        return $query->where('vendas.created_at', '<=', $request->dataFinal . ' 23:59:59');
                    }
                })
                ->get();
            return $vendas;
        } catch (Exception $th) {
            dd($th);
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
