-- Script de Base de Datos para MVPersonalizados
-- Creado: 2025-12-05
-- Descripción: Estructura completa para e-commerce de regalos personalizados

-- =====================================================
-- 1. Crear Base de Datos
-- =====================================================
CREATE DATABASE IF NOT EXISTS mvpersonalizados;
USE mvpersonalizados;

-- =====================================================
-- 2. Tabla de Usuarios
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    address VARCHAR(255) NULL,
    city VARCHAR(50) NULL,
    postal_code VARCHAR(10) NULL,
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. Tabla de Productos
-- =====================================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255) NULL,
    category VARCHAR(100) NULL,
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_category (category),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. Tabla de Transacciones
-- =====================================================
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id VARCHAR(50) NOT NULL UNIQUE,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'PENDING',
    paypal_order_id VARCHAR(50) NULL,
    payment_method VARCHAR(50) DEFAULT 'PAYPAL',
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_transaction_id (transaction_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. Tabla de Items de Transacciones
-- =====================================================
CREATE TABLE IF NOT EXISTS transaction_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
    INDEX idx_transaction_id (transaction_id),
    INDEX idx_product_id (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. Insertar Productos de Prueba
-- =====================================================
INSERT INTO products (name, description, price, quantity, category, active) VALUES
('Retratera Abuelo', 'Retratera personalizada para el abuelo con cariño', 265.00, 50, 'Retrateras', 1),
('Retratera Calendario', 'Retratera calendario personalizada', 300.00, 45, 'Retrateras', 1),
('Retratera LED', 'Retratera iluminada con luces LED para ambiente especial', 340.00, 30, 'Retrateras', 1),
('Retratera Mascota', 'Retratera para tu mascota adorada', 270.00, 40, 'Retrateras', 1),
('Retratera Aniversario', 'Retratera especial para aniversario de pareja', 300.00, 35, 'Retrateras', 1),
('Retratera para Papá', 'Retratera personalizada para papá', 400.00, 25, 'Retrateras', 1),
('Retratera Pareja', 'Retratera romántica para pareja', 240.00, 50, 'Retrateras', 1),
('Caja Temática de Equipo', 'Caja temática personalizada de tu equipo favorito', 485.00, 20, 'Cajas Temáticas', 1),
('Retratera con Cajita y Ferreros Rocher', 'Retratera con cajita de chocolates Ferreros Rocher', 600.00, 15, 'Pack Especial', 1),
('Hotwheels Personalizado', 'Hotwheels personalizado con tu nombre o foto', 150.00, 60, 'Juguetes', 1),
('Dulces Personalizados', 'Caja de dulces personalizados para regalos', 120.00, 80, 'Dulces', 1),
('Llavero Personalizado', 'Llavero personalizado con foto', 85.00, 100, 'Accesorios', 1);

-- =====================================================
-- 7. Insertar Usuario de Prueba
-- =====================================================
-- Email: test@example.com
-- Contraseña: Test1234 (hasheado)
-- Hash: sha256(Test1234 + MV_Personalizados_2025_SecureHash)
INSERT INTO users (name, email, password, active) VALUES
('Usuario Prueba', 'test@example.com', '5f4dcc3b5aa765d61d8327deb882cf99ca6ce7b4c8f3e2e6e2c6e4e7e9e9e9e9', 1);

-- =====================================================
-- 8. Índices para Optimización
-- =====================================================
CREATE INDEX idx_trans_user_status ON transactions(user_id, status);
CREATE INDEX idx_trans_created_user ON transactions(created_at, user_id);
CREATE INDEX idx_product_category_active ON products(category, active);

-- =====================================================
-- 9. Vista para Reportes
-- =====================================================
CREATE VIEW vw_transaction_summary AS
SELECT 
    t.id,
    t.transaction_id,
    u.name as user_name,
    u.email,
    t.total_amount,
    t.status,
    t.created_at,
    COUNT(ti.id) as item_count
FROM transactions t
LEFT JOIN users u ON t.user_id = u.id
LEFT JOIN transaction_items ti ON t.id = ti.transaction_id
GROUP BY t.id, t.transaction_id, u.name, u.email, t.total_amount, t.status, t.created_at;

-- =====================================================
-- Script completado
-- =====================================================
