<!DOCTYPE html>
<html>
<head>
    <title>登入</title>
</head>
<body>
    <h2>登入表單</h2>
    <form action="login.php" method="post">
        用戶名: <input type="text" name="username" required><br>
        密碼: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="登入">
    </form>
</body>
</html>
<?php
if (isset($_POST['login'])) {
    // 連接到數據庫
    $conn = new mysqli('localhost', 'your_username', 'your_password', 'your_database');

    // 檢查連接
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "登入成功！歡迎 " . $username;
            // 處理登入邏輯，例如開啟會話（session）等
        } else {
            echo "密碼錯誤";
        }
    } else {
        echo "找不到用戶";
    }

    $conn->close();
}
?>
