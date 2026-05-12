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
    $delete_query = "DELETE FROM posts WHERE id = $id";
    mysqli_query($conn, $delete_query);
    header('Location: posts.php');
    exit();
}
// Thêm bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && !isset($_POST['edit_id'])) {

    function slugify($str)
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9\-]/', '-', $str);
        $str = preg_replace('/-+/', '-', $str);
        return trim($str, '-');
    }

    $title = $_POST['title'];
    $slug = slugify($title);
    $description = $_POST['description'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $tags = $_POST['tags'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {

        $targetDir = "../../images/posts/";

        // Tạo tên ảnh tránh trùng
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = time() . "." . $ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
    }


    $sql = "INSERT INTO posts 
        (title, slug, description, content, image, category, author, tags, is_featured)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssi",
        $title,
        $slug,
        $description,
        $content,
        $imageName,
        $category,
        $author,
        $tags,
        $is_featured
    );
    mysqli_stmt_execute($stmt);

    header("Location: posts.php");
    exit();
}

// ===== Sửa bài viết =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {

    $id = (int)$_POST['edit_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $author = $_POST['author'];

    // Lấy ảnh cũ
    $oldImage = $conn->query("SELECT image FROM posts WHERE id=$id")
        ->fetch_assoc()['image'];

    $imageName = $oldImage;

    // Nếu upload ảnh mới
    if (!empty($_FILES['image']['name'])) {

        $targetDir = "../../images/posts/";

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = time() . "." . $ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);

        // Xóa ảnh cũ
        if ($oldImage && file_exists($targetDir . $oldImage)) {
            unlink($targetDir . $oldImage);
        }
    }

    $sql = "UPDATE posts 
            SET title=?, description=?, content=?, category=?, author=?, image=?
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssi",
        $title,
        $description,
        $content,
        $category,
        $author,
        $imageName,
        $id
    );

    $stmt->execute();

    header("Location: posts.php");
    exit();
}


