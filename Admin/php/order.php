<?php
session_start();
include '../../config/database.php';

// Kiểm tra đăng nhập admin
// if (!isset($_SESSION['admin'])) {
//     header('Location: login.php');
//     exit();
// }

// XÓA ĐƠN HÀNG
if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];

    $delete_query = "DELETE FROM orders WHERE id = $id";

    mysqli_query($conn, $delete_query);

    header('Location: order.php');
    exit();
}

// CẬP NHẬT TRẠNG THÁI
if (isset($_GET['status']) && isset($_GET['id'])) {

    $id = (int)$_GET['id'];
    $status = $_GET['status'];

    $update_query = "
        UPDATE orders
        SET status = '$status'
        WHERE id = $id
    ";

    mysqli_query($conn, $update_query);

    header('Location: order.php');
    exit();
}

// LẤY DANH SÁCH ORDER
$query = "
    SELECT orders.*, solar_panels.name AS product_name
    FROM orders
    INNER JOIN solar_panels
    ON orders.product_id = solar_panels.id
    ORDER BY orders.created_at DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Lỗi SQL: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>

    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <div class="admin">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <h2>⚡ Solar Admin</h2>

            <ul>
                <li class="active"><a href="dashboard.php">Dashboard</a></li>
                <li><a href="projects.php">Sản phẩm</a></li>
                <li><a href="contacts.php">Liên hệ</a></li>
                <li><a href="posts.php">Bài viết</a></li>
                <li><a href="order.php">Đơn hàng</a></li>
                <li><a href="logout.php">Đăng xuất</a></li>
            </ul>

        </aside>

        <!-- CONTENT -->
        <main class="content">

            <div class="content-header">

                <h1>Quản lý đơn hàng</h1>

                <div class="header-stats">

                    <?php
                    $total_query = mysqli_query(
                        $conn,
                        "SELECT COUNT(*) as total FROM orders"
                    );

                    $total = mysqli_fetch_assoc($total_query)['total'];

                    $pending_query = mysqli_query(
                        $conn,
                        "SELECT COUNT(*) as pending
                    FROM orders
                    WHERE status = 'pending'"
                    );

                    $pending = mysqli_fetch_assoc($pending_query)['pending'];
                    ?>

                    <div class="stat-box">
                        Tổng đơn:
                        <strong><?= $total ?></strong>
                    </div>

                    <div class="stat-box unread">
                        Chờ xác nhận:
                        <strong><?= $pending ?></strong>
                    </div>

                </div>

            </div>

            <!-- TABLE -->
            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Sản phẩm</th>

                            <th>Khách hàng</th>

                            <th>SĐT</th>

                            <th>Địa chỉ</th>

                            <th>Số lượng</th>

                            <th>Tổng tiền</th>

                            <th>Trạng thái</th>

                            <th>Ngày đặt</th>

                            <th>Hành động</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($order = mysqli_fetch_assoc($result)): ?>

                            <tr>

                                <td>
                                    #<?= $order['id'] ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= htmlspecialchars($order['product_name']) ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= htmlspecialchars($order['customer_name']) ?>
                                </td>

                                <td>
                                    <a href="tel:<?= $order['phone'] ?>"
                                        class="phone-link">

                                        <?= htmlspecialchars($order['phone']) ?>

                                    </a>
                                </td>

                                <td>
                                    <?= htmlspecialchars($order['address']) ?>
                                </td>

                                <td>
                                    <?= $order['quantity'] ?>
                                </td>

                                <td class="price">
                                    <?= number_format($order['total_price']) ?> VNĐ
                                </td>

                                <td>

                                    <?php if ($order['status'] == 'pending'): ?>

                                        <span class="status pending">
                                            Chờ xác nhận
                                        </span>

                                    <?php elseif ($order['status'] == 'confirmed'): ?>

                                        <span class="status approved">
                                            Đã xác nhận
                                        </span>

                                    <?php else: ?>

                                        <span class="status delivered">
                                            Đã giao
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <?= date(
                                        'd/m/Y',
                                        strtotime($order['created_at'])
                                    ) ?>

                                    <br>

                                    <small style="color:#999;">

                                        <?= date(
                                            'H:i',
                                            strtotime($order['created_at'])
                                        ) ?>

                                    </small>

                                </td>

                                <td class="actions">

                                    <button class="btn view"
                                        onclick="viewOrder(<?= $order['id'] ?>)">

                                        Xem

                                    </button>

                                    <?php if ($order['status'] == 'pending'): ?>

                                        <a href="?id=<?= $order['id'] ?>&status=confirmed"
                                            class="btn edit">

                                            ✓ Xác nhận

                                        </a>

                                    <?php endif; ?>

                                    <?php if ($order['status'] == 'confirmed'): ?>

                                        <a href="?id=<?= $order['id'] ?>&status=delivered"
                                            class="btn done">

                                            Đã giao

                                        </a>

                                    <?php endif; ?>

                                    <a href="?delete=<?= $order['id'] ?>"
                                        class="btn delete"
                                        onclick="return confirm('Bạn có chắc muốn xóa?')">

                                        Xóa

                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </main>

    </div>

    <!-- MODAL -->
    <div id="orderModal" class="modal">

        <div class="modal-content">

            <span class="close"
                onclick="closeModal()">

                &times;

            </span>

            <h2>Chi tiết đơn hàng</h2>

            <div id="modalBody"></div>

        </div>

    </div>

    <script>
        function viewOrder(id) {

            fetch(`get_order.php?id=${id}`)

                .then(response => response.json())

                .then(data => {

                    if (data.success) {

                        const o = data.order;

                        document.getElementById('modalBody').innerHTML = `

                <div class="contact-detail">

                    <div class="detail-row">
                        <strong>Mã đơn:</strong>
                        <span>#${o.id}</span>
                    </div>

                    <div class="detail-row">
                        <strong>Sản phẩm:</strong>
                        <span>${o.product_name}</span>
                    </div>

                    <div class="detail-row">
                        <strong>Khách hàng:</strong>
                        <span>${o.customer_name}</span>
                    </div>

                    <div class="detail-row">
                        <strong>SĐT:</strong>
                        <a href="tel:${o.phone}">
                             ${o.phone}
                        </a>
                    </div>

                    <div class="detail-row">
                        <strong>Địa chỉ:</strong>
                        <span>${o.address}</span>
                    </div>

                    <div class="detail-row">
                        <strong>Số lượng:</strong>
                        <span>${o.quantity}</span>
                    </div>

                    <div class="detail-row">
                        <strong>Tổng tiền:</strong>
                        <span>
                            ${Number(o.total_price).toLocaleString()} VNĐ
                        </span>
                    </div>

                    <div class="detail-row">
                        <strong>Trạng thái:</strong>
                        <span>${o.status}</span>
                    </div>

                </div>

            `;

                        document.getElementById('orderModal').style.display = 'block';
                    }
                });
        }

        function closeModal() {

            document.getElementById('orderModal').style.display = 'none';
        }

        window.onclick = function(event) {

            const modal = document.getElementById('orderModal');

            if (event.target == modal) {

                modal.style.display = 'none';
            }
        }
    </script>

</body>

</html>