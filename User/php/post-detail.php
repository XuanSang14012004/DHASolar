<?php
include '../../config/database.php';
include 'includes/header.php';
// Lấy ID bài viết từ URL
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin bài viết
$query = "SELECT * FROM posts WHERE id = $post_id";
$result = mysqli_query($conn, $query);

// Kiểm tra query có thành công không
if (!$result) {
    die("Lỗi SQL: " . mysqli_error($conn));
}

$post = mysqli_fetch_assoc($result);

// Nếu không tìm thấy bài viết
if (!$post) {
    header('Location: blog.php');
    exit();
}

// Lấy bài viết liên quan (cùng danh mục, trừ bài hiện tại)
$related_query = "SELECT * FROM posts 
                  WHERE category = '" . mysqli_real_escape_string($conn, $post['category']) . "' 
                  AND id != $post_id 
                  ORDER BY created_at DESC 
                  LIMIT 3";
$related_posts = mysqli_query($conn, $related_query);

// Kiểm tra query bài viết liên quan
if (!$related_posts) {
    die("Lỗi SQL (related): " . mysqli_error($conn));
}

?>
<link rel="stylesheet" href="post.css">;

<div class="container post-detail-container">
    
    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <a href="../../index.php">Trang chủ</a> / 
        <a href="blog.php">Blog</a> / 
        <span><?= htmlspecialchars($post['title']) ?></span>
    </div>

    <div class="post-detail-layout">
        
        <!-- NỘI DUNG CHÍNH -->
        <article class="post-main-content">
            
            <!-- HEADER BÀI VIẾT -->
            <header class="post-header">
                <span class="post-category-badge"><?= htmlspecialchars($post['category']) ?></span>
                <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>
                
                <div class="post-meta-detail">
                    <div class="meta-item">
                        <span class="icon">📅</span>
                        <span><?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="icon">✍️</span>
                        <span><?= htmlspecialchars($post['author']) ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="icon">👁️</span>
                        <span><?= number_format($post['views'] ?? 0) ?> lượt xem</span>
                    </div>
                </div>
            </header>

            <!-- ẢNH ĐẠI DIỆN -->
            <div class="post-featured-image">
                <img src="../../<?= htmlspecialchars($post['image']) ?>" 
                     alt="<?= htmlspecialchars($post['title']) ?>">
            </div>

            <!-- MÔ TẢ NGẮN -->
            <div class="post-description">
                <p><strong><?= htmlspecialchars($post['description']) ?></strong></p>
            </div>

            <!-- NỘI DUNG BÀI VIẾT -->
            <div class="post-content">
                <?= $post['content'] ?>
            </div>

            <!-- TAGS -->
            <?php if (!empty($post['tags'])): ?>
            <div class="post-tags">
                <span class="tags-label">Từ khóa:</span>
                <?php 
                $tags = explode(',', $post['tags']);
                foreach ($tags as $tag): 
                ?>
                    <a href="#" class="tag-item">#<?= trim(htmlspecialchars($tag)) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- CHIA SẺ -->
            <div class="post-share">
                <h3>Chia sẻ bài viết:</h3>
                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['REQUEST_URI']) ?>" 
                       target="_blank" class="share-btn facebook">
                        📘 Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode($_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($post['title']) ?>" 
                       target="_blank" class="share-btn twitter">
                        🐦 Twitter
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($_SERVER['REQUEST_URI']) ?>" 
                       target="_blank" class="share-btn linkedin">
                        💼 LinkedIn
                    </a>
                    <button onclick="copyLink()" class="share-btn copy">
                        🔗 Sao chép link
                    </button>
                </div>
            </div>

            <!-- BÀI VIẾT LIÊN QUAN -->
            <?php if (mysqli_num_rows($related_posts) > 0): ?>
            <div class="related-posts">
                <h3>Bài viết liên quan</h3>
                <div class="related-posts-grid">
                    <?php while ($related = mysqli_fetch_assoc($related_posts)): ?>
                    <div class="related-card">
                        <a href="post-detail.php?id=<?= $related['id'] ?>">
                            <img src="../../<?= htmlspecialchars($related['image']) ?>" 
                                 alt="<?= htmlspecialchars($related['title']) ?>">
                            <div class="related-card-content">
                                <span class="related-category"><?= htmlspecialchars($related['category']) ?></span>
                                <h4><?= htmlspecialchars($related['title']) ?></h4>
                                <span class="related-date">
                                    📅 <?= date('d/m/Y', strtotime($related['created_at'])) ?>
                                </span>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>

        </article>

        <!-- SIDEBAR -->
        <aside class="post-sidebar">
            
            <!-- TÌM KIẾM -->
            <div class="sidebar-box">
                <h3>Tìm kiếm</h3>
                <form action="search.php" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Tìm kiếm bài viết..." required>
                    <button type="submit">🔍</button>
                </form>
            </div>

            <!-- DANH MỤC -->
            <div class="sidebar-box">
                <h3>Danh mục</h3>
                <ul class="category-list">
                    <li><a href="knowledge.php">Tất cả</a></li>
                    <li><a href="knowledge.php?cat=Hướng dẫn">Hướng dẫn</a></li>
                    <li><a href="knowledge.php?cat=Chính sách">Chính sách</a></li>
                    <li><a href="knowledge.php?cat=Kiến thức">Kiến thức</a></li>
                    <li><a href="knowledge.php?cat=Doanh nghiệp">Doanh nghiệp</a></li>
                </ul>
            </div>

            <!-- BÀI VIẾT PHỔ BIẾN -->
            <div class="sidebar-box">
                <h3>Bài viết phổ biến</h3>
                <?php
                $popular_query = "SELECT * FROM posts ORDER BY views DESC LIMIT 5";
                $popular_posts = mysqli_query($conn, $popular_query);
                
                // Kiểm tra query
                if ($popular_posts && mysqli_num_rows($popular_posts) > 0):
                ?>
                <ul class="popular-posts">
                    <?php while ($popular = mysqli_fetch_assoc($popular_posts)): ?>
                    <li>
                        <a href="post-detail.php?id=<?= $popular['id'] ?>">
                            <img src="../../<?= htmlspecialchars($popular['image']) ?>" 
                                 alt="<?= htmlspecialchars($popular['title']) ?>">
                            <div>
                                <h4><?= htmlspecialchars($popular['title']) ?></h4>
                                <span>📅 <?= date('d/m/Y', strtotime($popular['created_at'])) ?></span>
                            </div>
                        </a>
                    </li>
                    <?php endwhile; ?>
                </ul>
                <?php else: ?>
                    <p>Chưa có bài viết phổ biến</p>
                <?php endif; ?>
            </div>

            <!-- CÔNG CỤ HỮU ÍCH -->
            <div class="sidebar-box">
                <h3>Công cụ hữu ích</h3>
                <a href="#" class="tool-btn">⚡ Tính tiết kiệm điện</a>
                <a href="contact.php" class="tool-btn">📞 Liên hệ tư vấn</a>
            </div>

        </aside>

    </div>
</div>

<script>
// Hàm sao chép link
function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Đã sao chép link bài viết!');
    }).catch(err => {
        console.error('Lỗi:', err);
        alert('Không thể sao chép link');
    });
}

// Cập nhật số lượt xem
fetch('update_views.php?id=<?= $post_id ?>')
    .then(response => response.json())
    .then(data => console.log('Views updated'))
    .catch(err => console.error('Error:', err));
</script>

<?php include 'includes/footer.php'; ?>