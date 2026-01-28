<?php
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("
        INSERT INTO contacts (fullname, phone, email, address, project_type, message)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssssss",
        $_POST['fullname'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['address'],
        $_POST['project_type'],
        $_POST['message']
    );
    $stmt->execute();

    header("Location: contact.php?submitted=1");
exit;

}

include 'includes/header.php';
?>



<div class="title-about">
    <h1>Liên hệ với chúng tôi</h1>
    <p>Hãy để chúng tôi giúp bạn bắt đầu hành trình sử dụng năng lượng sạch.</p>
</div>

<div class="container">
    <div id="notify"></div>
    <div class="contact-head">


        <div class="contact-head-item">
            <span class="contact-icon"><i class="fa-solid fa-phone"></i></span>
            <h3>Điện thoại</h3>
            <p>0123456789</p>
        </div>



        <div class="contact-head-item">
            <span class="contact-icon"><i class="fa-solid fa-envelope"></i></span>
            <h3>Email</h3>
            <p>ABC@gmail.com</p>
        </div>



        <div class="contact-head-item">
            <span class="contact-icon"><i class="fa-solid fa-location-dot"></i></span>
            <h3>Địa chỉ</h3>
            <p>ABC,ABC,ABC,HÀ NỘI</p>
        </div>


        <div class="contact-head-item">
            <span class="contact-icon"><i class="fa-solid fa-clock"></i></span>
            <h3>Giờ làm việc</h3>
            <p>Thứ 2 - 7 | 8:00 - 18:00</p>
        </div>

    </div>




    <div class="contact-section">

        <!-- FORM -->
        <div class="contact-form" id="contactForm">
            <h2>Gửi yêu cầu tư vấn</h2>

            <form method="POST">
                <div class="form-group">
                    <label>Họ và tên *</label>
                    <input type="text" name="fullname" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Số điện thoại *</label>
                        <input type="tel" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email">
                    </div>
                </div>

                <div class="form-group">
                    <label>Địa chỉ dự án</label>
                    <input type="text" name="address">
                </div>

                <div class="form-group">
                    <label>Loại dự án *</label>
                    <select name="project_type" required>
                        <option>Hộ gia đình</option>
                        <option>Doanh nghiệp</option>
                        <option>Nhà xưởng</option>
                        <option>Nông nghiệp</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea rows="4" name="message"></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    Gửi yêu cầu
                </button>
            </form>
        </div>

        <!-- OFFICE -->
        <div class="contact-office">
            <h2>Văn phòng của chúng tôi</h2>

            <div class="office-box">
                <i class="fa-solid fa-location-dot"></i>
                <p>
                    Số 123, Đường ABC<br>
                    Quận Cầu Giấy, Hà Nội
                </p>
                <a href="#" class="map-link">Xem trên Google Maps →</a>
            </div>

            <div class="office-social">
                <h3>Kết nối với chúng tôi</h3>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-solid fa-comment"></i></a>
                    <a href="mailto:example@gmail.com"><i class="fa-brands fa-google"></i></a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);

    if (params.get("submitted") === "1") {
        showToast("✅ Gửi yêu cầu thành công!");

        // xoá param cho sạch URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

function showToast(message) {
    const toast = document.createElement("div");
    toast.innerText = message;

    Object.assign(toast.style, {
        position: "fixed",
        top: "20px",
        left: "20px",
        background: "#2ecc71",
        color: "#fff",
        padding: "12px 18px",
        borderRadius: "8px",
        boxShadow: "0 5px 15px rgba(0,0,0,.3)",
        zIndex: 99999,
        fontSize: "14px"
    });

    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 3000);
}
</script>
