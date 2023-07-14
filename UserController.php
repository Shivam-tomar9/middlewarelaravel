<?php

namespace App\Http\Controllers;
use App\Models\Register;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crud=Register::get();
        return view('user.index',compact('crud'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $input=$request->all();

        $input = $request->validate([
          'name'=>'required',
          'email'=>'required|email|max:255|unique:user,email',
          'password'=>'required'
        ]);
        // $input=$request->all();
        $input['password']= Hash::make($request->password);
        // unset($input['_token']);
        Register::insert($input);
        return redirect()->route('index')->with('success','Saves');




    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $crud=Register::find($id);
        return view('user.edit',compact('crud'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users,email,' . $id
        ]);
        
        // $input = $request->except('_token');
        // $input['password'] = Hash::make($request->password);
        
        // $crud = Register::find($id);
        // $crud->update($input);

        Register::where('id',$request->id)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        
        return redirect()->route('index')->with('success','Update');
        ;
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $crud=Register::find($id);
        $crud->delete();
        return redirect()->route('index');
    }
}
