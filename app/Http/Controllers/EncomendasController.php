<?php

namespace App\Http\Controllers;

use App\Models\Encomendas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncomendasController extends Controller
{
    function novaEncomenda(Request $request)
    {
        if ($this->validating($request)) {
            try {
                Encomendas::create([
                    'user_id' => $request->user_id,
                    'valor_pago' => $request->valor_pago,
                    'produto_id' => $request->produto_id,
                    'quantidade' => $request->quantidade
                ]);
                $mail = new MailController();
                if ($mail->encomendas($this->prepareMailInfo($request->user_id, $request->produto_id))) {
                    return response()->json(['success' => 'Encomenda feita com sucesso!']);
                }
            } catch (Exception $th) {
                dd($th);
                return response()->json(['error' => 'Erro inesperado!']);
            }
        } else {
            return response()->json(['warning' => 'Por favor preencha os campos correctamente']);
        }
    }

    function prepareMailInfo($user_id, $prod_id)
    {
        try {
            $users = DB::table('users')
                ->select('name', 'apelido', 'email', 'acesso')
                ->where('id', $user_id)
                ->orWhere('acesso', 'admin')
                ->get();

            $prods = DB::table('produtos')
                ->select('nome')
                ->where('id', $prod_id)
                ->get();

            return ['users' => $users, 'prod' => $prods[0]->nome];
        } catch (Exception $th) {
            dd($th);
        }
    }

    function validating($request)
    {
        try {
            $request->validate([
                'user_id' => 'required_if:nome,null',
                'valor_pago' => 'required',
                'produto_id' => 'required',
                'quantidade' => 'required',
            ]);
            return true;
        } catch (\Illuminate\Validation\ValidationException $th) {
            return false;
        }
    }
}
