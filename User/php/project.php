<?php
include '../../config/database.php';
include 'includes/header.php';
?>

<div class="title-pj">
    <h1>Dự án đã thực hiện</h1>
    <p>
        Những dự án điện mặt trời tiêu biểu chúng tôi đã triển khai thành công
        tại Hà Nội và các tỉnh lân cận
    </p>
</div>

<div class="container">

    <!-- FILTER -->
    <div class="project-content">
        <div class="project-filter">
            <a href="#" class="active" data-filter="all">Tất cả dự án</a>
            <a href="#" data-filter="home">Hộ gia đình</a>
            <a href="#" data-filter="business">Thương mại & Công nghiệp</a>
        </div>
    </div>

    <hr>

    <!-- PROJECT LIST -->
    <div class="project-list">

        <?php
        $sql = "SELECT * FROM projects ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="project-item <?= $row['category'] ?>">
                <img src="../../<?= $row['image'] ?>" alt="<?= $row['title'] ?>">

                <div class="project-info">
                    <div class="tags">
                        <span class="tag green"><?= $row['tag'] ?></span>
                        <span class="tag blue"><?= $row['power'] ?></span>
                    </div>

                    <h3><?= $row['title'] ?></h3>

                    <p class="location">📍 <?= $row['location'] ?></p>
                    <p class="desc"><?= $row['description'] ?></p>

                    <hr>

                    <ul class="spec">
                        <li>⚡ <b>Tấm pin:</b> <?= $row['panel'] ?></li>
                        <li>🔌 <b>Inverter:</b> <?= $row['inverter'] ?></li>
                        <li>💰 <b>Tiết kiệm:</b> <?= $row['saving'] ?></li>
                    </ul>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
const filterBtns = document.querySelectorAll('.project-filter a');
const projects = document.querySelectorAll('.project-item');

filterBtns.forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault();

        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.dataset.filter;

        projects.forEach(item => {
            if (filter === 'all') {
                item.style.display = 'block';
            } else {
                item.style.display = item.classList.contains(filter)
                    ? 'block'
                    : 'none';
            }
        });
    });
});
</script>
