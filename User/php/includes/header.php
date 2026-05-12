<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>DHA Solar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="../../images/logo/logo2.png">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
<header>
    <div class="header">
        <div class="logo">
            <img src="../../images/logo/logo1.png" alt="DHA Solar">
        </div>

        <nav class="navigation">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="service.php">Dịch vụ</a></li>
                <li><a href="about.php">Về chúng tôi</a></li>
                <li><a href="project.php">Sản phẩm</a></li>
                <li><a href="knowledge.php">Kiến thức</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
            </ul>
        </nav>
        <div class="tuvan">
            <?php if(isset($_SESSION['user'])): ?>
                <div class="user-info">
                     Xin chào,
                    <strong>
                        <?= $_SESSION['user']['fullname'] ?>
                    </strong>
                    <a href="logout.php"
                       class="btn btn-book">
                        Đăng xuất
                    </a>
                </div>
            <?php else: ?>
                <a href="login.php"
                   class="btn btn-book">
                    Đăng nhập
                </a>
            <?php endif; ?>

        </div>
    </div>
</header>
