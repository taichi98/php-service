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

// Lấy dữ liệu biểu đồ từ JSON phản hồi
$bmi_chart_data = json_encode($response_data['data']['data']);
$bmi_chart_layout = json_encode($response_data['data']['layout']);
$bmi_chart_config = json_encode($response_data['config']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Biểu đồ BMI Z-Score</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
    <h3>Kết quả Z-Score</h3>
    <pre><?php print_r($response_data); ?></pre>

    <h2>Biểu đồ BMI Z-Score</h2>
    <div id="bmi-chart" style="width: 100%; height: 500px;"></div>

    <script>
        // Hiển thị biểu đồ sử dụng Plotly
        var chartData = <?php echo $bmi_chart_data; ?>;
        var chartLayout = <?php echo $bmi_chart_layout; ?>;
        var chartConfig = <?php echo $bmi_chart_config; ?>;
        Plotly.newPlot('bmi-chart', chartData, chartLayout, chartConfig);
    </script>
</body>
</html>
