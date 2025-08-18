<?php
$host = 'localhost';
$db = 'postgres';
$user = 'nammaithanh';
$password = '';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    $sql = "SELECT id, ST_X(vi_tri) AS longitude, ST_Y(vi_tri) AS latitude FROM test_table";

    $stmt = $pdo->query($sql);
    $locations = $stmt->fetchAll();
    echo json_encode($locations);

} catch (PDOException $e) {

    http_response_code(500);
    echo json_encode(['error' => 'Lỗi kết nối hoặc truy vấn: ' . $e->getMessage()]);
}


?>