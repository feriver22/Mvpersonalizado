<div class="auth-page">
    <div class="auth-container">
        <h1>Iniciar Sesión</h1>
        {{if error}}
        <div class="alert alert-danger">{{error}}</div>
        {{/if}}
        
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="tu@email.com">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
        </form>

        <div class="auth-footer">
            <p>¿No tienes cuenta? <a href="index.php?page=Sec_Register">Crear una aquí</a></p>
        </div>
    </div>
</div>

<style>
.auth-page {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 60vh;
}

.auth-container {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}

.auth-container h1 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: #333;
}

.auth-form {
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.btn-block {
    width: 100%;
}

.auth-footer {
    text-align: center;
    font-size: 0.9rem;
}

.auth-footer a {
    color: #667eea;
    text-decoration: none;
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 4px;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>
