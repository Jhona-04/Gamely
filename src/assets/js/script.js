// ================================================
// Confirmar eliminación de usuario en panel admin
// ================================================
function confirmarEliminar(nombreUsuario) {
    return confirm(`¿Estás seguro de que deseas eliminar al usuario "${nombreUsuario}"?\n\nEsta acción no se puede deshacer.`);
}

// ============================================
// Confirmar eliminación de juego del carrito
// ============================================
function confirmarEliminarJuego(nombreJuego) {
    return confirm(`¿Deseas eliminar "${nombreJuego}" del carrito?`);
}

// ============================================
//  Animación al añadir al carrito
// ============================================
function animarAgregarCarrito(boton) {
    const textoOriginal = boton.innerHTML;
    boton.innerHTML = '<i class="fa-solid fa-check"></i> ¡Añadido!';
    boton.style.background = 'linear-gradient(135deg, #00b894, #00cec9)';
    
    setTimeout(() => {
        boton.innerHTML = textoOriginal;
        boton.style.background = '';
    }, 2000);
}

// ============================================
//  Validación del formulario de carrito
// ============================================
function validarFormularioCarrito() {
    const nombre = document.getElementById('nombre_cliente');
    const correo = document.getElementById('correo');
    
    if (!nombre || !correo) return true;
    
    // Validar nombre
    if (nombre.value.trim().length < 3) {
        alert('Por favor, ingresa tu nombre completo (mínimo 3 caracteres)');
        nombre.focus();
        return false;
    }
    
    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo.value)) {
        alert('Por favor, ingresa un correo electrónico válido');
        correo.focus();
        return false;
    }
    
    return confirm('¿Confirmas que deseas enviar este pedido?\n\nSe enviará un correo a: ' + correo.value);
}

// ============================================
// Auto-ocultar mensajes después de 5 segundos
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const mensajes = document.querySelectorAll('.carrito-mensaje, .mensaje');
    
    mensajes.forEach(mensaje => {
        setTimeout(() => {
            mensaje.style.opacity = '0';
            mensaje.style.transition = 'opacity 0.5s';
            
            setTimeout(() => {
                mensaje.style.display = 'none';
            }, 500);
        }, 5000);
    });
});

// ============================================
//  Actualizar contador del carrito dinámicamente
// ============================================
function actualizarContadorCarrito() {
    const items = document.querySelectorAll('.carrito-item');
    const contador = document.querySelector('.carrito-contador');
    const headerCount = document.querySelector('.carrito-header__count');
    
    let total = 0;
    items.forEach(item => {
        const cantidadElement = item.querySelector('.carrito-item__cantidad');
        if (cantidadElement) {
            total += parseInt(cantidadElement.textContent) || 0;
        }
    });
    
    if (contador) {
        contador.textContent = total;
        contador.style.display = total > 0 ? 'inline-flex' : 'none';
    }
    
    if (headerCount) {
        headerCount.textContent = `${total} artículo${total !== 1 ? 's' : ''}`;
    }
}

// =================================================
//  Animación de carga para el envío del formulario
// =================================================
function mostrarCargando(formulario) {
    const boton = formulario.querySelector('button[type="submit"]');
    if (!boton) return;
    
    const textoOriginal = boton.innerHTML;
    boton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Enviando...';
    boton.disabled = true;
    
    //Si el formulario no se envía (error), restaurar
    setTimeout(() => {
        if (boton.disabled) {
            boton.innerHTML = textoOriginal;
            boton.disabled = false;
        }
    }, 10000);
}

// ============================================
// Prevenir múltiples envíos del formulario
// ============================================
let formularioEnviado = false;

document.addEventListener('DOMContentLoaded', function() {
    const formularios = document.querySelectorAll('form');
    
    formularios.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (formularioEnviado) {
                e.preventDefault();
                alert('El formulario ya ha sido enviado. Por favor, espera...');
                return false;
            }
            
            if (this.querySelector('button[name="comprar"]')) {
                if (!validarFormularioCarrito()) {
                    e.preventDefault();
                    return false;
                }
            }
            
            formularioEnviado = true;
            mostrarCargando(this);
        });
    });
});

// ======================================================
//  Guardar datos del formulario en localStorage (backup)
// ======================================================
function guardarFormulario() {
    const nombre = document.getElementById('nombre_cliente');
    const correo = document.getElementById('correo');
    
    if (nombre && correo) {
        localStorage.setItem('carrito_nombre', nombre.value);
        localStorage.setItem('carrito_correo', correo.value);
    }
}

