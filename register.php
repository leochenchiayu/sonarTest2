<!DOCTYPE html>
<html>
<head>
    <title>註冊</title>
</head>
<body>
    <h2>註冊表單</h2>
    <form action="register.php" method="post">
        用戶名: <input type="text" name="username" required><br>
        密碼: <input type="password" name="password" required><br>
        <input type="submit" name="register" value="註冊">
    </form>
</body>
</html>
<?php
if (isset($_POST['register'])) {
    // 連接到數據庫
    $conn = new mysqli('localhost', 'your_username', 'your_password', 'your_database');

    // 檢查連接
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 對密碼進行加密

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "新記錄創建成功";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
