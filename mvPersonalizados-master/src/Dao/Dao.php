<?php

namespace Dao;

class Dao {
    private static $_conn = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getConn($dds = null, $user = null, $pswd = null)
    {
        if (self::$_conn == null) {
            try {
                $_dds = sprintf(
                    "%s:host=%s;dbname=%s;port=%s;charset=utf8",
                    \Utilities\Context::getContextByKey("DB_PROVIDER"),
                    \Utilities\Context::getContextByKey("DB_SERVER"),
                    \Utilities\Context::getContextByKey("DB_DATABASE"),
                    \Utilities\Context::getContextByKey("DB_PORT")
                );
                $_user = \Utilities\Context::getContextByKey("DB_USER");
                $_pswd = \Utilities\Context::getContextByKey("DB_PSWD");
                if ($dds !== null) {
                    $_dds = $dds;
                }
                if ($user !== null) {
                    $_user = $user;
                }
                if ($pswd !== null) {
                    $_pswd = $pswd;
                }
                self::$_conn = new \PDO(
                    $_dds,
                    $_user,
                    $_pswd,
                    array(
                      \PDO::ATTR_EMULATE_PREPARES => true,
                      \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                      \PDO::ATTR_PERSISTENT => false
                    )
                );
            } catch (\Exception $e) {
                // Fallback a SQLite si MySQL no funciona
                self::initSQLite();
            }
        }
        return self::$_conn;
    }

    private static function initSQLite()
    {
        $dbPath = __DIR__ . '/../../data/mvpersonalizados.db';
        $dataDir = dirname($dbPath);
        
        if (!is_dir($dataDir)) {
            @mkdir($dataDir, 0755, true);
        }

        try {
            self::$_conn = new \PDO('sqlite:' . $dbPath);
            self::$_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::initSQLiteTables();
        } catch (\Exception $e) {
            error_log("Error: " . $e->getMessage());
        }
    }

    private static function initSQLiteTables()
    {
        $result = self::$_conn->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
        if ($result && $result->fetch()) {
            return;
        }

        // Crear tablas
        $tables = [
            "CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT, email TEXT UNIQUE, password TEXT, phone TEXT, address TEXT, city TEXT, postal_code TEXT, active INTEGER DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP)",
            "CREATE TABLE products (id INTEGER PRIMARY KEY, name TEXT, description TEXT, price REAL, quantity INTEGER DEFAULT 0, image_url TEXT, category TEXT, active INTEGER DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP)",
            "CREATE TABLE transactions (id INTEGER PRIMARY KEY, transaction_id TEXT UNIQUE, user_id INTEGER, total_amount REAL, status TEXT DEFAULT 'PENDING', paypal_order_id TEXT, payment_method TEXT DEFAULT 'PAYPAL', notes TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(user_id) REFERENCES users(id))",
            "CREATE TABLE transaction_items (id INTEGER PRIMARY KEY, transaction_id INTEGER, product_id INTEGER, quantity INTEGER, unit_price REAL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(transaction_id) REFERENCES transactions(id), FOREIGN KEY(product_id) REFERENCES products(id))"
        ];

        foreach ($tables as $sql) {
            self::$_conn->exec($sql);
        }

        self::insertSampleData();
    }

    private static function insertSampleData()
    {
        $inserts = [
            "INSERT OR IGNORE INTO users VALUES (1, 'Usuario Prueba', 'test@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, NULL, NULL, NULL, 1, datetime('now'), datetime('now'))",
            "INSERT OR IGNORE INTO products (name, description, price, quantity, category, active) VALUES ('Retratera Abuelo', 'Personalizada', 265.00, 50, 'Retrateras', 1)",
            "INSERT OR IGNORE INTO products (name, description, price, quantity, category, active) VALUES ('Retratera LED', 'Iluminada', 340.00, 30, 'Retrateras', 1)",
            "INSERT OR IGNORE INTO products (name, description, price, quantity, category, active) VALUES ('Caja Temática', 'Personalizada', 485.00, 20, 'Cajas', 1)",
        ];

        foreach ($inserts as $sql) {
            try {
                self::$_conn->exec($sql);
            } catch (\Exception $e) {}
        }
    }
}
?>