// Lấy danh sách liên hệ
$query = "SELECT * FROM posts ORDER BY created_at DESC";
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
    <title>Bài viết - Solar Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <div class="admin">
        <!-- Sidebar -->
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

        <!-- Content -->
        <main class="content">
            <div class="content-header">
                <h1>Quản lý Bài viết</h1>
                <button class="btn add" onclick="openPostModal()">
                     Thêm bài viết
                </button>
            </div>

            <!-- Bọc table trong wrapper -->
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Mô tả</th>
                            <th>Nội dung</th>
                            <th>Ảnh</th>
                            <th>Danh mục</th>
                            <th>Tác giả</th>
                            <th>Ngày đăng</th>
                            <th>Lượt xem</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stt = 1;
                        while ($post = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td><?= $stt++ ?></td>

                                <td>
                                    <strong><?= htmlspecialchars($post['title']) ?></strong>
                                </td>

                                <td class="text-ellipsis" title="<?= htmlspecialchars($post['description']) ?>">
                                    <?= htmlspecialchars($post['description']) ?>
                                </td>

                                <td class="text-ellipsis" title="<?= htmlspecialchars($post['content']) ?>">
                                    <?= htmlspecialchars(strip_tags(substr($post['content'], 0, 100))) ?>...
                                </td>

                                <td>
                                    <?php if ($post['image']): ?>
                                        <img src="../../images/posts/<?= $post['image'] ?>" class="thumb" style="width: 80px;
                                                                                                                height: 60px;
                                                                                                           object-fit: cover;
                                                                                                          border-radius: 6px;">
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>

                                <td><?= htmlspecialchars($post['category']) ?></td>

                                <td><?= htmlspecialchars($post['author']) ?></td>

                                <td><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>

                                <td><?= (int)$post['views'] ?></td>

                                <td>
                                    <button class="btn view" onclick="viewPost(<?= $post['id'] ?>)">👁 Xem</button>
                                    <button class="btn edit" onclick="editPost(<?= $post['id'] ?>)"> Sửa</button>
                                    <a href="?delete=<?= $post['id'] ?>"
                                        class="btn delete"
                                        onclick="return confirm('Xóa bài viết này?')">🗑 Xóa</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
        </main>
    </div>


    <!-- thêm bài viết -->
    <div class="modal" id="postModal">
        <div class="modal-content large">
            <span class="close" onclick="closePostModal()">&times;</span>
            <h2> Thêm bài viết</h2>

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Mô tả </label>
                    <textarea name="description" rows="2"></textarea>
                </div>

                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea name="content" rows="6" required></textarea>
                </div>

                <div class="form-group">
                    <label>Ảnh </label>
                    <input type="file" name="image">
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category" required>
                        <option value="">— Chọn danh mục —</option>
                        <option value="Kiến thức">Kiến thức</option>
                        <option value="Chính sách">Chính sách</option>
                        <option value="Doanh nghiệp">Doanh nghiệp</option>
                        <option value="Hướng dẫn">Hướng dẫn</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tác giả</label>
                    <input type="text" name="author">
                </div>

                <div class="form-group">
                    <label>Tags</label>
                    <input type="text" name="tags">
                </div>

                <label class="checkbox">
                    <input type="checkbox" name="is_featured"> Bài viết nổi bật
                </label>

                <div class="form-actions">
                    <button type="button" class="btn cancel" onclick="closePostModal()">Hủy</button>
                    <button class="btn save"> Lưu bài viết</button>
                </div>

            </form>
        </div>
    </div>
    <!-- xem bài viết -->
    <div class="modal" id="viewModal">
        <div class="modal-content large">
            <span class="close" onclick="closeView()">&times;</span>
            <h2 id="viewTitle"></h2>

            <p class="post-meta">
                <span id="viewCategory"></span> |
                 <span id="viewAuthor"></span> |
                <span id="viewViews"></span> |
                 <span id="viewDate"></span>
            </p>

            <img id="viewImage" class="view-image" style="width: 80px;
                                                                                                                height: 60px;
                                                                                                           object-fit: cover;
                                                                                                          border-radius: 6px;">

            <p id="viewDescription" class="view-desc"></p>

            <div id="viewContent" class="view-content"></div>
        </div>
    </div>
    <!-- Sửa bài viết -->
    <div class="modal" id="editModal">
        <div class="modal-content large">
            <span class="close" onclick="closeEdit()">&times;</span>
            <h2> Sửa bài viết</h2>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" id="edit_id">

                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" id="edit_title" required>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" id="edit_description"></textarea>
                </div>

                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea name="content" id="edit_content" rows="6"></textarea>
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category" id="edit_category">
                        <option value="Kiến thức">Kiến thức</option>
                        <option value="Chính sách">Chính sách</option>
                        <option value="Doanh nghiệp">Doanh nghiệp</option>
                        <option value="Hướng dẫn">Hướng dẫn</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tác giả</label>
                    <input type="text" name="author" id="edit_author">
                </div>
                <div class="form-group">
                    <label>Ảnh</label>
                    <input type="file" name="image">
                </div>


                <div class="form-actions">
                    <button type="button" class="btn cancel" onclick="closeEdit()">Hủy</button>
                    <button class="btn save"> Cập nhật</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // thêm bài viết
        function openPostModal() {
            document.getElementById('postModal').style.display = 'flex';
        }

        function closePostModal() {
            document.getElementById('postModal').style.display = 'none';
        }
        window.onclick = function(e) {
            const modal = document.getElementById('postModal');
            if (e.target === modal) modal.style.display = 'none';
        }
        // xem bài viết
        function viewPost(id) {
            fetch(`get_post.php?id=${id}`)
                .then(res => res.json())
                .then(p => {
                    document.getElementById('viewTitle').innerText = p.title;
                    document.getElementById('viewCategory').innerText = p.category;
                    document.getElementById('viewAuthor').innerText = p.author;
                    document.getElementById('viewViews').innerText = p.views + ' lượt xem';
                    document.getElementById('viewDate').innerText = p.created_at;
                    document.getElementById('viewDescription').innerText = p.description;
                    document.getElementById('viewContent').innerHTML = p.content;

                    if (p.image) {
                        document.getElementById('viewImage').src = '../../images/posts/' + p.image;
                        document.getElementById('viewImage').style.display = 'block';
                    } else {
                        document.getElementById('viewImage').style.display = 'none';
                    }

                    document.getElementById('viewModal').style.display = 'flex';
                });
        }

        function closeView() {
            document.getElementById('viewModal').style.display = 'none';
        }

        function editPost(id) {
            fetch(`get_post.php?id=${id}`)
                .then(res => res.json())
                .then(p => {
                    edit_id.value = p.id;
                    edit_title.value = p.title;
                    edit_description.value = p.description;
                    edit_content.value = p.content;
                    edit_category.value = p.category;
                    edit_author.value = p.author;

                    document.getElementById('editModal').style.display = 'flex';
                });
        }

        function closeEdit() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</body>

</html>