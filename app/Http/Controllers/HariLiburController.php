<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HariLiburController extends Controller
{
    public function index(): View
    {
        $hariLiburs = HariLibur::latest('tanggal')->paginate(10);

        return view('hari_liburs.index', compact('hariLiburs'));
    }

    public function create(): View
    {
        return view('hari_liburs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        HariLibur::create($validated);

        return redirect()->route('hari-liburs.index')->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function edit(HariLibur $hariLibur): View
    {
        return view('hari_liburs.edit', compact('hariLibur'));
    }

    public function update(Request $request, HariLibur $hariLibur): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal,'.$hariLibur->id,
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $hariLibur->update($validated);

        return redirect()->route('hari-liburs.index')->with('success', 'Hari libur berhasil diperbarui.');
    }

    public function destroy(HariLibur $hariLibur): RedirectResponse
    {
        $hariLibur->delete();

        return redirect()->route('hari-liburs.index')->with('success', 'Hari libur berhasil dihapus.');
    }
}
