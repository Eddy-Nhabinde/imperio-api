<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validating($request)) {
            $user = new User();
            $user->email = $request->email;
            $user->password = password_hash($request->senha, PASSWORD_DEFAULT);
            $user->name = $request->nome;
            $user->contacto = $request->contacto;
            $user->apelido = $request->nome;

            try {
                $user->save();
                return response()->json(['success' => 'Registo feito com sucesso!']);
            } catch (Exception $e) {
                return $e;
            }
        } else {
            return response()->json(['error' => 'Email invalido!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    function validating($request)
    {
        try {
            $request->validate([
                'email' => 'email|max:50|unique:users,email',
            ]);
            return true;
        } catch (\Illuminate\Validation\ValidationException $th) {
            return false;
        }
    }
}
