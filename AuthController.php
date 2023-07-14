<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }
        public function submitLogin(Request $request)
        {
           
            $credentials = $request->validate([
                'email'=>'required|email',
                'password'=>'required'
            ]);
    
        if(Auth::guard('admin')->attempt($credentials)){
            return redirect()->route('content');
        }else{
            return redirect()->back()->with('error','Invalid.');
        }
        }
    
    public function registerationView()
    {
        return view('auth.registeration');
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'email'=>'required|email|unique:admin,email',
            'password'=>'required',
            'name'=>'required'

        ]);
        $admin = new Admin();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->save();

        return back();
    }
    
    public function resetView()
    {
        return view('auth.reset');
    }
    public function updateView()
    {
        return view('auth.update');
        
    }
    public function statusView()
    {
        return view('auth.status');
    }
}
    
