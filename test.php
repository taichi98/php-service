<?php
// File: test_connection.php

// Địa chỉ của container Python
$python_service_url = "https://python001.up.railway.app/zscore-calculator";

// Dữ liệu mẫu gửi tới API Python
$data = [
    'sex' => 'male',  // Nam hoặc nữ
    'ageInDays' => 365, // Số ngày tuổi
    'height' => 75.5, // Chiều cao (cm)
    'weight' => 8.2,  // Cân nặng (kg)
    'measure' => 'h'  // Đơn vị đo
];

// Chuyển đổi dữ liệu thành JSON
$json_data = json_encode($data);

// Cấu hình cURL
$ch = curl_init($python_service_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json_data)
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

// Gửi yêu cầu đến Python API
$response = curl_exec($ch);

// Kiểm tra lỗi cURL
if ($response === false) {
    die("CURL Error: " . curl_error($ch));
}

// Giải phóng tài nguyên
curl_close($ch);

// Hiển thị kết quả từ Python API
header('Content-Type: application/json');
echo $response;
?>
