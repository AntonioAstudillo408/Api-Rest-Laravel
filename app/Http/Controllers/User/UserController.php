<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $campos = $request->all();

        $rules =[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request , $rules);

        $campos['verified'] = User:: USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;



        $usuario = User::create($campos);

        return $this->showOne($usuario , 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->showOne($user , 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $rules =[
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:'.User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
        ];

        $this->validate($request , $rules);


        if($request->has('name'))
        {
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email)
        {
            $user->email = $request->email;
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
        }

        if($request->has('password'))
        {
            $user->password = $request->password;
        }

        if($request->has('admin'))
        {

            if(!$user->esVerificado())
            {
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador' , 409);
            }else{
                $user->admin = $request->admin;
            }

        }


        if(!$user->isDirty())
        {
            return $this->errorResponse('Se debe especificar un valor diferente al menos para actualizar' , 422);

        }

        $user->save();

        return $this->showOne($user , 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user , 200);
    }
}
