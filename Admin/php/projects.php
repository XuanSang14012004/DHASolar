<?php
session_start();
include '../../config/database.php';

/* XÓA DỰ ÁN */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM projects WHERE id = $id");
    header("Location: projects.php");
    exit();
}
/* CẬP NHẬT DỰ ÁN */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {

    $id = (int)$_POST['edit_id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $tag = $_POST['tag'];
    $power = $_POST['power'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $panel = $_POST['panel'];
    $inverter = $_POST['inverter'];
    $saving = $_POST['saving'];

    $image_sql = "";
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/$image");
        $image_sql = ", image='$image'";
    }

    $sql = "UPDATE projects SET
            title=?,
            category=?,
            tag=?,
            power=?,
            location=?,
            description=?,
            panel=?,
            inverter=?,
            saving=?
            $image_sql
            WHERE id=?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssi",
        $title,
        $category,
        $tag,
        $power,
        $location,
        $description,
        $panel,
        $inverter,
        $saving,
        $id
    );
    mysqli_stmt_execute($stmt);

    header("Location: projects.php");
    exit();
}

/* THÊM DỰ ÁN */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {

    $title = $_POST['title'];
    $category = $_POST['category'];
    $tag = $_POST['tag'];
    $power = $_POST['power'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $panel = $_POST['panel'];
    $inverter = $_POST['inverter'];
    $saving = $_POST['saving'];

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/$image");
    }

    $sql = "INSERT INTO projects 
        (image, title, category, tag, power, location, description, panel, inverter, saving)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssss",
        $image,
        $title,
        $category,
        $tag,
        $power,
        $location,
        $description,
        $panel,
        $inverter,
        $saving
    );
    mysqli_stmt_execute($stmt);

    header("Location: projects.php");
    exit();
}

/* LẤY DANH SÁCH */
$result = mysqli_query($conn, "SELECT * FROM projects ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dự án - Solar Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <div class="admin">
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

        <main class="content">
            <div class="content-header">
                <h1>Quản lý Dự án</h1>
                <button class="btn add" onclick="openModal()">➕ Thêm dự án</button>
            </div>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Loại dự án</th>
                            <th>Công suất</th>
                            <th>Địa điểm</th>
                            <th>Mô tả</th>
                            <th>Số lượng</th>
                            <th>Thông số</th>
                            <th>Tiết kiệm</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($p = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td>
                                    <?php if ($p['image']): ?>
                                        <img src="../../uploads/<?= $p['image'] ?>" class="thumb">
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= htmlspecialchars($p['title']) ?></strong></td>
                                <td>
                                    <span class="badge">
                                        <?= $p['category']  ?>
                                    </span>
                                </td>
                                <td><?= $p['tag'] ?></td>
                                <td><?= $p['power'] ?></td>
                                <td><?= $p['location'] ?></td>
                                <td><?= $p['description'] ?></td>
                                <td><?= $p['panel'] ?></td>
                                <td><?= $p['inverter'] ?></td>
                                <td><?= $p['saving'] ?></td>

                                <td>
                                    <button class="btn edit"
                                        onclick='openEditModal(<?= json_encode($p) ?>)'>
                                        ✏️ Sửa
                                    </button>
                                    <a href="?delete=<?= $p['id'] ?>"
                                        class="btn delete"
                                        onclick="return confirm('Xóa dự án này?')">
                                        🗑 Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <!-- thêm dự án -->
    <div class="modal" id="projectModal">
        <div class="modal-content large">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>➕ Thêm dự án</h2>

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category">
                        <option value="home">Home</option>
                        <option value="business">Business</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tag</label>
                    <select name="tag">
                        <option value="Hộ gia đình">Hộ gia đình</option>
                        <option value="Thương mại">Thương mại</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Công suất</label>
                    <input type="text" name="power" placeholder="VD: 5kWp">
                </div>

                <div class="form-group">
                    <label>Địa điểm</label>
                    <input type="text" name="location">
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label>Pin (Panel)</label>
                    <input type="text" name="panel">
                </div>

                <div class="form-group">
                    <label>Inverter</label>
                    <input type="text" name="inverter">
                </div>

                <div class="form-group">
                    <label>Tiết kiệm</label>
                    <input type="text" name="saving">
                </div>

                <div class="form-group">
                    <label>Ảnh dự án</label>
                    <input type="file" name="image">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn cancel" onclick="closeModal()">Hủy</button>
                    <button class="btn save">💾 Lưu dự án</button>
                </div>

            </form>
        </div>
    </div>
    <!-- Sửa dự án -->
    <div class="modal" id="editModal">
        <div class="modal-content large">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>✏️ Sửa dự án</h2>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" id="edit_id">

                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" id="edit_title" required>
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category" id="edit_category">
                        <option value="home">Hộ gia đình</option>
                        <option value="business">Doanh nghiệp</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tag</label>
                    <input type="text" name="tag" id="edit_tag">
                </div>

                <div class="form-group">
                    <label>Công suất</label>
                    <input type="text" name="power" id="edit_power">
                </div>

                <div class="form-group">
                    <label>Địa điểm</label>
                    <input type="text" name="location" id="edit_location">
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" id="edit_description"></textarea>
                </div>

                <div class="form-group">
                    <label>Pin</label>
                    <input type="text" name="panel" id="edit_panel">
                </div>

                <div class="form-group">
                    <label>Inverter</label>
                    <input type="text" name="inverter" id="edit_inverter">
                </div>

                <div class="form-group">
                    <label>Tiết kiệm</label>
                    <input type="text" name="saving" id="edit_saving">
                </div>

                <div class="form-group">
                    <label>Ảnh mới (nếu muốn đổi)</label>
                    <input type="file" name="image">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn cancel" onclick="closeEditModal()">Hủy</button>
                    <button class="btn save">💾 Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        //xem dự án
        function openModal() {
            document.getElementById('projectModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('projectModal').style.display = 'none';
        }
        window.onclick = e => {
            const m = document.getElementById('projectModal');
            if (e.target === m) m.style.display = 'none';
        }
        //Sửa dựu án

        function openEditModal(p) {
            document.getElementById('editModal').style.display = 'flex';

            document.getElementById('edit_id').value = p.id;
            document.getElementById('edit_title').value = p.title;
            document.getElementById('edit_category').value = p.category;
            document.getElementById('edit_tag').value = p.tag;
            document.getElementById('edit_power').value = p.power;
            document.getElementById('edit_location').value = p.location;
            document.getElementById('edit_description').value = p.description;
            document.getElementById('edit_panel').value = p.panel;
            document.getElementById('edit_inverter').value = p.inverter;
            document.getElementById('edit_saving').value = p.saving;
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>