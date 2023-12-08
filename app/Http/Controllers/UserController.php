<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Dinas;
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
        // $activeUsers = User::where('status', true)->get();
        // $users = User::withTrashed()->get();
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

    public function store(Request $request)
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
            'created_at' => now(),
        ]);
        return redirect('user')->with('status', 'Data Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        // $users = User::with(['dinas', 'roles'])->get();
        $user = User::findOrFail($id);
        $dinas = Dinas::find($request->input('dinas_id'));
        $roles = Role::find($request->input('role_id'));

        return view('user.show', compact('user','dinas','roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $dinas = Dinas::all();
        $roles = Role::all();

        return view('user.edit', compact('user','dinas','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::table('users')->where('id',$id)
            ->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'dinas_id' => $request->dinas_id,
                'jabatan' => $request->jabatan,
                'telp' => $request->telp,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'updated_at' => now(),
        ]);

        return redirect('user')->with('status', 'Data Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // DB::table('users')->where('id',$id)->delete();
        $user = User::find($id);
        $user->delete(); // Soft delete user
        $user->status = false; // Set status user menjadi nonaktif
        $user->save();
        return redirect('user')->with('status', 'Data Pengguna berhasil dihapus!');
    }
}
