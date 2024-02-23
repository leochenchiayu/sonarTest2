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

    // 這裡直接將用戶輸入拼接到SQL查詢中，存在SQL注入的風險
    $username = $_POST['username']; // 未進行適當的過濾或預處理
    $password = $_POST['password']; // 密碼處理也不安全，應該使用password_hash和password_verify

    $sql = "SELECT id, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // 這裡直接比較密碼，未使用password_verify來安全地驗證密碼
        if ($password === $row['password']) {
            // 反射型XSS漏洞，直接將用戶輸入反映到頁面上
            echo "登入成功！歡迎 " . htmlspecialchars($username); // 加入htmlspecialchars來緩解XSS風險
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
