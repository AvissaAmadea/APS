<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::paginate(5);
        return view('kategori.index')->with('kategoris',$kategoris);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('kategoris')->insert([
            'jenis' => $request->jenis,
            'created_at' => now(),
        ]);
        return redirect('kategori')->with('status', 'Data Jenis Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        // $kategoris = Kategori::findOrFail($id);
        // return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::table('kategoris')->where('id',$id)
            ->update([
                'jenis' => $request->jenis,
                'updated_at' => now(),
        ]);
        return redirect('kategori')->with('status', 'Data Jenis Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategoris = Kategori::find($id);
        $kategoris->delete();
        return redirect('kategori')->with('status', 'Data Jenis Kategori berhasil dihapus!');
    }
}
