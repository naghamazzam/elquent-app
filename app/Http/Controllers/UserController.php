<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(){
        $users = User::all();
        return response()->json([
            'data' => $users,
            'msg' => 'users returned successfully' ,
            'status' => 200
        ]);
    }
    public function store(Request $request){
        //return $request;

            //variable = class::method(inputdata,[roles],[errore emages]);
        $validate = Validator::make($request->all() ,
        [
            'name' => 'required:users',
            'email' => 'required|email|unique:users',//unique:tableName
            'password' => 'min:8|required:users'
        ],
        [
            'name.required' => 'name is required',
            'email.email' => 'email is contain @'
        ]
        );
            //fails => false | there is an error >>>>>>>>>>>>>>.. fails => true
        if($validate->fails()){
            return Response()->json([
                'errors' => $validate->errors(),
                'status' => 400
            ]);
        }
            //else
        $user = User::create([
            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password)
        ]);
            //token
        //$var=Obj->createToken('token name')->callToken<plainTextToken>;
        $token = $user->createToken('register_token')->plainTextToken;//plainTextToken to work with token as text
        return response()->json([
            'data' => $user,
            'token' => $token,
            'msg' => 'user created successfully' ,
            'status' => 200
        ]);
    }

    public function show($id){
        $user = User::find($id);
        return $user;
    }






    // --------- login -----------
    public function login(Request $request){
        $validate = Validator::make($request->all(),
        [
            'email' => 'required|email:users',
            'password' => 'min:8|required:users'
        ]);

        if($validate->fails()){
            return response()->json([
                'errors' => $validate->errors(),
                'status' => 400
            ]);
        }
        //return $request;-----------------------
            //check email
            $user = User::where('email' , $request->email)->first();
        //return $user;--------------------------
        //check password
        if($user&& Hash::check($request->password , $user->password)){
            $token = $user->createToken('login_token')->plainTextToken;//plainTextToken to work with token as text
                //response is true
            return response()->json([
                'data' => 'go to home page',
                'token' => $token ,
                'msg' => 'login user successfully',
                'status' => 200
            ]);
        }
                //response is false
        return response()->json([
            'msg' => 'login user denied and failed',
            'status' => 403
        ]);
    }

}
