// Carrito de compras - Funcionalidad
document.addEventListener('DOMContentLoaded', function() {
    initializeCart();
});

function initializeCart() {
    const addCartButtons = document.querySelectorAll('.btn-add-cart');
    addCartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    });

    updateCartDisplay();
}

async function addToCart(event) {
    event.preventDefault();
    const button = event.target.closest('.btn-add-cart');
    const productId = button.getAttribute('data-product-id');
    
    if (!productId) {
        showAlert('Error: Producto no válido', 'danger');
        return;
    }

    try {
        const response = await fetch('index.php?page=Products_AddCart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        });

        const data = await response.json();

        if (data.success) {
            showAlert(data.message, 'success');
            updateCartDisplay();
            button.innerHTML = '<i class="fas fa-check"></i> Agregado';
            button.disabled = true;
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-shopping-cart"></i> Agregar';
                button.disabled = false;
            }, 2000);
        } else {
            showAlert(data.error || 'Error al agregar al carrito', 'danger');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Error al procesar la solicitud', 'danger');
    }
}

function removeFromCart(productId) {
    // Esta función podría implementarse con llamada AJAX
    if (confirm('¿Deseas eliminar este producto del carrito?')) {
        // Recargar la página o actualizar carrito
        window.location.href = 'index.php?page=Checkout_Cart';
    }
}

function updateCartDisplay() {
    const cartCount = document.getElementById('cartCount');
    if (cartCount) {
        // Actualizar conteo del carrito desde sesión
        fetchCartCount();
    }
}

async function fetchCartCount() {
    try {
        const response = await fetch('index.php?page=Products_CartCount');
        const data = await response.json();
        const cartCount = document.getElementById('cartCount');
        if (cartCount && data.count) {
            cartCount.textContent = data.count;
        }
    } catch (error) {
        console.error('Error fetching cart count:', error);
    }
}

function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <strong>${type === 'success' ? '✓' : '✗'}</strong> ${message}
        <button style="float:right; border:none; background:none; cursor:pointer;" onclick="this.parentElement.remove()">×</button>
    `;
    
    const container = document.querySelector('.main-content') || document.body;
    container.insertBefore(alertDiv, container.firstChild);

    // Auto-remover después de 5 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Validación de formularios
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            input.style.borderColor = '';
        }
    });

    return isValid;
}

// Formateo de precios
function formatPrice(price) {
    return new Intl.NumberFormat('es-HN', {
        style: 'currency',
        currency: 'HNL',
        minimumFractionDigits: 2
    }).format(price);
}

// Scroll suave
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
