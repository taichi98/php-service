<?php
// URL của Python API
$api_url = "https://python001.up.railway.app/zscore-calculator";

// Dữ liệu test để gửi tới API
$test_payload = [
    "sex" => "male",              // Giới tính
    "ageInDays" => 721,           // Tuổi tính bằng ngày
    "height" => 85.5,             // Chiều cao (cm)
    "weight" => 12.4,             // Cân nặng (kg)
    "measure" => "h",             // Loại đo: Standing (h) hoặc Recumbent (l)
];

// Mã hóa dữ liệu thành JSON
$payload = json_encode($test_payload);

// Bắt đầu gửi yêu cầu bằng cURL
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Nhận phản hồi dưới dạng chuỗi
curl_setopt($ch, CURLOPT_POST, true);           // Sử dụng phương thức POST
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",          // Định dạng JSON
    "Content-Length: " . strlen($payload),     // Độ dài nội dung
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Gửi dữ liệu JSON

// Thực thi yêu cầu
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch); // Kiểm tra lỗi cURL (nếu có)
curl_close($ch);

// Kiểm tra phản hồi
if ($http_code === 200) {
    // Kết nối thành công, xử lý phản hồi
    $response_data = json_decode($response, true);
    echo "<h2>Response from Python API:</h2>";
    echo "<pre>";
    print_r($response_data);
    echo "</pre>";
} else {
    // Lỗi kết nối hoặc phản hồi không thành công
    echo "<h2>Connection Failed</h2>";
    echo "<p>HTTP Code: $http_code</p>";
    if ($curl_error) {
        echo "<p>cURL Error: $curl_error</p>";
    }
    echo "<p>Response:</p>";
    echo "<pre>";
    print_r($response);
    echo "</pre>";
}
?>
