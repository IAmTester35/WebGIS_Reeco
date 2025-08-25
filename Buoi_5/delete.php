<?php

$host = 'localhost';
$db = 'postgres';
$user = 'nammaithanh';
$password = '';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$db;options='--client_encoding=UTF8; --search_path=public'";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id_to_delete = $_POST['id'];

        $sql = "DELETE FROM datnhiemman WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_to_delete, PDO::PARAM_INT);
        $stmt->execute();
        
        header("Location: solieu.php");
        exit();
    } else {
        echo "Lỗi: Không có ID được cung cấp để xóa.";
    }

} catch (PDOException $e) {
    echo "Lỗi kết nối hoặc truy vấn: " . $e->getMessage();
}

?>