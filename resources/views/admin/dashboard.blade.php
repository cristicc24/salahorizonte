@extends('layouts.admin')

@section('contenido')
    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Gráfico 1: Barras -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Ventas mensuales</h3>
            <canvas id="ventasChart"></canvas>
        </div>

        <!-- Gráfico 2: Pastel -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Distribución de usuarios</h3>
            <canvas id="usuariosChart"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Cargar Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Gráfico de barras: Ventas mensuales (datos de ejemplo)
        const ctxVentas = document.getElementById('ventasChart').getContext('2d');
        const ventasChart = new Chart(ctxVentas, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                datasets: [{
                    label: 'Ventas',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Gráfico de pastel: Distribución de usuarios (datos de ejemplo)
        const ctxUsuarios = document.getElementById('usuariosChart').getContext('2d');
        const usuariosChart = new Chart(ctxUsuarios, {
            type: 'pie',
            data: {
                labels: ['Usuarios Activos', 'Usuarios Inactivos', 'Usuarios Pendientes'],
                datasets: [{
                    label: 'Usuarios',
                    data: [300, 50, 100],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)'
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
            }
        });
    </script>
@endsection
