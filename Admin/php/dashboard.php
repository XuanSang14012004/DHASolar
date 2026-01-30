<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

/* ===== Tổng số liệu ===== */

function getTotal($conn, $table)
{
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total'];
}

$totalPosts    = getTotal($conn, "posts");
$totalContacts = getTotal($conn, "contacts");
$totalProjects = getTotal($conn, "projects");

/* ===== Thống kê theo tháng ===== */

$projectData = [];
$contactData = [];

for ($i = 1; $i <= 12; $i++) {

   
    $sql2 = "SELECT COUNT(*) AS total FROM contacts 
             WHERE MONTH(created_at) = $i";
    $contactData[] = $conn->query($sql2)->fetch_assoc()['total'];
}

/* ===== Liên hệ mới nhất ===== */

$latestContacts = $conn->query("
    SELECT fullname, phone, created_at 
    FROM contacts 
    ORDER BY id DESC 
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<link rel="stylesheet" href="admin.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

.cards{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap:20px;
    margin-bottom:40px;
}

.card{
    background:white;
    padding:25px;
    border-radius:10px;
    text-align:center;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

.card p{
    font-size:30px;
    font-weight:bold;
    color:#ff9800;
}

.chart-box{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th, td{
    padding:10px;
    border:1px solid #ddd;
    text-align:left;
}

</style>

</head>

<body>

<div class="admin">

<!-- Sidebar -->
<aside class="sidebar">
    <h2>⚡ Solar Admin</h2>
    <ul>
        <li class="active"><a href="dashboard.php">Dashboard</a></li>
        <li><a href="projects.php">Dự án</a></li>
        <li><a href="contacts.php">Liên hệ</a></li>
        <li><a href="posts.php">Bài viết</a></li>
        <li><a href="logout.php">Đăng xuất</a></li>
    </ul>
</aside>

<!-- Content -->
<main class="content">

<h1>Dashboard</h1>

<!-- ===== Cards ===== -->
<div class="cards">

    <div class="card">
        <h3>Tổng dự án</h3>
        <p><?= $totalProjects ?></p>
    </div>

    <div class="card">
        <h3>Tổng liên hệ</h3>
        <p><?= $totalContacts ?></p>
    </div>

    <div class="card">
        <h3>Tổng bài viết</h3>
        <p><?= $totalPosts ?></p>
    </div>

</div>



<!-- ===== Chart liên hệ ===== -->
<div class="chart-box">
    <h3>Liên hệ theo tháng</h3>
    <canvas id="contactChart"></canvas>
</div>

<!-- ===== Liên hệ mới ===== -->
<div class="chart-box">
    <h3>Liên hệ mới nhất</h3>

    <table>
        <tr>
            <th>Họ tên</th>
            <th>SĐT</th>
            <th>Ngày</th>
        </tr>

        <?php while($row = $latestContacts->fetch_assoc()): ?>
        <tr>
            <td><?= $row['fullname'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

</main>
</div>

<!-- ===== JS Chart ===== -->
<script>

const months = ["1","2","3","4","5","6","7","8","9","10","11","12"];


/* ===== Contact Chart ===== */
new Chart(document.getElementById("contactChart"), {
    type: "bar",
    data: {
        labels: months,
        datasets: [{
            label: "Liên hệ",
            data: <?= json_encode($contactData) ?>
        }]
    }
});

</script>

</body>
</html>
