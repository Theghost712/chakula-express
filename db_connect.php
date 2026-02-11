<?php
/**
 * Database Connection
 * 
 * Reads credentials from environment variables for security and portability,
 * which is a best practice for cloud hosting like AWS.
 */

// --- Database Credentials - Read from Environment Variables ---
// On AWS (e.g., Elastic Beanstalk), you can set these in the configuration panel.
$host = getenv('DB_HOST') ?: 'localhost';       // Default to 'localhost' if not set
$db   = getenv('DB_NAME') ?: 'epol_cafeteria'; // Default for local dev
$user = getenv('DB_USER') ?: 'root';           // Default for local dev
$pass = getenv('DB_PASS') ?: '';               // Default for local dev
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // In a real production app, you should log this error, not echo it.
     http_response_code(500);
     echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
     exit;
}
?>