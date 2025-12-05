<div class="products-page">
    <h1>Catálogo de Productos</h1>
    <p class="subtitle">Personaliza tus momentos especiales</p>

    <div class="products-grid">
        {{foreach products as $product}}
        <div class="product-item">
            <div class="product-image">
                <img src="{{$product->image_url}}" alt="{{$product->name}}">
            </div>
            <div class="product-details">
                <h3>{{$product->name}}</h3>
                <p class="description">{{$product->description}}</p>
                <div class="product-footer">
                    <span class="price">L. {{$product->price}}</span>
                    <button class="btn btn-small btn-add-cart" data-product-id="{{$product->id}}">
                        <i class="fas fa-shopping-cart"></i> Agregar
                    </button>
                </div>
            </div>
        </div>
        {{/foreach}}
    </div>
</div>

<style>
.products-page {
    padding: 2rem 0;
}

.products-page h1 {
    text-align: center;
    margin-bottom: 0.5rem;
}

.subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 2rem;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.product-item {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

.product-image {
    width: 100%;
    height: 250px;
    background: #f5f5f5;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-details {
    padding: 1.5rem;
}

.product-details h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
    color: #333;
}

.description {
    color: #666;
    font-size: 0.9rem;
    margin: 0 0 1rem 0;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.price {
    font-weight: bold;
    font-size: 1.2rem;
    color: #667eea;
}

.btn-add-cart {
    flex: 1;
    cursor: pointer;
}

@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
}
</style>
