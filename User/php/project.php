<?php
include '../../config/database.php';
include 'includes/header.php';
?>

<div class="title-about">
    <h1>Pin năng lượng mặt trời</h1>
    <p>
        Cung cấp tấm pin năng lượng mặt trời chính hãng,
        hiệu suất cao cho hộ gia đình và doanh nghiệp
    </p>
</div>

<div class="container">

    <!-- FILTER -->
    <div class="project-content">
        <div class="project-filter">
            <a href="#" class="active" data-filter="all">Tất cả</a>
            <a href="#" data-filter="mono">Mono</a>
            <a href="#" data-filter="poly">Poly</a>
            <a href="#" data-filter="premium">Cao cấp</a>
        </div>
    </div>

    <hr>

    <!-- PRODUCT LIST -->
    <div class="project-list">

        <?php
        $sql = "SELECT * FROM solar_panels ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="project-item <?= $row['category'] ?>">

                <img src="../../images/projects/<?= $row['image'] ?>"
                    alt="<?= $row['name'] ?>">

                <div class="project-info">

                    <div class="tags">
                        <span class="tag green">
                            <?= $row['brand'] ?>
                        </span>

                        <span class="tag blue">
                            <?= $row['power'] ?>
                        </span>
                    </div>

                    <h3><?= $row['name'] ?></h3>

                    <p class="location">
                        ⚡ Công nghệ:
                        <?= $row['technology'] ?>
                    </p>

                    <p class="desc">
                        <?= $row['description'] ?>
                    </p>

                    <hr>

                    <ul class="spec">
                        <li>
                            ☀️ <b>Hiệu suất:</b>
                            <?= $row['efficiency'] ?>
                        </li>

                        <li>
                            🔋 <b>Bảo hành:</b>
                            <?= $row['warranty'] ?>
                        </li>

                        <li>
                            📏 <b>Kích thước:</b>
                            <?= $row['size'] ?>
                        </li>

                        <li>
                            💰 <b>Giá:</b>
                            <?= number_format($row['price']) ?> VNĐ
                        </li>
                    </ul>

                    <div class="product-btn">
                        <a href="product-detail.php?id=<?= $row['id'] ?>"
                            class="btn-detail">
                            Xem chi tiết
                        </a>

                        <a href="order.php?id=<?= $row['id'] ?>"
                            class="btn-buy">
                            Đặt hàng
                        </a>
                    </div>

                </div>
            </div>

        <?php } ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
const filterBtns = document.querySelectorAll('.project-filter a');
const products = document.querySelectorAll('.project-item');

filterBtns.forEach(btn => {

    btn.addEventListener('click', e => {

        e.preventDefault();

        filterBtns.forEach(b => {
            b.classList.remove('active');
        });

        btn.classList.add('active');

        const filter = btn.dataset.filter;

        products.forEach(item => {

            if (filter === 'all') {

                item.style.display = 'block';

            } else {

                item.style.display =
                    item.classList.contains(filter)
                    ? 'block'
                    : 'none';
            }
        });
    });
});
</script>

<style>
.title-pj {
    text-align: center;
    padding: 60px 20px;
    background: linear-gradient(to right, #0f172a, #1e3a8a);
    color: white;
}

.title-pj h1 {
    font-size: 42px;
    margin-bottom: 15px;
}

.title-pj p {
    max-width: 700px;
    margin: auto;
    line-height: 1.6;
}

.project-content {
    margin: 40px 0;
    text-align: center;
}

.project-filter {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.project-filter a {
    padding: 10px 20px;
    border-radius: 30px;
    text-decoration: none;
    background: #f1f5f9;
    color: #111827;
    transition: 0.3s;
}

.project-filter a.active,
.project-filter a:hover {
    background: #218f4d;
    color: white;
}

.project-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 25px;
    margin: 40px 0;
}

.project-item {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.project-item:hover {
    transform: translateY(-5px);
}

.project-item img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.project-info {
    padding: 20px;
}

.tags {
    margin-bottom: 15px;
}

.tag {
    padding: 5px 12px;
    border-radius: 20px;
    color: white;
    font-size: 13px;
    margin-right: 8px;
}

.green {
    background: #16a34a;
}

.blue {
    background: #2563eb;
}

.project-info h3 {
    margin-bottom: 12px;
    color: #0f172a;
}

.location {
    margin-bottom: 10px;
    color: #475569;
}

.desc {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 15px;
}

.spec {
    list-style: none;
    padding: 0;
}

.spec li {
    margin-bottom: 10px;
    color: #334155;
}

.product-btn {
    margin-top: 20px;
    display: flex;
    gap: 12px;
}

.btn-detail,
.btn-buy {
    flex: 1;
    text-align: center;
    padding: 12px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-detail {
    border: 1px solid #2563eb;
    color: #2563eb;
}

.btn-detail:hover {
    background: #2563eb;
    color: white;
}

.btn-buy {
    background: #16a34a;
    color: white;
}

.btn-buy:hover {
    background: #15803d;
}
</style>