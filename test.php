<?php
// Đường dẫn đến Flask API (thay thế bằng URL thực tế trên Railway)
$flaskApiUrl = "https://flask-service.up.railway.app/zscore-calculator";

// Dữ liệu cần gửi tới Flask API
$data = [
    "weight" => 70, // Thay bằng trọng lượng thực tế
    "height" => 175 // Thay bằng chiều cao thực tế
];

// Thiết lập context cho yêu cầu HTTP POST
$options = [
    "http" => [
        "header" => "Content-Type: application/json", // Thiết lập header
        "method" => "POST",
        "content" => json_encode($data), // Chuyển đổi dữ liệu sang JSON
    ],
];

$context = stream_context_create($options);

// Gửi yêu cầu tới Flask API và nhận phản hồi
$response = file_get_contents($flaskApiUrl, false, $context);

// Kiểm tra phản hồi
if ($response === FALSE) {
    echo "Không thể kết nối tới Flask API.";
} else {
    echo "Kết nối thành công! Phản hồi từ Flask API:";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}
?>
