@extends('layouts.admin')

@section('contenido')
    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    <div id="dashboard" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Gráfico 1: Barras -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Ventas mensuales</h3>
            <canvas id="ventasChart" class="max-h-64"></canvas>
        </div>

        <!-- Gráfico 2: Pastel -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Distribución de usuarios</h3>
            <canvas id="usuariosChart" class="max-h-64"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Cargar Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
