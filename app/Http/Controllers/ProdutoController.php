<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    function getProdutos(){

    }

    function update(Request $request, $id)
    {
        if ($this->validating($request)) {
            try {
                DB::table('produtos')
                    ->where('id', $id)
                    ->update([
                        'nome' => $request->nome,
                        'quantidade' => $request->quantidade,
                        'peso' => $request->peso,
                        'tipo_id' => $request->tipo_id,
                        'preco' => $request->preco,
                    ]);
                return response()->json([
                    'success' => 'Dados atualizados com sucesso'
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'Ocorreu um erro na atualizacao!'
                ]);
            }
        } else {
            return response()->json([
                'warning' => 'Preencha os dados correctamente!!'
            ]);
        }
    }

    function updatePicture(Request $request, $id)
    {
        $newphpto = $request->file('foto');
        if ($newphpto) {
            $foto = DB::table('produtos')
                ->select('foto')
                ->where('id', $id)
                ->get();

            if ($foto[0]->foto) {
                $name = time() . '.' . $newphpto->getClientOriginalExtension();
                $newphpto->move('fotos/', $name);
                unlink("fotos/" . $foto[0]->foto);
                try {
                    DB::table('produtos')
                        ->where('id', $id)
                        ->update([
                            'foto' => $name,
                        ]);
                    return response()->json([
                        'success' => 'Foto atualizada com sucesso'
                    ]);
                } catch (Exception $th) {
                    return response()->json([
                        'error' => 'Ocorreu um erro na atualizacao!'
                    ]);
                }
            }
        } else {
            return response()->json([
                'warning' => 'Por favor selecione uma foto valida'
            ]);
        }
    }

    function validating($request)
    {
        try {
            $request->validate([
                'nome' => '|required|string|max:50|unique:produtos,nome',
                'tipo_id' => 'required',
                'foto' => 'exclude_if:operation,update|required',
                'preco' => 'required',
                'quantidade' => 'required'
            ]);
            return true;
        } catch (\Illuminate\Validation\ValidationException $th) {
            return false;
        }
    }
}
