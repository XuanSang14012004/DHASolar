<?php
$conn = mysqli_connect("localhost", "root", "", "solar_db");

if (!$conn) {
    die("Lỗi kết nối CSDL");
}

mysqli_set_charset($conn, "utf8");
