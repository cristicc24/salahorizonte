// DASHBOARD (PODRÍAMOS SEPARARLO EN OTRO FICHERO)
document.addEventListener('DOMContentLoaded', () => {
    if(document.getElementById('dashboard')) {
        const ventas = [12, 19, 3, 5, 2, 3];
        const usuarios = [300, 50, 100];

        new Chart(document.getElementById('ventasChart'), {
            type: 'bar',
            data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{label: 'Ventas', data: ventas}],
            },
            options: {responsive: true, scales: {y: {beginAtZero: true}}},
        });

        new Chart(document.getElementById('usuariosChart'), {
            type: 'pie',
            data: {
            labels: ['Activos', 'Inactivos', 'Pendientes'],
            datasets: [{data: usuarios}],
            },
            options: {responsive: true},
        });
    }
});


// PELICULAS

// Eventos DOMContentLoaded para modales y mensajes flash
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('buttonNuevaPelicula').addEventListener('click', () => {
        document.getElementById('modal-create').showModal()
    });

    document.querySelectorAll('button.edit').forEach(button => {
        button.addEventListener('click', (e) => {
            openModal('edit-' + e.currentTarget.dataset.idpelicula);
        });
    });

    document.querySelectorAll('button.delete').forEach(button => {
        button.addEventListener('click', (e) => {
            const modaldelete = document.getElementById('modal-delete-' + e.currentTarget.dataset.idpelicula)
            modaldelete.showModal();
        })
    });

    // Funciones globales para abrir y cerrar modales
    function openModal(id) {
        const modal = document.getElementById('modal-' + id);
        const backdrop = document.getElementById('backdrop-' + id);
        if (modal && backdrop) {
            modal.showModal();
            backdrop.classList.remove('hidden');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById('modal-' + id);
        const backdrop = document.getElementById('backdrop-' + id);
        if (modal && backdrop) {
            modal.close();
            backdrop.classList.add('hidden');
        }
    }

    // Cierre de modales por Escape o clic fuera
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                const id = dialog.id.replace('modal-', '');
                closeModal(id);
            }
        });

        dialog.addEventListener('click', e => {
            const rect = dialog.getBoundingClientRect();
            if (
                e.clientX < rect.left || e.clientX > rect.right ||
                e.clientY < rect.top || e.clientY > rect.bottom
            ) {
                const id = dialog.id.replace('modal-', '');
                closeModal(id);
            }
        });
    });

    // Ocultar mensajes flash tras 5 segundos
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => {
            flash.remove();
        }, 5000);
    }
});


// SESIONES
