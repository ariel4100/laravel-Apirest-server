<?php

namespace App\Http\Controllers\Api;

use App\Model\Profile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     */
    private $jwtAuth;

    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function register(Request $request)
    {
        //validate
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'gender' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        //create db
        $user = new User();
        $user->fullname = $request->name;
        $user->fullsurname = $request->surname;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->slug = str_slug($request->name.' '.$request->surname,'-');
        $user->save();

        Profile::create(['user_id' => $user->id]);
        //response
        return ["message"=>"User Created","user"=>$user];
    }

    public function login(Request $request)
    {

        //validate
        //$credentials = $request->only('email','password');
        $credentials = $this->validate($request,[
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['status'=> 'no autenticado'], 401);

            }
        }catch(JWTExceptions $err){
            return response()->json(['status'=> 'failed to login'], 500);
        }
        $user = JWTAuth::authenticate($token);
        return response()->json(compact('token', 'user'));

    }

    public function logout(Request $request)
    {
        //
    }

}
