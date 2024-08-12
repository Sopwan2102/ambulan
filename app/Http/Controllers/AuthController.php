<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
    public function postRegister(Request $request)
    {
        $data = new User;
        
        $data->name = $request->name;
        $data->username = $request->username;
        $data->password = Hash::make($request->input('password'));
        $data->no_hp = $request->no_hp;
        $data->role = 'driver';

        $post = $data->save();

        return redirect()->route('auth.login')->with('success','Berhasil Melakukan Pendaftaran');

    }
    public function postlogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
                if (Auth::user()->role == 'admin' || Auth::user()->role == 'driver') {
                    return redirect('/dashboard');
                } else {
                    return redirect()->route('auth.login')->with('error', 'username atau password salah!');
                }
        }
        return redirect()->route('auth.login')->with('error', 'username atau password salah!');
    }
}
