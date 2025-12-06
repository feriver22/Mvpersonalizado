<?php
/**
 * PSR-4 Autoloader Simple (sin Composer)
 * Carga automáticamente las clases del proyecto
 */

spl_autoload_register(function ($class) {
    // Reemplazar barras invertidas por barras normales
    $file = str_replace('\\', '/', $class) . '.php';
    
    // Buscar en src/
    $path = __DIR__ . '/src/' . $file;
    
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    
    return false;
});

// Alias para no-namespace classes si es necesario
class_alias('Utilities\Context', 'Context');
class_alias('Utilities\Site', 'Site');
class_alias('Utilities\Security', 'Security');
?>
