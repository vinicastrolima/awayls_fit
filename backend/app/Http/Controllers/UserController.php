<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'birthdate' => 'required|date',
            'cpf' => 'required|string|unique:users',
            'gender' => 'required|string|in:Male,Female,Other',
            'address' => 'required|string|max:255',
            'admin' => 'sometimes|boolean',
            'password' => 'nullable|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $data = $request->all();
        $data['admin'] = $request->input('admin', false);
    
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }
    
        // Cria o usuário
        $user = User::create($data);
    
        // Se o usuário não for um administrador, cria automaticamente um carrinho para ele
        if (!$user->admin) {
            // Cria um carrinho vazio associado ao usuário recém-criado
            $user->cart()->create();
        }
    
        return response()->json($user, 201);
    }
    

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

}
