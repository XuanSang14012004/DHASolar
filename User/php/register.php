<?php
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = md5($_POST['password']);
    $confirmPassword = md5($_POST['confirm_password']);

    // Kiểm tra nhập đủ
    if (
        empty($fullname) ||
        empty($email) ||
        empty($_POST['password']) ||
        empty($_POST['confirm_password'])
    ) {

        echo "<script>
            alert('Vui lòng nhập đầy đủ thông tin');
        </script>";
    }

    // Kiểm tra mật khẩu
    elseif ($password != $confirmPassword) {

        echo "<script>
            alert('Mật khẩu xác nhận không khớp');
        </script>";
    }

    else {

        // Kiểm tra email tồn tại
        $check = mysqli_query(
            $conn,
            "SELECT * FROM users WHERE email = '$email'"
        );

        if (mysqli_num_rows($check) > 0) {

            echo "<script>
                alert('Email đã tồn tại');
            </script>";

        } else {

            $sql = "
                INSERT INTO users
                (
                    fullname,
                    email,
                    password,
                    role
                )
                VALUES
                (
                    '$fullname',
                    '$email',
                    '$password',
                    'user'
                )
            ";

            mysqli_query($conn, $sql);

            echo "<script>
                alert('Đăng ký thành công');
                window.location='login.php';
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Đăng ký</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            font-family:Arial;
            background:#f5f5f5;
        }

        .register-box{

            width:420px;

            margin:60px auto;

            background:#fff;

            padding:35px;

            border-radius:12px;

            box-shadow:0 0 15px rgba(0,0,0,0.1);
        }

        .register-box h2{

            text-align:center;

            margin-bottom:25px;

            color:#333;
        }

        .form-group{

            margin-bottom:18px;
        }

        .form-group label{

            display:block;

            margin-bottom:6px;

            font-weight:600;
        }

        .form-group input{

            width:100%;

            padding:12px;

            border:1px solid #ccc;

            border-radius:6px;

            font-size:15px;
        }

        .btn-register{

            width:100%;

            padding:12px;

            border:none;

            background:#28a745;

            color:white;

            border-radius:6px;

            font-size:16px;

            cursor:pointer;
        }

        .btn-register:hover{

            background:#218838;
        }

        .login-link{

            margin-top:20px;

            text-align:center;

            font-size:14px;
        }

        .login-link a{

            color:#28a745;

            text-decoration:none;

            font-weight:bold;
        }

        .login-link a:hover{

            text-decoration:underline;
        }

    </style>

</head>

<body>

<div class="register-box">

    <h2>Đăng ký tài khoản</h2>

    <form method="POST">

        <div class="form-group">

            <label>Họ và tên</label>

            <input
                type="text"
                name="fullname"
                placeholder="Nhập họ tên"
                required
            >

        </div>

        <div class="form-group">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Nhập email"
                required
            >

        </div>

        <div class="form-group">

            <label>Mật khẩu</label>

            <input
                type="password"
                name="password"
                placeholder="Nhập mật khẩu"
                required
            >

        </div>

        <div class="form-group">

            <label>Xác nhận mật khẩu</label>

            <input
                type="password"
                name="confirm_password"
                placeholder="Nhập lại mật khẩu"
                required
            >

        </div>

        <button
            type="submit"
            class="btn-register"
        >
            Đăng ký
        </button>
    </form>
    <div class="login-link">

        Đã có tài khoản?
        <a href="login.php">
            Đăng nhập
        </a>

    </div>

</div>

</body>
</html>