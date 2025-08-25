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

$data = null;

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $dientich = $_POST['dientich'];
        $huyen = $_POST['huyen'];

        $sql = "UPDATE datnhiemman SET dientich = :dientich, huyen = :huyen WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dientich', $dientich);
        $stmt->bindParam(':huyen', $huyen);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        header("Location: solieu.php");
        exit();
    }
    
    if (isset($_GET['id'])) {
        $id_to_edit = $_GET['id'];
        
        $sql = "SELECT id, dientich, huyen FROM datnhiemman WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_to_edit, PDO::PARAM_INT);
        $stmt->execute();
        
        $data = $stmt->fetch();
        
        if (!$data) {
            echo "Lỗi: Không tìm thấy dữ liệu với ID này.";
            exit();
        }
    } else {
        echo "Lỗi: Không có ID được cung cấp để sửa.";
        exit();
    }

} catch (PDOException $e) {
    echo "Lỗi kết nối hoặc truy vấn: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa dữ liệu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="my-4">Chỉnh sửa dữ liệu</h1>

    <?php if ($data): ?>
    <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
        
        <div class="mb-3">
            <label for="dientich" class="form-label">Diện tích:</label>
            <input type="text" class="form-control" id="dientich" name="dientich" value="<?= htmlspecialchars($data['dientich']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="huyen" class="form-label">Huyện:</label>
            <input type="text" class="form-control" id="huyen" name="huyen" value="<?= htmlspecialchars($data['huyen']) ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </form>
    <?php endif; ?>
</div>

</body>
</html>