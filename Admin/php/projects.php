<?php
session_start();
include '../../config/database.php';

/* XÓA SẢN PHẨM */
if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];

    // Lấy ảnh cũ
    $imgQuery = mysqli_query(
        $conn,
        "SELECT image FROM solar_panels WHERE id = $id"
    );

    $img = mysqli_fetch_assoc($imgQuery);

    if ($img && file_exists("../../images/projects/" . $img['image'])) {

        unlink("../../images/projects/" . $img['image']);
    }

    mysqli_query($conn, "DELETE FROM solar_panels WHERE id = $id");

    header("Location: projects.php");
    exit();
}

/* XỬ LÝ FORM */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $power = $_POST['power'];
    $technology = $_POST['technology'];
    $efficiency = $_POST['efficiency'];
    $warranty = $_POST['warranty'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    /* ==========================
       SỬA SẢN PHẨM
    ========================== */
    if (!empty($_POST['edit_id'])) {

        $id = (int)$_POST['edit_id'];

        // Ảnh cũ
        $oldImgQuery = mysqli_query(
            $conn,
            "SELECT image FROM solar_panels WHERE id = $id"
        );

        $oldImage = mysqli_fetch_assoc($oldImgQuery)['image'];

        $image = $oldImage;

        // Upload ảnh mới
        if (!empty($_FILES['image']['name'])) {

            $targetDir = "../../images/projects/";

            $ext = pathinfo(
                $_FILES['image']['name'],
                PATHINFO_EXTENSION
            );
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array(strtolower($ext), $allowed)) {

                echo "<script>
        alert('Chỉ cho phép ảnh jpg, jpeg, png, webp');
        window.history.back();
    </script>";

                exit();
            }

            $image = time() . "." . $ext;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $targetDir . $image
            );

            // Xóa ảnh cũ
            if ($oldImage && file_exists($targetDir . $oldImage)) {

                unlink($targetDir . $oldImage);
            }
        }

        $sql = "
            UPDATE solar_panels SET
            name=?,
            image=?,
            brand=?,
            power=?,
            technology=?,
            efficiency=?,
            warranty=?,
            size=?,
            price=?,
            category=?,
            description=?
            WHERE id=?
        ";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssi",
            $name,
            $image,
            $brand,
            $power,
            $technology,
            $efficiency,
            $warranty,
            $size,
            $price,
            $category,
            $description,
            $id
        );

        mysqli_stmt_execute($stmt);
    }

    /* ==========================
       THÊM SẢN PHẨM
    ========================== */ else {

        $image = null;

        if (!empty($_FILES['image']['name'])) {

            $targetDir = "../../images/projects/";

            $ext = pathinfo(
                $_FILES['image']['name'],
                PATHINFO_EXTENSION
            );
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array(strtolower($ext), $allowed)) {

                echo "<script>
        alert('Chỉ cho phép ảnh jpg, jpeg, png, webp');
        window.history.back();
    </script>";

                exit();
            }

            $image = time() . "." . $ext;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $targetDir . $image
            );
        }

        $sql = "
            INSERT INTO solar_panels
            (
                name,
                image,
                brand,
                power,
                technology,
                efficiency,
                warranty,
                size,
                price,
                category,
                description
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssss",
            $name,
            $image,
            $brand,
            $power,
            $technology,
            $efficiency,
            $warranty,
            $size,
            $price,
            $category,
            $description
        );

        mysqli_stmt_execute($stmt);
    }

    header("Location: projects.php");
    exit();
}

