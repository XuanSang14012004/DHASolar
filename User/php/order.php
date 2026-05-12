<?php
include '../../config/database.php';
include 'includes/header.php';

$id = $_GET['id'];

$sql = "SELECT * FROM solar_panels WHERE id = $id";
$result = mysqli_query($conn, $sql);

$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $quantity = $_POST['quantity'];

    $total = $product['price'] * $quantity;

    $insert = "
        INSERT INTO orders
        (
            product_id,
            customer_name,
            phone,
            address,
            quantity,
            total_price
        )
        VALUES
        (
            '$id',
            '$name',
            '$phone',
            '$address',
            '$quantity',
            '$total'
        )
    ";

    mysqli_query($conn, $insert);

    echo "
        <script>
            alert('Đặt hàng thành công!');
            window.location='project.php';
        </script>
    ";
}
?>

<div class="container" style="padding: 50px 0;">

    <div class="order-box">

        <div class="order-image">
            <img src="../../images/projects/<?= $product['image'] ?>">
        </div>

        <div class="order-info">

            <h2><?= $product['name'] ?></h2>

            <p>
                <b>Thương hiệu:</b>
                <?= $product['brand'] ?>
            </p>

            <p>
                <b>Công suất:</b>
                <?= $product['power'] ?>
            </p>

            <p>
                <b>Giá:</b>
                <?= number_format($product['price']) ?> VNĐ
            </p>

            <form method="POST">

                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" required>
                </div>

                <div class="form-group">
                    <label>Địa chỉ</label>
                    <textarea name="address" required></textarea>
                </div>
                <div class="form-group">
                    <label>Số lượng</label>
                    <input type="number"
                        name="quantity"
                        min="1"
                        value="1"
                        required>
                </div>

                <button type="submit" class="btn-order">
                    Xác nhận đặt hàng
                </button>

            </form>

        </div>

    </div>

</div>

<style>
    .order-box {
        display: flex;
        gap: 40px;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .order-image img {
        width: 400px;
        border-radius: 12px;
    }

    .order-info {
        flex: 1;
    }

    .form-group {
        margin-top: 15px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .btn-order {
        margin-top: 20px;
        padding: 12px 25px;
        border: none;
        background: #16a34a;
        color: #fff;
        border-radius: 8px;
        cursor: pointer;
    }
</style>

<?php include 'includes/footer.php'; ?>