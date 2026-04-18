<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventaris::orderBy('nama');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status === 'rendah') {
            $query->whereColumn('stok', '<=', 'stok_minimum');
        }

        $inventaris = $query->paginate(15)->withQueryString();

        return view('inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:inventaris,nama',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Inventaris::create($validated);

        return redirect()->route('inventaris.index')
            ->with('success', 'Item inventaris berhasil ditambahkan.');
    }

    public function edit(Inventaris $inventaris)
    {
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:inventaris,nama,' . $inventaris->id,
            'satuan' => 'required|string|max:50',
            'stok' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $inventaris->update($validated);

        return redirect()->route('inventaris.index')
            ->with('success', 'Item inventaris berhasil diperbarui.');
    }

    public function destroy(Inventaris $inventaris)
    {
        $inventaris->delete();
        return back()->with('success', 'Item inventaris berhasil dihapus.');
    }
}