function cargarFormulario() {
    const nombre = document.getElementById('nombre_cliente');
    const correo = document.getElementById('correo');
    
    if (nombre && !nombre.value) {
        nombre.value = localStorage.getItem('carrito_nombre') || '';
    }
    
    if (correo && !correo.value) {
        correo.value = localStorage.getItem('carrito_correo') || '';
    }
}

//Cargar datos guardados al cargar la página
document.addEventListener('DOMContentLoaded', cargarFormulario);

//Guardar datos mientras el usuario escribe
document.addEventListener('DOMContentLoaded', function() {
    const nombre = document.getElementById('nombre_cliente');
    const correo = document.getElementById('correo');
    
    if (nombre) nombre.addEventListener('input', guardarFormulario);
    if (correo) correo.addEventListener('input', guardarFormulario);
});

// ============================================
//  Mostrar/ocultar detalles adicionales
// ============================================
function toggleDetalles(id) {
    const detalles = document.getElementById(id);
    if (!detalles) return;
    
    if (detalles.style.display === 'none' || !detalles.style.display) {
        detalles.style.display = 'block';
        detalles.style.animation = 'fadeIn 0.3s';
    } else {
        detalles.style.display = 'none';
    }
}

//Animación CSS para fadeIn
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);

console.log('✅ Script de Gamely cargado correctamente');

// ============================================
// AÑADIR AL CARRITO (envío por POST a sesión)
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    //Añadir estilos para las animaciones
    if (!document.getElementById('notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to   { transform: translateX(0);     opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0);     opacity: 1; }
                to   { transform: translateX(400px); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }

    //Capturar clics en los botones de añadir al carrito
    document.querySelectorAll('.game-card__button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            //Leer datos desde atributos data- del botón
            const id     = this.dataset.id;
            const nombre = this.dataset.nombre;
            const precio = this.dataset.precio;

            console.log('Añadiendo al carrito:', {id, nombre, precio}); // Debug

            //Crear FormData y enviar por fetch (POST)
            const formData = new FormData();
            formData.append('accion',  'añadir');
            formData.append('id',      id);
            formData.append('nombre',  nombre);
            formData.append('precio',  precio);

            //La ruta es relativa desde catalogo.php (/src/public/client/catalogo.php)
            //Entonces ../carrito_accion.php apunta a /src/public/carrito_accion.php
            fetch('../carrito_accion.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status); // Debug
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text(); // Primero como texto para ver qué llega
            })
            .then(text => {
                console.log('Response text:', text); // Debug
                try {
                    const data = JSON.parse(text);
                    console.log('Response JSON:', data); // Debug
                    
                    if (data.success) {
                        showNotification(`¡${nombre} añadido al carrito por €${precio}!`);

                        //Efecto visual temporal en el botón
                        const originalText = this.textContent;
                        this.textContent   = '✓ Añadido';
                        this.style.background = 'linear-gradient(135deg, #10b981, #059669)';

                        setTimeout(() => {
                            this.textContent   = originalText;
                            this.style.background = '';
                        }, 2000);

                        //Actualizar contador del carrito si existe en el header
                        if (data.cantidad !== undefined) {
                            actualizarContador(data.cantidad);
                        }
                    } else {
                        showNotification(data.message || 'Error al añadir al carrito', true);
                    }
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    console.error('Texto recibido:', text);
                    showNotification('Error: respuesta inválida del servidor', true);
                }
            })
            .catch(err => {
                console.error('Error en fetch:', err);
                showNotification('Error de conexión. Verifica la consola (F12) para más detalles.', true);
            });
        });
    });
});

// ============================================
// ACTUALIZAR CONTADOR DEL CARRITO EN EL HEADER
// ============================================
function actualizarContador(cantidad) {
    let badge = document.querySelector('.carrito-contador');
    
    if (!badge && cantidad > 0) {
        //Crear badge si no existe
        const enlace = document.querySelector('.header-inferior__action-link[href*="carrito"]');
        if (enlace) {
            badge = document.createElement('span');
            badge.className = 'carrito-contador';
            badge.id = 'contador-carrito';
            enlace.appendChild(badge);
        }
    }
    
    if (badge) {
        badge.textContent = cantidad;
        badge.style.display = cantidad > 0 ? 'inline-flex' : 'none';
    }
}

// ============================================
// SISTEMA DE NOTIFICACIONES
// ============================================
function showNotification(message, esError = false) {
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();

    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;

    const color   = esError ? '#ef4444' : '#10b981';
    const shadow  = esError ? 'rgba(239,68,68,0.4)' : 'rgba(16,185,129,0.4)';

    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 30px;
        background: linear-gradient(135deg, ${color}, ${esError ? '#dc2626' : '#059669'});
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px ${shadow};
        z-index: 10000;
        font-weight: 600;
        animation: slideIn 0.3s ease-out;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}


