<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Dinas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', ['users'=> $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dinas = Dinas::all(); // Mengambil semua data dinas
        $role = Role::all(); // Mengambil semua data role

        $data = [
            'nama' => $request->nama,
            'nip'=> $request->nip,
            'jabatan'=> $request->jabatan,
            'telp'=> $request->telp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dinas_id' => $request['inputDinas'],
            'role_id' => $request['inputRole'],
        ];
        User::create($data);
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
        return view('user.edit', compact('id'));
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
}
