<?php

namespace App\Http\Controllers;

use App\Models\LogoSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogoController extends Controller
{
    public function index(): View
    {
        $logos = LogoSetting::latest()->paginate(10);

        return view('logos.index', compact('logos'));
    }

    public function create(): View
    {
        return view('logos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $file = $request->file('image');
        $imageData = file_get_contents($file->getRealPath());

        LogoSetting::create([
            'name' => $validated['name'],
            'mime' => $file->getClientMimeType(),
            'image' => $imageData,
        ]);

        return redirect()->route('logos.index')->with('success', 'Logo berhasil ditambahkan.');
    }

    public function edit(LogoSetting $logo): View
    {
        return view('logos.edit', compact('logo'));
    }

    public function update(Request $request, LogoSetting $logo): RedirectResponse
    {
        $rules = [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ];

        $validated = $request->validate($rules);

        $data = ['name' => $validated['name']];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['mime'] = $file->getClientMimeType();
            $data['image'] = file_get_contents($file->getRealPath());
        }

        $logo->update($data);

        return redirect()->route('logos.index')->with('success', 'Logo berhasil diperbarui.');
    }

    public function destroy(LogoSetting $logo): RedirectResponse
    {
        $logo->delete();

        return redirect()->route('logos.index')->with('success', 'Logo berhasil dihapus.');
    }

    public function show(LogoSetting $logo)
    {
        if (! $logo->image) {
            abort(404);
        }

        return response($logo->image)
            ->header('Content-Type', $logo->mime ?: 'image/png');
    }

    public function apiKopSurat(Request $request)
    {
        $name = $request->query('name', 'kop_smk');
        $logo = LogoSetting::where('name', $name)->first()
            ?? LogoSetting::latest()->first();

        if (! $logo || ! $logo->image) {
            return response()->json([
                'success' => false,
                'message' => 'Logo tidak ditemukan',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'base64' => base64_encode($logo->image),
                'mime' => $logo->mime ?: 'image/png',
            ],
        ]);
    }
}
