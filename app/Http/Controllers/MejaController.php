<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::orderBy('nama')->get();
        return view('meja.index', compact('mejas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Meja::create([
            'nama' => $request->nama,
            'kode' => strtoupper(Str::random(6)),
            'is_aktif' => true,
        ]);

        return redirect()->route('meja.index')->with('success', 'Lokasi/Meja berhasil ditambahkan.');
    }

    public function update(Request $request, Meja $meja)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'is_aktif' => 'required|boolean',
        ]);

        $meja->update($request->only('nama', 'is_aktif'));

        return redirect()->back()->with('success', 'Lokasi/Meja berhasil diperbarui.');
    }

    public function destroy(Meja $meja)
    {
        $meja->delete();
        return redirect()->back()->with('success', 'Lokasi/Meja berhasil dihapus.');
    }
}
