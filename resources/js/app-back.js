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
    // Abrir modal de creación
    document.getElementById('buttonNuevaPelicula')?.addEventListener('click', () => {
        document.getElementById('modal-create')?.showModal();
    });

    // Botones de edición
    document.querySelectorAll('button.edit').forEach(button => {
        button.addEventListener('click', e => {
            openModal('edit-' + e.currentTarget.dataset.idpelicula);
        });
    });

    // Botones de eliminación
    document.querySelectorAll('button.delete').forEach(button => {
        button.addEventListener('click', e => {
            const modal = document.getElementById('modal-delete-' + e.currentTarget.dataset.idpelicula);
            modal?.showModal();
        });
    });

    // Botones y elementos que cierran modales usando data-close-modal
    document.querySelectorAll('[data-close-modal]').forEach(element => {
        element.addEventListener('click', () => {
            const id = element.getAttribute('data-close-modal');
            closeModal(id);
        });
    });

    // Funciones globales
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

    // Cierre de modales por tecla Escape o clic fuera del cuadro
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

    // Ocultar mensajes flash automáticamente
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => flash.remove(), 5000);
    }


    // Reset de filtros
    const resetBtn = document.getElementById('resetFiltros');
    const form = resetBtn?.closest('form');

    if (resetBtn && form) {
        resetBtn.addEventListener('click', (e) => {
            e.preventDefault();
            form.querySelectorAll('input, select').forEach(el => {
                if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } else {
                    el.value = '';
                }
            });
            form.submit();
        });
    }
});

// SALAS

document.addEventListener('DOMContentLoaded', () => {

    // Abrir modales
    document.querySelectorAll('[data-open-modal]').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-open-modal');
            const modal = document.getElementById('modal-' + id);
            if (modal) modal.showModal();
        });
    });

    // Cerrar modales con botón personalizado
    document.querySelectorAll('[data-close-modal]').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-close-modal');
            const modal = document.getElementById('modal-' + id);
            if (modal) modal.close();
        });
    });

    // Cerrar flash
    document.querySelectorAll('[data-close-flash]').forEach(button => {
        button.addEventListener('click', () => {
            const flash = document.getElementById('flash-message');
            if (flash) flash.remove();
        });
    });

    // Cierre de modales por clic fuera o Escape
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('click', e => {
            const rect = dialog.getBoundingClientRect();
            if (
                e.clientX < rect.left || e.clientX > rect.right ||
                e.clientY < rect.top || e.clientY > rect.bottom
            ) {
                dialog.close();
            }
        });

        dialog.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                dialog.close();
            }
        });
    });

    document.querySelectorAll('input[name="cantidadFilas"], input[name="cantidadColumnas"]').forEach(input => {
        input.addEventListener('input', () => {
            let val = parseInt(input.value);
            if (val > 13) input.value = 13;
            if (val < 5) input.value = 5;
        });
    });

    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => flash.remove(), 3000);
    }

});


// SESIONES

document.addEventListener('DOMContentLoaded', () => {
    // Abrir modales
    document.querySelectorAll('[data-open-modal]').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-open-modal');
            const modal = document.getElementById('modal-' + id);
            if (modal) modal.showModal();
        });
    });

    // Cerrar modales
    document.querySelectorAll('[data-close-modal]').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-close-modal');
            const modal = document.getElementById('modal-' + id);
            if (modal) modal.close();
        });
    });

    // Cerrar flash
    document.querySelectorAll('[data-close-flash]').forEach(button => {
        button.addEventListener('click', () => {
            const flash = document.getElementById('flash-message');
            if (flash) flash.remove();
        });
    });

    // Cerrar modales con clic fuera del contenido o tecla Escape
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('click', e => {
            const rect = dialog.getBoundingClientRect();
            if (
                e.clientX < rect.left || e.clientX > rect.right ||
                e.clientY < rect.top || e.clientY > rect.bottom
            ) {
                dialog.close();
            }
        });

        dialog.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                dialog.close();
            }
        });
    });

    // Ocultar mensaje flash automáticamente
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => flash.remove(), 3000);
    }
});


// SLIDERS
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-open-modal]').forEach(button => {
        button.addEventListener('click', () => {
        const id = button.getAttribute('data-open-modal')
        const modal = document.getElementById('modal-' + id)
        if (modal) modal.showModal()
        })
    })
    
    document.querySelectorAll('[data-close-modal]').forEach(button => {
        button.addEventListener('click', () => {
        const id = button.getAttribute('data-close-modal')
        const modal = document.getElementById('modal-' + id)
        if (modal) modal.close()
        })
    })
    
    document.querySelectorAll('[data-close-flash]').forEach(button => {
        button.addEventListener('click', () => {
        const flash = document.getElementById('flash-message')
        if (flash) flash.remove()
        })
    })
    
    document.querySelectorAll('[data-edit-slider]').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id')
            const idPelicula = button.getAttribute('data-pelicula-id')
            const form = document.getElementById('sliderForm')
            form.action = `/adminSH/sliders/${id}`
            document.getElementById('modalTitle').innerText = 'Editar Slider'
            document.getElementById('sliderMethod').value = 'PUT'
            const select = document.getElementById('idPelicula')
            for (let i = 0; i < select.options.length; i++) {
                if (parseInt(select.options[i].value) === parseInt(idPelicula)) {
                    select.selectedIndex = i
                    break
                }
            }
            const modal = document.getElementById('modal-create')
            if (modal) modal.showModal()
            })
    })
    
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('click', e => {
            const rect = dialog.getBoundingClientRect()
            if (
                e.clientX < rect.left || e.clientX > rect.right ||
                e.clientY < rect.top || e.clientY > rect.bottom
            ) { dialog.close() }
        })
        dialog.addEventListener('keydown', e => {
            if (e.key === 'Escape') dialog.close()
        })
    })
    
    const flash = document.getElementById('flash-message')
    if (flash) setTimeout(() => flash.remove(), 3000)
})
    