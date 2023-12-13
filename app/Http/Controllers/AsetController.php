<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Dinas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asets = Aset::with(['dinas', 'kategoris'])->paginate(5);
        return view('aset.index', compact('asets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dinas = Dinas::all(); // Mengambil semua data dinas
        $kategoris = Kategori::all(); // Mengambil semua data kategori
        $status_asets = Aset::select('status_aset')->distinct()->get();
        return view('aset.create', compact('dinas','kategoris','status_asets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('asets')->insert([
            'nama_aset' => $request->nama_aset,
            'kategori_id' => $request->kategori_id,
            'dinas_id' => $request->dinas_id,
            'detail' => $request->detail,
            'status_aset' => $request->status_aset,
            'created_at' => now(),
        ]);
        return redirect('aset')->with('status', 'Data Aset berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $aset = Aset::findOrFail($id);
        $dinas = Dinas::find($request->input('dinas_id'));
        $kategoris = Kategori::find($request->input('kategori_id'));

        return view('aset.show', compact('aset','dinas','kategoris'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $aset = Aset::findOrFail($id);
        $dinas = Dinas::all();
        $kategoris = Kategori::all();

        return view('aset.edit', compact('aset','dinas','kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::table('asets')->where('id',$id)
            ->update([
                'nama_aset' => $request->nama_aset,
                'kategori_id' => $request->kategori_id,
                'dinas_id' => $request->dinas_id,
                'detail' => $request->detail,
                'status_aset' => $request->status_aset,
                'updated_at' => now(),
            ]);
        return redirect('aset')->with('status', 'Data Aset berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aset = Aset::find($id);
        $aset->delete();
        return redirect('aset')->with('status', 'Data Aset berhasil dihapus!');
    }
}
