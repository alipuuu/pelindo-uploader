<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserrModel;
use Illuminate\Support\Facades\Hash;

class UserrController extends Controller
{
     public function __construct()
    {
        $this->UserrModel = new UserrModel();
        $this->middleware('auth');
    }

    public function index()
    {
        $userr = UserrModel::all();
        return view('v_userr', compact('userr'));
    }

    public function add_userr()
    {
        $userr = UserrModel::all();
        return view('v_userr', compact('userr'));
    }

    public function insert(Request $request)
    {
        $userr = UserrModel::find($request->id);
        Request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:5|required_with:password_confirmation|same:password_confirmation',
        ],[
            'name.required'=>' name wajib diisi !!',
            'email.required'=>' email wajib diisi !!',
            'password.required' => 'password wajib diisi !!',
        ]);

        $userr = [
            'name' => Request()->name,
            'email' => Request()->email,
            'password' => Hash::make($request->password)
        ];
        $this->UserrModel->addData($userr);
        return redirect()->route('userr')->with('pesan', 'Data berhasil ditambahkan!');
    }

    public function edit(Request $request)
    {
        $userr = UserrModel::find($request->id);
        // dd($request->all());
        $userr->update($request->all());
        return redirect()->route('userr')->with('pesan', 'Data berhasil diupdate!');
    }

    public function delete($id)
    {
        $userr = UserrModel::find($id);
        $userr->delete();
        return redirect()->route('userr');
    }

}



