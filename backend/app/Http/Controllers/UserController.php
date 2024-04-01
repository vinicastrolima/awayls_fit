<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {

        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users',
        //     'birthdate' => 'required|date',
        //     'cpf' => 'required|string|unique:users',
        //     'gender' => 'required|string|in:Male,Female,Other',
        //     'address' => 'required|string|max:255',
        //     'admin' => 'sometimes|boolean',
        //     'password' => 'nullable|string|min:6',
        // ]);
    
        $validatedData = $request->all();

        // Definindo um valor padrão para 'admin' se não estiver presente na requisição
        $validatedData['admin'] = $request->input('admin', false);
    
        // Se a senha foi fornecida na requisição, ela será criptografada antes de ser armazenada no banco de dados
        if ($request->has('password')) {
            $validatedData['password'] = bcrypt($request->input('password'));
        }
    
        // dd('Chegou aqui 3');

        $user = User::create($validatedData);
    
        return response()->json($user, 201);
    }
    

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // Adicione as validações para os outros campos conforme necessário
        ]);

        $user->update($validatedData);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