/* DANH SÁCH SẢN PHẨM */
$result = mysqli_query(
    $conn,
    "SELECT * FROM solar_panels ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>

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

                <h1>Quản lý sản phẩm</h1>

                <button class="btn add"
                    onclick="openModal()">

                    Thêm sản phẩm

                </button>

            </div>

            <!-- TABLE -->
            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>

                            <th>STT</th>

                            <th>Ảnh</th>

                            <th>Tên sản phẩm</th>

                            <th>Hãng</th>

                            <th>Công suất</th>

                            <th>Công nghệ</th>

                            <th>Hiệu suất</th>

                            <th>Giá</th>

                            <th>Danh mục</th>

                            <th>Hành động</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $i = 1;

                        while ($p = mysqli_fetch_assoc($result)):
                        ?>

                            <tr>

                                <td><?= $i++ ?></td>

                                <td>

                                    <?php if ($p['image']): ?>

                                        <img
                                            src="../../images/projects/<?= $p['image'] ?>"
                                            style="
                                        width:80px;
                                        height:60px;
                                        object-fit:cover;
                                        border-radius:6px;
                                    ">

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <strong>
                                        <?= htmlspecialchars($p['name']) ?>
                                    </strong>
                                </td>

                                <td><?= $p['brand'] ?></td>

                                <td><?= $p['power'] ?></td>

                                <td><?= $p['technology'] ?></td>

                                <td><?= $p['efficiency'] ?></td>

                                <td style="color:red;font-weight:bold;">
                                    <?= number_format($p['price']) ?> VNĐ
                                </td>

                                <td>

                                    <span class="badge">

                                        <?= $p['category'] ?>

                                    </span>

                                </td>

                                <td>

                                    <button
                                        class="btn edit"
                                        onclick='openEditModal(<?= json_encode($p) ?>)'>

                                        Sửa

                                    </button>

                                    <a
                                        href="?delete=<?= $p['id'] ?>"
                                        class="btn delete"
                                        onclick="return confirm('Xóa sản phẩm này?')">

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

    <!-- MODAL THÊM -->
    <div class="modal" id="productModal">

        <div class="modal-content large">

            <span class="close"
                onclick="closeModal()">

                &times;

            </span>

            <h2> Thêm sản phẩm</h2>

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Hãng</label>
                    <input type="text" name="brand">
                </div>

                <div class="form-group">
                    <label>Công suất</label>
                    <input type="text" name="power">
                </div>

                <div class="form-group">
                    <label>Công nghệ</label>
                    <input type="text" name="technology">
                </div>

                <div class="form-group">
                    <label>Hiệu suất</label>
                    <input type="text" name="efficiency">
                </div>

                <div class="form-group">
                    <label>Bảo hành</label>
                    <input type="text" name="warranty">
                </div>

                <div class="form-group">
                    <label>Kích thước</label>
                    <input type="text" name="size">
                </div>

                <div class="form-group">
                    <label>Giá</label>
                    <input type="number" name="price">
                </div>

                <div class="form-group">
                    <label>Danh mục</label>

                    <select name="category">

                        <option value="mono">Mono</option>

                        <option value="poly">Poly</option>

                        <option value="premium">Premium</option>

                    </select>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description"></textarea>
                </div>

                <div class="form-group">
                    <label>Ảnh sản phẩm</label>
                    <input type="file" name="image">
                </div>

                <div class="form-actions">

                    <button type="button"
                        class="btn cancel"
                        onclick="closeModal()">

                        Hủy

                    </button>

                    <button class="btn save">

                        Lưu sản phẩm

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- MODAL SỬA -->
    <div class="modal" id="editModal">

        <div class="modal-content large">

            <span class="close"
                onclick="closeEditModal()">

                &times;

            </span>

            <h2> Sửa sản phẩm</h2>

            <form method="POST" enctype="multipart/form-data">

                <input type="hidden"
                    name="edit_id"
                    id="edit_id">

                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" id="edit_name">
                </div>

                <div class="form-group">
                    <label>Hãng</label>
                    <input type="text" name="brand" id="edit_brand">
                </div>

                <div class="form-group">
                    <label>Công suất</label>
                    <input type="text" name="power" id="edit_power">
                </div>

                <div class="form-group">
                    <label>Công nghệ</label>
                    <input type="text" name="technology" id="edit_technology">
                </div>

                <div class="form-group">
                    <label>Hiệu suất</label>
                    <input type="text" name="efficiency" id="edit_efficiency">
                </div>

                <div class="form-group">
                    <label>Bảo hành</label>
                    <input type="text" name="warranty" id="edit_warranty">
                </div>

                <div class="form-group">
                    <label>Kích thước</label>
                    <input type="text" name="size" id="edit_size">
                </div>

                <div class="form-group">
                    <label>Giá</label>
                    <input type="number" name="price" id="edit_price">
                </div>

                <div class="form-group">
                    <label>Danh mục</label>

                    <select name="category" id="edit_category">

                        <option value="mono">Mono</option>

                        <option value="poly">Poly</option>

                        <option value="premium">Premium</option>

                    </select>

                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description"
                        id="edit_description"></textarea>
                </div>

                <div class="form-group">
                    <label>Ảnh mới</label>
                    <input type="file" name="image">
                </div>

                <div class="form-actions">

                    <button type="button"
                        class="btn cancel"
                        onclick="closeEditModal()">

                        Hủy

                    </button>

                    <button class="btn save">

                        Cập nhật

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        function openModal() {

            document.getElementById('productModal').style.display = 'flex';
        }

        function closeModal() {

            document.getElementById('productModal').style.display = 'none';
        }

        function openEditModal(p) {

            document.getElementById('editModal').style.display = 'flex';

            document.getElementById('edit_id').value = p.id;
            document.getElementById('edit_name').value = p.name;
            document.getElementById('edit_brand').value = p.brand;
            document.getElementById('edit_power').value = p.power;
            document.getElementById('edit_technology').value = p.technology;
            document.getElementById('edit_efficiency').value = p.efficiency;
            document.getElementById('edit_warranty').value = p.warranty;
            document.getElementById('edit_size').value = p.size;
            document.getElementById('edit_price').value = p.price;
            document.getElementById('edit_category').value = p.category;
            document.getElementById('edit_description').value = p.description;
        }

        function closeEditModal() {

            document.getElementById('editModal').style.display = 'none';
        }
    </script>

</body>

</html>