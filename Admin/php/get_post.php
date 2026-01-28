<?php
include '../../config/database.php';

$id = (int)$_GET['id'];
mysqli_query($conn, "UPDATE posts SET views = views + 1 WHERE id = $id");

$q = mysqli_query($conn, "SELECT * FROM posts WHERE id = $id");
echo json_encode(mysqli_fetch_assoc($q));
