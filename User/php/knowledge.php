<?php
include '../../config/database.php';
include 'includes/header.php';


// Bài nổi bật
$featured = mysqli_query(
    $conn,
    "SELECT * FROM posts WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 1"
);
$featuredPost = mysqli_fetch_assoc($featured);

// Danh sách bài viết
$posts = mysqli_query(
    $conn,
    "SELECT * FROM posts WHERE is_featured = 0 ORDER BY created_at DESC"
);

?>

<div class="title-about">
    <h1>Kiến thức điện mặt trời</h1>
    <p>
        Cập nhật những thông tin mới nhất về điện mặt trời, công nghệ, chính sách và hướng dẫn chi tiết.
    </p>
</div>
<div class="container">

    <?php if ($featuredPost): ?>
        <div class="featured-post">
            <div class="featured-post-img">
                <img src="../../images/posts/<?= $featuredPost['image'] ?>" alt="">
            </div>

            <div class="featured-post-content">
                <span class="post-badge">Bài viết nổi bật</span>

                <h2><?= $featuredPost['title'] ?></h2>
                <p class="post-desc"><?= $featuredPost['description'] ?></p>

                <div class="post-meta">
                    <span>📅 <?= date('d/m/Y', strtotime($featuredPost['created_at'])) ?></span>
                    <span>✍️ <?= $featuredPost['author'] ?></span>
                </div>

                <a href="post-detail.php?id=<?= $featuredPost['id'] ?>" class="btn-read">
                    Đọc bài viết →
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="blog-layout">

        <!-- SIDEBAR -->
        <aside class="blog-sidebar">
            <div class="sidebar-box">
                <h3>Danh mục</h3>
                <ul class="category-list" id="categoryFilter">
                    <li><a href="#" data-cat="all">Tất cả</a></li>
                    <li><a href="#" data-cat="Hướng dẫn">Hướng dẫn</a></li>
                    <li><a href="#" data-cat="Chính sách">Chính sách</a></li>
                    <li><a href="#" data-cat="Kiến thức">Kiến thức</a></li>
                    <li><a href="#" data-cat="Doanh nghiệp">Doanh nghiệp</a></li>
                </ul>
            </div>
            <div class="sidebar-box">
                <h3>Công cụ hữu ích</h3>
                <a href="#" class="tool-btn">⚡ Tính tiết kiệm điện</a>
            </div>
        </aside>

        <!-- BLOG CONTENT -->
        <section class="blog-content" id="postList">
            <?php while ($row = mysqli_fetch_assoc($posts)): ?>
                <div class="blog-card image-card" data-category="<?= $row['category'] ?>">
                    <img src="../../images/posts/<?= $row['image'] ?>" alt="">

                    <div class="image-card-content">
                        <span class="blog-tag knowledge"><?= $row['category'] ?></span>
                        <h3><?= $row['title'] ?></h3>

                        <div class="blog-meta">
                            <span>📅 <?= date('d/m/Y', strtotime($row['created_at'])) ?></span>
                            <span>✍️ <?= $row['author'] ?></span>
                        </div>

                        <a href="post-detail.php?id=<?= $row['id'] ?>" class="read-more">
                            Đọc tiếp →
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </section>


    </div>
</div>


<?php include 'includes/footer.php'; ?>
<script>
    // BƯỚC 1: Lấy tất cả các link danh mục
const categoryLinks = document.querySelectorAll('#categoryFilter a');
// Lấy tất cả các thẻ <a> trong phần có id="categoryFilter"

// BƯỚC 2: Lấy tất cả các bài viết
const posts = document.querySelectorAll('.blog-card');
// Lấy tất cả các thẻ có class="blog-card"

// BƯỚC 3: Duyệt qua từng link danh mục
categoryLinks.forEach(link => {
    // Thêm sự kiện click cho mỗi link
    link.addEventListener('click', function (e) {
        
        // BƯỚC 4: Chặn hành động mặc định (không cho trang reload)
        e.preventDefault();

        // BƯỚC 5: Xóa class "active" khỏi TẤT CẢ các link
        categoryLinks.forEach(l => l.classList.remove('active'));
        
        // BƯỚC 6: Thêm class "active" cho link vừa được click
        this.classList.add('active');
        // "this" ở đây là link mà user vừa click

        // BƯỚC 7: Lấy giá trị danh mục từ thuộc tính data-cat
        const cat = this.dataset.cat;
        // Ví dụ: nếu click vào <a data-cat="Hướng dẫn">
        // thì cat = "Hướng dẫn"

        // BƯỚC 8: Duyệt qua từng bài viết để lọc
        posts.forEach(post => {
            // BƯỚC 9: Kiểm tra điều kiện
            if (cat === 'all') {
                // Nếu chọn "Tất cả" → hiện hết
                post.style.display = 'block';
            } else {
                // Nếu chọn danh mục cụ thể
                // So sánh data-category của bài viết với cat
                post.style.display = 
                    post.dataset.category === cat ? 'block' : 'none';
                // Nếu trùng → hiện (block)
                // Nếu không trùng → ẩn (none)
            }
        });
    });
});

// BƯỚC 10: Tự động active "Tất cả" khi load trang
categoryLinks[0].classList.add('active');
</script>