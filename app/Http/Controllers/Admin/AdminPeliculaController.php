<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Slider;

class AdminPeliculaController extends Controller
{

    public function index(Request $request)
    {
        $query = Pelicula::query();

        // Filtro por título
        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        // Filtro por género
        if ($request->filled('genero')) {
            $query->where('genero', 'like', '%' . $request->genero . '%');
        }

        // Filtro por año
        if ($request->filled('anio_estreno')) {
            $query->whereYear('fecha_estreno', $request->anio_estreno);
        }

        // Listado de géneros y años
        $generos = Pelicula::select('genero')->distinct()->pluck('genero')->flatMap(function($g){
            return array_map('trim', explode(',', $g));
        })->unique()->sort()->values();

        
        $anios = Pelicula::pluck('fecha_estreno')
            ->map(fn($fecha) => \Carbon\Carbon::parse($fecha)->year)
            ->unique()
            ->sort()
            ->values();

        $peliculas = $query->paginate(15)->withQueryString();
    
        return view('admin.peliculas', compact('peliculas', 'generos', 'anios'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:255', 'regex:/^[\pL0-9\s\-\:\,\.\'"]+$/u'],
            'precio' => ['required', 'numeric', 'min:0', 'max:999.99'],
            'genero' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\,\-]+$/u'],
            'directores' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\,\-]+$/u'],
            'edad_recomendada' => ['required', 'string', 'max:20', 'regex:/^[\pL0-9\+\s]+$/u'],
            'duracion' => ['required', 'string', 'max:20', 'regex:/^(\d+h\s\d+m|\d{1,3})$/'],
            'fecha_estreno' => ['required', 'date'],
            'fecha_emision' => ['required', 'date', 'after_or_equal:fecha_estreno'],
            'sinopsis' => ['required', 'string', 'min:10'],
            'actores' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\,\-]+$/u'],
            'enlace_trailer' => ['nullable', 'url', 'max:255'],
            'foto_miniatura' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,webp'],
            'foto_grande' => ['nullable', 'image', 'max:4096', 'mimes:jpg,jpeg,png,webp'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.peliculas')
                ->with('createError', $validator->errors()->first())
                ->with('openModal', 'create')
                ->withInput();
        }

        $data = $request->except('foto_miniatura', 'foto_grande');
        $data['duracion'] = $this->formatearDuracion($request->duracion);
        $data['activo'] = false;

        $pelicula = new Pelicula($data);
        $pelicula->save();

        $slug = Str::slug($pelicula->titulo, '');

        if ($request->hasFile('foto_miniatura')) {
            $ext = $request->file('foto_miniatura')->getClientOriginalExtension();
            $filename = "miniatura.{$ext}";
            $path = $request->file('foto_miniatura')->storeAs("images/films/{$pelicula->id}-{$slug}", $filename, 'public');
            $pelicula->foto_miniatura = 'storage/' . $path;
        }

        if ($request->hasFile('foto_grande')) {
            $ext = $request->file('foto_grande')->getClientOriginalExtension();
            $filename = "fotogrande.{$ext}";
            $path = $request->file('foto_grande')->storeAs("images/films/{$pelicula->id}-{$slug}", $filename, 'public');
            $pelicula->foto_grande = 'storage/' . $path;
        }

        $pelicula->save();

        return redirect()->route('admin.peliculas')->with('success', 'Película agregada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:255', 'regex:/^[\pL0-9\s\-\:\,\.\'"]+$/u'],
            'precio' => ['required', 'numeric', 'min:0', 'max:999.99'],
            'genero' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\,\-]+$/u'],
            'directores' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\,\-]+$/u'],
            'edad_recomendada' => ['required', 'string', 'max:20', 'regex:/^[\pL0-9\+\s]+$/u'],
            'duracion' => ['required', 'number', 'max:20', 'regex:/^(\d+h\s\d+m|\d{1,3})$/'],
            'fecha_estreno' => ['required', 'date'],
            'fecha_emision' => ['required', 'date', 'after_or_equal:fecha_estreno'],
            'sinopsis' => ['required', 'string', 'min:10'],
            'actores' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\,\-]+$/u'],
            'enlace_trailer' => ['nullable', 'url', 'max:255'],
            'foto_miniatura' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,webp'],
            'foto_grande' => ['nullable', 'image', 'max:4096', 'mimes:jpg,jpeg,png,webp'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.peliculas')
                ->with('editError', $validator->errors()->first())
                ->with('openModal', 'edit-' . $id)
                ->withInput();
        }

        $data = $request->except('foto_miniatura', 'foto_grande');
        $data['duracion'] = $this->formatearDuracion($request->duracion);

        $pelicula->fill($data);

        if ($request->hasFile('foto_miniatura')) {
            if ($pelicula->foto_miniatura) {
                Storage::disk('public')->delete($pelicula->foto_miniatura);
            }
            $pelicula->foto_miniatura = $request->file('foto_miniatura')->store('peliculas/miniaturas', 'public');
        }

        if ($request->hasFile('foto_grande')) {
            if ($pelicula->foto_grande) {
                Storage::disk('public')->delete($pelicula->foto_grande);
            }
            $pelicula->foto_grande = $request->file('foto_grande')->store('peliculas/grandes', 'public');
        }

        $pelicula->save();

        return redirect()->route('admin.peliculas')->with('success', 'Película actualizada correctamente.');
    }

    public function toggleActivo($id)
    {
        $pelicula = Pelicula::find($id);
        $pelicula->activo = !$pelicula->activo;
        $pelicula->save();

        return response()->json(['success' => true, 'activo' => $pelicula->activo]);
    }

    public function destroy($id)
    {
        $pelicula = Pelicula::findOrFail($id);
        Slider::where('idPelicula', $pelicula->id)->delete();

        if ($pelicula->foto_miniatura) {
            Storage::disk('public')->delete($pelicula->foto_miniatura);
        }

        if ($pelicula->foto_grande) {
            Storage::disk('public')->delete($pelicula->foto_grande);
        }

        $pelicula->delete();

        return redirect()->route('admin.peliculas')->with('success', 'Película eliminada correctamente.');
    }

  
    // Convierte minutos en "xh yym", o deja el texto si ya está formateado.
     
    private function formatearDuracion($valor)
    {
        $valor = trim($valor);
        if (is_numeric($valor)) {
            $horas = floor($valor / 60);
            $min = $valor % 60;
            return "{$horas}h {$min}m";
        }

        return $valor;
    }


}
