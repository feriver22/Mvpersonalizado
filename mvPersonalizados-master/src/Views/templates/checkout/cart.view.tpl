<div class="cart-page">
    <h1>Mi Carrito de Compras</h1>

    {{if items}}
    <div class="cart-items">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{foreach items as $item}}
                <tr>
                    <td>{{$item->name}}</td>
                    <td>L. {{$item->price}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>L. {{$item->total}}</td>
                    <td>
                        <button class="btn-remove" onclick="removeFromCart({{$item->id}})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                {{/foreach}}
            </tbody>
        </table>
    </div>

    <div class="cart-summary">
        <div class="summary-content">
            <h3>Resumen de Compra</h3>
            <div class="summary-row">
                <span>Subtotal:</span>
                <strong>L. {{total}}</strong>
            </div>
            <div class="summary-row">
                <span>Envío:</span>
                <strong>Gratis</strong>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <strong>L. {{total}}</strong>
            </div>
        </div>
        <form method="POST" action="index.php?page=Checkout_Checkout">
            <button type="submit" class="btn btn-primary btn-block">Proceder al Pago</button>
        </form>
    </div>
    {{/if}}

    {{if !items}}
    <div class="empty-cart">
        <i class="fas fa-shopping-cart"></i>
        <p>Tu carrito está vacío</p>
        <a href="index.php?page=Products_Products" class="btn btn-primary">Seguir Comprando</a>
    </div>
    {{/if}}
</div>

<style>
.cart-page {
    padding: 2rem 0;
}

.cart-page h1 {
    margin-bottom: 2rem;
}

.cart-items {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    overflow-x: auto;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
}

.cart-table th {
    background: #f5f5f5;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    border-bottom: 2px solid #ddd;
}

.cart-table td {
    padding: 1rem;
    border-bottom: 1px solid #eee;
}

.btn-remove {
    background: #dc3545;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-remove:hover {
    background: #c82333;
}

.cart-summary {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    max-width: 400px;
    margin-left: auto;
}

.summary-content h3 {
    margin-bottom: 1.5rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    font-size: 0.95rem;
}

.summary-row.total {
    border-top: 2px solid #ddd;
    padding-top: 1rem;
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
}

.empty-cart {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 8px;
}

.empty-cart i {
    font-size: 3rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.btn-block {
    width: 100%;
}

@media (max-width: 768px) {
    .cart-summary {
        max-width: 100%;
        margin-left: 0;
        margin-top: 2rem;
    }
}
</style>
