<?php
include '../../config/database.php';
include 'includes/header.php';

// Kiểm tra ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Sản phẩm không tồn tại!");
}

$id = (int)$_GET['id'];

// Lấy thông tin sản phẩm
$sql = "SELECT * FROM solar_panels WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Không tìm thấy sản phẩm!");
}

$product = mysqli_fetch_assoc($result);
?>

<div class="product-detail">

    <div class="container">

        <div class="detail-box">

            <!-- IMAGE -->
            <div class="detail-image">
                <img src="../../images/projects/<?= $product['image'] ?>"
                    alt="<?= $product['name'] ?>">
            </div>

            <!-- INFO -->
            <div class="detail-info">

                <div class="detail-tags">
                    <span class="tag green">
                        <?= $product['brand'] ?>
                    </span>

                    <span class="tag blue">
                        <?= $product['power'] ?>
                    </span>
                </div>

                <h1><?= $product['name'] ?></h1>

                <p class="price">
                    <?= number_format($product['price']) ?> VNĐ
                </p>

                <p class="desc">
                    <?= $product['description'] ?>
                </p>

                <hr>

                <ul class="spec-list">

                    <li>
                        ☀️ <b>Công nghệ:</b>
                        <?= $product['technology'] ?>
                    </li>

                    <li>
                        ⚡ <b>Hiệu suất:</b>
                        <?= $product['efficiency'] ?>
                    </li>

                    <li>
                        🔋 <b>Bảo hành:</b>
                        <?= $product['warranty'] ?>
                    </li>

                    <li>
                        📏 <b>Kích thước:</b>
                        <?= $product['size'] ?>
                    </li>

                </ul>

                <div class="detail-btn">

                    <a href="order.php?id=<?= $product['id'] ?>"
                        class="btn-buy">
                        Đặt hàng ngay
                    </a>

                    <a href="tel:0123456789"
                        class="btn-phone">
                        Gọi tư vấn
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
.product-detail{
    padding: 60px 0;
    background: #f8fafc;
}

.detail-box{
    display: flex;
    gap: 40px;
    background: #fff;
    padding: 35px;
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.detail-image{
    flex: 1;
}

.detail-image img{
    width: 100%;
    border-radius: 14px;
    object-fit: cover;
}

.detail-info{
    flex: 1;
}

.detail-tags{
    margin-bottom: 15px;
}

.tag{
    padding: 6px 14px;
    border-radius: 20px;
    color: #fff;
    font-size: 13px;
    margin-right: 10px;
}

.green{
    background: #16a34a;
}

.blue{
    background: #2563eb;
}

.detail-info h1{
    font-size: 34px;
    margin-bottom: 18px;
    color: #0f172a;
}

.price{
    font-size: 30px;
    font-weight: bold;
    color: #dc2626;
    margin-bottom: 20px;
}

.desc{
    line-height: 1.8;
    color: #475569;
    margin-bottom: 20px;
}

.spec-list{
    list-style: none;
    padding: 0;
}

.spec-list li{
    margin-bottom: 14px;
    font-size: 16px;
    color: #334155;
}

.detail-btn{
    margin-top: 30px;
    display: flex;
    gap: 15px;
}

.btn-buy,
.btn-phone{
    padding: 14px 28px;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s;
    font-weight: 600;
}

.btn-buy{
    background: #16a34a;
    color: #fff;
}

.btn-buy:hover{
    background: #15803d;
}

.btn-phone{
    border: 1px solid #2563eb;
    color: #2563eb;
}

.btn-phone:hover{
    background: #2563eb;
    color: #fff;
}

@media(max-width: 900px){

    .detail-box{
        flex-direction: column;
    }

}
</style>

<?php include 'includes/footer.php'; ?>