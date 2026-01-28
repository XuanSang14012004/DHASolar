<?php
include '../../config/database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $query = "SELECT * FROM contacts WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($contact = mysqli_fetch_assoc($result)) {
        // Đánh dấu đã đọc
        mysqli_query($conn, "UPDATE contacts SET status = 'Đã đọc' WHERE id = $id");
        
        // Format ngày
        $contact['created_at'] = date('d/m/Y H:i:s', strtotime($contact['created_at']));
        
        echo json_encode([
            'success' => true,
            'contact' => $contact
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Không tìm thấy liên hệ'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu ID'
    ]);
}
?>