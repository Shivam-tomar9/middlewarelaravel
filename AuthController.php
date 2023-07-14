<?php

namespace App\Http\Controllers;
use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function view()
    {
    return view('auth/register');
    }
    
    public function dash()
    {
        return view('admin_layout.dash');
    }
    public function save(Request $request)
    {

        $request->validate([
            'email'=>'required|email|max:255|unique:users,email',
            'password'=>'required',
            'name'=>'required'

        ]);
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        unset($input['_token']);
        User::insert($input);
        return redirect("/login");

    }
    public function login()
    {
        return view('auth.login');
    }

    public function submitLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

    if(Auth::attempt($credentials)){
        return redirect()->route('dash');
    }else{
        return redirect()->back()->with('error','Invalid.');
    }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
