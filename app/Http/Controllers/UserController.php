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
        $users = User::with(['dinas', 'roles'])->get();
        return view('user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $dinas = Dinas::all(); // Mengambil semua data dinas
        $roles = Role::all(); // Mengambil semua data roles
        return view('user.create', compact('dinas','roles'));
    }

    public function createProcess(Request $request)
    {
        DB::table('users')->insert([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'dinas_id' => $request->dinas_id,
            'jabatan' => $request->jabatan,
            'telp' => $request->telp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);
        return redirect('user')->with('status', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = new User;
        // $user->nama = $request->nama;
        // $user->nip = $request->nip;
        // $user->dinas_id = $request->dinas_id;
        // $user->jabatan = $request->jabatan;
        // $user->telp = $request->telp;
        // $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        // $user->role_id = $request->role_id;
        // $user->save();

        // return redirect('user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::with(['dinas', 'roles'])->get();
        return view('user.show', ['users'=> $users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = DB::table('users')->where('id',$id)->first();
        $dinas = DB::table('dinas')->where('id',$id)->first();
        $roles = DB::table('roles')->where('id',$id)->first();
        return view('user.edit', compact('users','dinas','roles'));
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
