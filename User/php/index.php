<?php
include '../../config/database.php';
include 'includes/header.php';
?>

<div class="container">

    <!-- WELCOME -->
    <div class="welcome">
        <div class="welcome-content">
            <h2>Giải pháp điện mặt trời tối ưu cho gia đình & doanh nghiệp tại Miền Bắc</h2>
            <p>Tiết kiệm chi phí - Nâng cao giá trị công trình - Năng lượng bền vững</p>

            <div class="welcome-content-btn">
                <a href="contact.php" class="btn btn-book">Tư vấn miễn phí</a>
                <a href="tel:0123456789" class="btn-price">Báo giá nhanh</a>
            </div>

            <ul class="welcome-content-list">
                <li>Giảm hóa đơn điện đến 70%</li>
                <li>Thi công trọn gói - Bảo hành dài hạn</li>
                <li>Thiết bị chính hãng, hiệu suất cao</li>
            </ul>
        </div>

        <div class="welcome-image">
            <img src="../../images/logo/welcome.jpg" alt="">
        </div>
    </div>

    <!-- SERVICE -->
    <div class="team">
        <div class="warranty">
            <p><i class="fa-solid fa-shield-halved"></i></p>
            <h3>Bảo hành dài hạn</h3>
            <p>Bảo hành thiết bị 10-20 năm, thi công 5 năm</p>
        </div>
        <div class="team-ct">
            <p><i class="fa-solid fa-people-group"></i></p>
            <h3>Đội ngũ chuyên nghiệp</h3>
            <p>Kỹ sư giàu kinh nghiệm, quy trình chuẩn quốc tế</p>
        </div>
        <div class="performance">
            <p><i class="fa-solid fa-bolt-lightning"></i></p>
            <h3>Hiệu xuất cao</h3>
            <p>Thiết bị chính hãng, hiệu suất vượt trội</p>
        </div>

    </div>
    <div class="service">
        <h2>Dịch vụ của chúng tôi</h2>
        <p>Cung cấp giải pháp điện mặt trời toàn diện từ tư vấn, thiết kế đến lắp đặt và bảo trì</p>
        <div class="service-content">
            <div class="service-item">
                <div class="service-icon">🏠</div>
                <h3>Điện mặt trời gia đình</h3>
                <p>Giải pháp tiết kiệm điện năng cho hộ gia đình, giảm hóa đơn điện hàng tháng.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">🏭</div>
                <h3>Điện mặt trời doanh nghiệp</h3>
                <p>Hệ thống công suất lớn cho nhà máy, văn phòng, tòa nhà.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">⚡</div>
                <h3>Hệ thống Hybrid</h3>
                <p>Kết hợp lưới điện và pin lưu trữ, đảm bảo cung cấp điện liên tục.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">🔧</div>
                <h3>Bảo trì & Giám sát</h3>
                <p>Dịch vụ bảo trì định kỳ và giám sát hệ thống từ xa.</p>
            </div>
        </div>

    </div>

    <!-- PROJECT -->
    <div class="project">
        <h2>Sản phẩm tiêu biểu</h2>
        <p>Những sản phẩm bán chạy</p>

        <div class="project-most">
            <?php
            $sql = "SELECT * FROM solar_panels LIMIT 6";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="project-most-item">
                    <img src="../../images/projects/<?= $row['image'] ?>">
                    <h3><?= $row['name'] ?></h3>
                    <ul class="project-most-info">
                        <li>Hãng: <?= $row['brand'] ?></li>
                        <li>Công suất: <?= $row['power'] ?></li>
                        <li>Hiệu suất: <?= $row['efficiency'] ?></li>
                        <li>Công nghệ: <?= $row['technology'] ?></li>
                    </ul>
                </div>
            <?php } ?>
        </div>

        <a href="project.php">Xem tất cả sản phẩm</a>
    </div>

    <!-- REVIEW -->
    <?php
    $reviews = mysqli_query(
        $conn,
        "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 6"
    );
    ?>
    <div class="review">
        <?php while ($r = mysqli_fetch_assoc($reviews)): ?>
            <div class="review-item">
                <div class="stars">
                    <?php
                    for ($i = 1; $i <= $r['stars']; $i++) {
                        echo '⭐';
                    }
                    ?>
                </div>

                <p>"<?= htmlspecialchars($r['content']) ?>"</p>
                <h4><?= htmlspecialchars($r['name']) ?></h4>
                <span><?= htmlspecialchars($r['location']) ?></span>
            </div>
        <?php endwhile; ?>

    </div>
</div>
<?php include 'includes/footer.php'; ?>