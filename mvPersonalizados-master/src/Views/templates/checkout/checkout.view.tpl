<div class="checkout-page">
    <h1>Procesamiento de Pago</h1>
    
    <div class="checkout-container">
        <div class="checkout-items">
            <h2>Resumen de Compra</h2>
            {{if total}}
            <div class="order-summary">
                <div class="summary-item">
                    <span>Total a Pagar:</span>
                    <strong>L. {{total}}</strong>
                </div>
                <p class="info-text">Por favor confirma tu compra para proceder con el pago.</p>
            </div>
            {{/if}}
        </div>

        <div class="checkout-payment">
            <h2>Confirmar Pago</h2>
            <form method="POST" class="payment-form">
                <div class="payment-method">
                    <h3>Método de Pago</h3>
                    <label>
                        <input type="radio" name="payment_method" value="paypal" checked>
                        <i class="fab fa-paypal"></i> PayPal
                    </label>
                </div>

                <div class="terms">
                    <label>
                        <input type="checkbox" name="accept_terms" required>
                        Acepto los términos y condiciones de compra
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-lock"></i> Completar Compra
                </button>
                <a href="index.php?page=Checkout_Cart" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Volver al Carrito
                </a>
            </form>

            <div class="security-info">
                <p><i class="fas fa-shield-alt"></i> Transacción segura con SSL 256-bit</p>
            </div>
        </div>
    </div>
</div>

<style>
.checkout-page {
    padding: 2rem 0;
}

.checkout-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-top: 2rem;
}

.checkout-items,
.checkout-payment {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.checkout-items h2,
.checkout-payment h2 {
    margin-bottom: 1.5rem;
}

.order-summary {
    background: #f9f9f9;
    padding: 1.5rem;
    border-radius: 6px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    font-size: 1.2rem;
    font-weight: bold;
}

.info-text {
    margin-top: 1rem;
    color: #666;
    font-size: 0.9rem;
}

.payment-method {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #eee;
}

.payment-method label {
    display: block;
    padding: 1rem;
    border: 2px solid #eee;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
}

.payment-method label:hover {
    border-color: #667eea;
    background: #f9f9f9;
}

.payment-method input[type="radio"] {
    margin-right: 0.5rem;
}

.payment-method i {
    margin-right: 0.5rem;
}

.terms {
    margin-bottom: 2rem;
}

.terms label {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.terms input[type="checkbox"] {
    margin-right: 0.5rem;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1rem;
    width: 100%;
    margin-bottom: 0.5rem;
}

.security-info {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #eee;
    text-align: center;
    color: #28a745;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .checkout-container {
        grid-template-columns: 1fr;
    }
}
</style>
