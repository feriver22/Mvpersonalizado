<div class="success-page">
    <div class="success-container">
        <div class="success-header">
            <i class="fas fa-check-circle"></i>
            <h1>¡Pago Realizado Exitosamente!</h1>
        </div>

        <div class="transaction-details">
            <h2>Detalles de tu Compra</h2>
            <div class="detail-row">
                <span>ID de Transacción:</span>
                <strong>{{transaction->transaction_id}}</strong>
            </div>
            <div class="detail-row">
                <span>Estado:</span>
                <strong class="status-completed">{{transaction->status}}</strong>
            </div>
            <div class="detail-row">
                <span>Monto Total:</span>
                <strong>L. {{transaction->total_amount}}</strong>
            </div>
            <div class="detail-row">
                <span>Fecha:</span>
                <strong>{{transaction->created_at}}</strong>
            </div>
        </div>

        <div class="items-section">
            <h2>Artículos Comprados</h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    {{foreach items as $item}}
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>L. {{$item->unit_price}}</td>
                        <td>L. {{$item->quantity * $item->unit_price}}</td>
                    </tr>
                    {{/foreach}}
                </tbody>
            </table>
        </div>

        <div class="next-steps">
            <h3>Próximos Pasos</h3>
            <ol>
                <li>Recibirás un email de confirmación en breve</li>
                <li>Tu pedido será preparado en 24-48 horas</li>
                <li>Te notificaremos cuando esté listo para envío</li>
            </ol>
        </div>

        <div class="action-buttons">
            <a href="index.php?page=Checkout_History" class="btn btn-primary">Ver Mis Compras</a>
            <a href="index.php?page=Products_Products" class="btn btn-secondary">Seguir Comprando</a>
        </div>
    </div>
</div>

<style>
.success-page {
    display: flex;
    justify-content: center;
    padding: 2rem 0;
}

.success-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    padding: 2.5rem;
    max-width: 600px;
    width: 100%;
}

.success-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid #28a745;
}

.success-header i {
    font-size: 4rem;
    color: #28a745;
    margin-bottom: 1rem;
}

.success-header h1 {
    color: #28a745;
    margin: 0;
}

.transaction-details {
    background: #f9f9f9;
    padding: 1.5rem;
    border-radius: 6px;
    margin-bottom: 2rem;
}

.transaction-details h2 {
    margin-top: 0;
    margin-bottom: 1rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #eee;
}

.detail-row:last-child {
    border-bottom: none;
}

.status-completed {
    color: #28a745;
    font-weight: bold;
}

.items-section {
    margin-bottom: 2rem;
}

.items-section h2 {
    margin-bottom: 1rem;
}

.items-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
}

.items-table th,
.items-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.items-table th {
    background: #f5f5f5;
    font-weight: 600;
}

.next-steps {
    background: #e3f2fd;
    padding: 1.5rem;
    border-radius: 6px;
    margin-bottom: 2rem;
}

.next-steps h3 {
    margin-top: 0;
    color: #1976d2;
}

.next-steps ol {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.next-steps li {
    margin-bottom: 0.5rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

.action-buttons .btn {
    flex: 1;
    text-align: center;
}

@media (max-width: 600px) {
    .success-container {
        padding: 1.5rem;
    }

    .action-buttons {
        flex-direction: column;
    }
}
</style>
