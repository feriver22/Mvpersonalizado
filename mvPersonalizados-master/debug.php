<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'NOT SET') . PHP_EOL;
echo "REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'NOT SET') . PHP_EOL;
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'NOT SET') . PHP_EOL;
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'NOT SET') . PHP_EOL;

echo "\nAll SERVER vars:\n";
foreach ($_SERVER as $key => $val) {
    if (is_scalar($val)) {
        echo "$key => $val\n";
    }
}
