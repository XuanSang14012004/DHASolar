<?php
session_start();
include '../../config/database.php';

// Kiểm tra đăng nhập admin (nếu có)
// if (!isset($_SESSION['admin'])) {
//     header('Location: login.php');
//     exit();
// }

// Xử lý xóa liên hệ
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $delete_query = "DELETE FROM contacts WHERE id = $id";
    mysqli_query($conn, $delete_query);
    header('Location: contacts.php');
    exit();
}

// Xử lý đánh dấu đã đọc
if (isset($_GET['mark_read'])) {
    $id = (int)$_GET['mark_read'];
    $update_query = "UPDATE contacts SET status = 'Đã đọc' WHERE id = $id";
    mysqli_query($conn, $update_query);
    header('Location: contacts.php');
    exit();
}

// Lấy danh sách liên hệ
$query = "SELECT * FROM contacts ORDER BY created_at DESC";
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
    <title>Liên hệ - Solar Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <div class="admin">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>⚡ Solar Admin</h2>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="customers.php">Khách hàng</a></li>
                <li><a href="projects.php">Dự án</a></li>
                <li><a href="quotes.php">Báo giá</a></li>
                <li class="active"><a href="contacts.php">Liên hệ</a></li>
                <li><a href="posts.php">Bài viết</a></li>
            </ul>
        </aside>

        <!-- Content -->
        <main class="content">
            <div class="content-header">
                <h1>Quản lý Liên hệ</h1>
                <div class="header-stats">
                    <?php
                    $total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM contacts");
                    $total = mysqli_fetch_assoc($total_query)['total'];

                    $unread_query = mysqli_query($conn, "SELECT COUNT(*) as unread FROM contacts WHERE status = 'Chưa đọc'");
                    $unread = mysqli_fetch_assoc($unread_query)['unread'];
                    ?>
                    <div class="stat-box">
                        <span>Tổng liên hệ: <strong><?= $total ?></strong></span>
                    </div>
                    <div class="stat-box unread">
                        <span>Chưa đọc: <strong><?= $unread ?></strong></span>
                    </div>
                </div>
            </div>

            <!-- Bọc table trong wrapper -->
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Loại dự án</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ngày gửi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stt = 1;
                        while ($contact = mysqli_fetch_assoc($result)):
                        ?>
                            <tr class="<?= $contact['status'] == 'Chưa đọc' ? 'unread-row' : '' ?>">
                                <td data-label="STT"><?= $stt++ ?></td>
                                <td data-label="Họ tên">
                                    <strong><?= htmlspecialchars($contact['fullname']) ?></strong>
                                </td>
                                <td data-label="SĐT">
                                    <a href="tel:<?= htmlspecialchars($contact['phone']) ?>" class="phone-link">
                                        📞 <?= htmlspecialchars($contact['phone']) ?>
                                    </a>
                                </td>
                                <td data-label="Email">
                                    <a href="mailto:<?= htmlspecialchars($contact['email']) ?>">
                                        <?= htmlspecialchars($contact['email'] ?? 'N/A') ?>
                                    </a>
                                </td>
                                <td data-label="Địa chỉ" title="<?= htmlspecialchars($contact['address'] ?? 'N/A') ?>">
                                    <?= htmlspecialchars($contact['address'] ?? 'N/A') ?>
                                </td>
                                <td data-label="Loại dự án">
                                    <span class="project-badge">
                                        <?= htmlspecialchars($contact['project_type'] ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td data-label="Nội dung" title="<?= htmlspecialchars($contact['message'] ?? '') ?>">
                                    <div class="message-preview">
                                        <?= htmlspecialchars(substr($contact['message'] ?? '', 0, 50)) ?>...
                                    </div>
                                </td>
                                <td data-label="Trạng thái">
                                    <span class="status <?= $contact['status'] == 'Đã đọc' ? 'approved' : 'pending' ?>">
                                        <?= htmlspecialchars($contact['status'] ?? 'Chưa đọc') ?>
                                    </span>
                                </td>
                                <td data-label="Ngày gửi">
                                    <?= date('d/m/Y', strtotime($contact['created_at'])) ?><br>
                                    <small style="color: #999;"><?= date('H:i', strtotime($contact['created_at'])) ?></small>
                                </td>
                                <td data-label="Hành động">
                                    <button class="btn view" onclick="viewContact(<?= $contact['id'] ?>)">
                                        👁️ Xem
                                    </button>
                                    <?php if ($contact['status'] == 'Chưa đọc'): ?>
                                        <a href="?mark_read=<?= $contact['id'] ?>" class="btn edit">
                                            ✓ Đã đọc
                                        </a>
                                    <?php endif; ?>
                                    <a href="?delete=<?= $contact['id'] ?>"
                                        class="btn delete"
                                        onclick="return confirm('Bạn có chắc muốn xóa?')">
                                        🗑️ Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal xem chi tiết -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Chi tiết liên hệ</h2>
            <div id="modalBody"></div>
        </div>
    </div>

    <script>
        function viewContact(id) {
            // Fetch chi tiết liên hệ
            fetch(`get_contact.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const c = data.contact;
                        document.getElementById('modalBody').innerHTML = `
                    <div class="contact-detail">
                        <div class="detail-row">
                            <strong>Họ tên:</strong>
                            <span>${c.fullname}</span>
                        </div>
                        <div class="detail-row">
                            <strong>Số điện thoại:</strong>
                            <a href="tel:${c.phone}" class="phone-link">📞 ${c.phone}</a>
                        </div>
                        <div class="detail-row">
                            <strong>Email:</strong>
                            <a href="mailto:${c.email}">${c.email || 'N/A'}</a>
                        </div>
                        <div class="detail-row">
                            <strong>Địa chỉ:</strong>
                            <span>${c.address || 'N/A'}</span>
                        </div>
                        <div class="detail-row">
                            <strong>Loại dự án:</strong>
                            <span class="project-badge">${c.project_type || 'N/A'}</span>
                        </div>
                        <div class="detail-row full">
                            <strong>Nội dung:</strong>
                            <p class="message-content">${c.message || 'Không có nội dung'}</p>
                        </div>
                        <div class="detail-row">
                            <strong>Ngày gửi:</strong>
                            <span>${c.created_at}</span>
                        </div>
                        <div class="detail-row">
                            <strong>Trạng thái:</strong>
                            <span class="status ${c.status === 'Đã đọc' ? 'approved' : 'pending'}">
                                ${c.status}
                            </span>
                        </div>
                    </div>
                    <div class="modal-actions">
                        <a href="tel:${c.phone}" class="btn-action call">📞 Gọi ngay</a>
                        <a href="mailto:${c.email}" class="btn-action email">✉️ Gửi email</a>
                        ${c.status === 'Chưa đọc' ? 
                            `<a href="?mark_read=${c.id}" class="btn-action mark-read">✓ Đánh dấu đã đọc</a>` 
                            : ''}
                    </div>
                `;
                        document.getElementById('contactModal').style.display = 'block';

                        // Đánh dấu đã đọc tự động
                        if (c.status === 'Chưa đọc') {
                            fetch(`?mark_read=${id}`);
                        }
                    }
                })
                .catch(err => console.error('Error:', err));
        }

        function closeModal() {
            document.getElementById('contactModal').style.display = 'none';
        }

        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            const modal = document.getElementById('contactModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>

</body>

</html>