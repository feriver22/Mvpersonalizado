<div class="register-success">
    <div class="success-container">
        <i class="fas fa-check-circle"></i>
        <h1>¡Cuenta Creada Exitosamente!</h1>
        <p>{{message}}</p>
        <a href="index.php?page=Sec_Login" class="btn btn-primary">Iniciar Sesión</a>
    </div>
</div>

<style>
.register-success {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 60vh;
}

.success-container {
    text-align: center;
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.success-container i {
    font-size: 3rem;
    color: #28a745;
    margin-bottom: 1rem;
}

.success-container h1 {
    color: #333;
    margin-bottom: 1rem;
}

.success-container p {
    color: #666;
    margin-bottom: 1.5rem;
}
</style>
