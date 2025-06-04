<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPeliculaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'duracion' => 'required|integer|min:1',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $pelicula = new Pelicula($request->only('titulo', 'genero', 'duracion'));

        if ($request->hasFile('imagen')) {
            $pelicula->imagen = $request->file('imagen')->store('peliculas', 'public');
        }

        $pelicula->save();

        return redirect()->route('admin.peliculas')->with('success', 'Película agregada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'duracion' => 'required|integer|min:1',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $pelicula->fill($request->only('titulo', 'genero', 'duracion'));

        if ($request->hasFile('imagen')) {
            if ($pelicula->imagen) {
                Storage::disk('public')->delete($pelicula->imagen);
            }
            $pelicula->imagen = $request->file('imagen')->store('peliculas', 'public');
        }

        $pelicula->save();

        return redirect()->route('admin.peliculas')->with('success', 'Película actualizada.');
    }

    public function destroy($id)
    {
        $pelicula = Pelicula::findOrFail($id);

        if ($pelicula->imagen) {
            Storage::disk('public')->delete($pelicula->imagen);
        }

        $pelicula->delete();

        return redirect()->route('admin.peliculas')->with('success', 'Película eliminada.');
    }
}
