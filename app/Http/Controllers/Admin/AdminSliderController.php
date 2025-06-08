<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Pelicula;

class AdminSliderController extends Controller
{
    public function show()
    {
        $sliders = Slider::all();
        $peliculas = Pelicula::all();
        return view('admin.slider', compact('sliders', 'peliculas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idPelicula' => 'required|exists:peliculas,id',
        ]);

        $pelicula = Pelicula::findOrFail($data['idPelicula']);

        Slider::create([
            'idPelicula' => $data['idPelicula'],
            'titulo' => $pelicula->titulo,
        ]);

        return redirect()->route('admin.sliders')->with('success', 'Slider creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $data = $request->validate([
            'idPelicula' => 'required|exists:peliculas,id',
        ]);

        $pelicula = Pelicula::findOrFail($data['idPelicula']);

        $slider->update([
            'idPelicula' => $data['idPelicula'],
            'titulo' => $pelicula->titulo,
        ]);

        return redirect()->route('admin.sliders')->with('success', 'Slider actualizado correctamente.');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();

        return redirect()->route('admin.sliders')->with('success', 'Slider eliminado correctamente.');
    }
}
