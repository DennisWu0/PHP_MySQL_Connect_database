<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST">
        <h1>登入網站</h1> <br>
        username: <br>
        <input type="text" name="username"> <br><br>
        password: <br>
        <input type="password" name="password"> <br><br>
    
        <input type="submit" name="register" value="Log in"> <br>
    </form>


<?php

    include("database.php");

    session_start();

    // 接收表單資料
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 驗證帳號密碼
    $sql = "SELECT * FROM contacts WHERE user='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // 登入成功
    if ($row) {
        // 將使用者資訊儲存在 Session 變數
        $_SESSION['login_session'] = $row;

        // 導向首頁
        header("Location: home.php");
        exit();
    }
    elseif(empty($username)){
        echo"Please fill a username";
    }
    elseif(empty($password)){
        echo"Please fill a password";
    }

    // 登入失敗
    else {
        // 顯示錯誤訊息
        echo "帳號或密碼錯誤！";
    }

    mysqli_close($conn);
?>

</body>
</html>
