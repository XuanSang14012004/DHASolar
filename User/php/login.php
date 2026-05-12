<?php
session_start();
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "
        SELECT * FROM users
        WHERE email = '$email'
        AND password = '$password'
    ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user'] = $user;

        // ADMIN
        if (trim(strtolower($user['role'])) == 'admin') {

            header("Location: /DOANCNPM/Admin/php/dashboard.php");
            exit();
        } else {

            header("Location: /DOANCNPM/User/php/index.php");
            exit();
        }
    } else {

        echo "<script>
            alert('Sai email hoặc mật khẩu');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }

        .login-box {

            width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {

            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {

            width: 100%;
            padding: 12px;
            border: none;
            background: #28a745;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        .register-link {

            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .register-link a {

            color: #28a745;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {

            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="login-box">

        <h2>Đăng nhập</h2>

        <form method="POST">

            <input
                type="email"
                name="email"
                placeholder="Email"
                required>

            <input
                type="password"
                name="password"
                placeholder="Mật khẩu"
                required>

            <button type="submit">
                Đăng nhập
            </button>
            <div class="register-link">
                Chưa có tài khoản?
                <a href="register.php">Đăng ký</a>
            </div>

        </form>

    </div>

</body>

</html>