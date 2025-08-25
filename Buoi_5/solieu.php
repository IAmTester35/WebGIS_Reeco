<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dữ liệu từ bảng dathiemman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="my-4">Dữ liệu từ bảng dathiemman</h1>

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
        
        echo "<p class='alert alert-success'>Kết nối đến PostgreSQL thành công!</p>";

        $sql = "SELECT id, dientich, huyen FROM datnhiemman LIMIT 100";

        $stmt = $pdo->query($sql);

        $data = $stmt->fetchAll();

        if ($data) {
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='table-dark'><tr><th>ID</th><th>Diện tích</th><th>Huyện</th><th>Hành động</th></tr></thead>";
            echo "<tbody>";

            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['dientich']) . "</td>";
                echo "<td>" . htmlspecialchars($row['huyen']) . "</td>";
                echo "<td>";
                // Nút Sửa
                echo "<a href='edit.php?id=" . urlencode($row['id']) . "' class='btn btn-warning btn-sm me-2'>Sửa</a>";
                // Form Xóa
                echo "<form action='delete.php' method='POST' class='d-inline' onsubmit='return confirm(\"Bạn có chắc chắn muốn xóa bản ghi này?\");'>";
                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Xóa</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='alert alert-info'>Không tìm thấy dữ liệu trong bảng dathiemman.</p>";
        }

    } catch (PDOException $e) {
        echo "<p class='alert alert-danger'>Lỗi kết nối hoặc truy vấn: " . $e->getMessage() . "</p>";
    }

    ?>
</div>

</body>
</html>