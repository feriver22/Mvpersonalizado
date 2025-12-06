<div class="history-page">
    <h1>Histórico de Mis Compras</h1>

    {{if transactions}}
    <div class="transactions-list">
        {{foreach transactions as $trans}}
        <div class="transaction-card">
            <div class="trans-header">
                <div class="trans-id">
                    <h3>{{$trans->transaction_id}}</h3>
                    <p class="trans-date">{{$trans->created_at}}</p>
                </div>
                <div class="trans-status {{$trans->status}}">
                    {{$trans->status}}
                </div>
            </div>
            <div class="trans-amount">
                <span>Total:</span>
                <strong>L. {{$trans->total_amount}}</strong>
            </div>
            <div class="trans-actions">
                <a href="index.php?page=Checkout_Success&transaction_id={{$trans->id}}" class="btn btn-small">
                    <i class="fas fa-eye"></i> Ver Detalles
                </a>
            </div>
        </div>
        {{/foreach}}
    </div>
    {{/if}}

    {{if !transactions}}
    <div class="empty-history">
        <i class="fas fa-history"></i>
        <p>No tienes compras registradas</p>
        <a href="index.php?page=Products_Products" class="btn btn-primary">Comenzar a Comprar</a>
    </div>
    {{/if}}
</div>

<style>
.history-page {
    padding: 2rem 0;
}

.history-page h1 {
    margin-bottom: 2rem;
}

.transactions-list {
    display: grid;
    gap: 1rem;
}

.transaction-card {
    background: white;
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.transaction-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.trans-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.trans-id h3 {
    margin: 0;
    font-size: 1rem;
}

.trans-date {
    margin: 0.25rem 0 0 0;
    font-size: 0.85rem;
    color: #666;
}

.trans-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.85rem;
}

.trans-status.COMPLETED {
    background: #d4edda;
    color: #155724;
}

.trans-status.PENDING {
    background: #fff3cd;
    color: #856404;
}

.trans-status.CANCELLED {
    background: #f8d7da;
    color: #721c24;
}

.trans-amount {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.trans-amount strong {
    color: #28a745;
}

.trans-actions {
    text-align: right;
}

.empty-history {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 8px;
}

.empty-history i {
    font-size: 3rem;
    color: #ddd;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .trans-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .trans-status {
        margin-top: 0.5rem;
    }
}
</style>
