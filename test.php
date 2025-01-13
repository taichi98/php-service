<?php
// URL của máy chủ Python
$url = "https://python001.up.railway.app/zscore-calculator";

// Dữ liệu gửi lên máy chủ Python
$data = array(
    "sex" => "male",          // Giới tính: "male" hoặc "female"
    "ageInDays" => 365,       // Tuổi tính theo ngày
    "height" => 75.5,         // Chiều cao (cm)
    "weight" => 8.5,          // Cân nặng (kg)
    "measure" => "h"          // Loại đo: "h" cho chiều cao, "l" cho chiều dài
);

// Chuyển đổi dữ liệu sang JSON
$data_json = json_encode($data);

// Khởi tạo cURL
$ch = curl_init();

// Cấu hình cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Content-Length: " . strlen($data_json)
));
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

// Gửi yêu cầu cURL và nhận phản hồi
$response = curl_exec($ch);

// Kiểm tra lỗi kết nối
if (curl_errno($ch)) {
    echo "Lỗi kết nối: " . curl_error($ch);
    curl_close($ch);
    exit;
}

// Giải mã JSON phản hồi từ máy chủ
$response_data = json_decode($response, true);
curl_close($ch);

// Kiểm tra nếu có lỗi từ server
if (isset($response_data['error'])) {
    echo "Lỗi từ máy chủ Python: " . htmlspecialchars($response_data['error']);
    exit;
}

// Xử lý kết quả biểu đồ
$bmi_chart_data = $response_data[0] ?? null; // Biểu đồ JSON
$bmi_chart_config = $response_data[1] ?? null; // Cấu hình biểu đồ
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biểu đồ BMI Z-Score</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
    <h1>Kết quả Z-Score</h1>
    <pre><?php print_r($response_data); ?></pre>

    <?php if ($bmi_chart_data): ?>
        <h2>Biểu đồ BMI Z-Score</h2>
        <div id="bmi-chart" style="width: 100%; height: 500px;"></div>
        <script>
            var chartData = <?php echo $bmi_chart_data; ?>;
            var config = <?php echo $bmi_chart_config; ?>;
            Plotly.newPlot('bmi-chart', chartData.data, chartData.layout, config);
        </script>
    <?php else: ?>
        <p>Không có dữ liệu biểu đồ BMI.</p>
    <?php endif; ?>
</body>
</html>
