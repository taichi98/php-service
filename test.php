<?php
// URL của máy chủ Flask
$url = "https://python001.up.railway.app/zscore-calculator";
// Dữ liệu gửi đi
$data = [
    "sex" => "male", // "male" hoặc "female"
    "ageInDays" => 365, // Số ngày tuổi
    "height" => 75.0, // Chiều cao (cm)
    "weight" => 10.0, // Cân nặng (kg)
    "measure" => "h" // "h" (đứng) hoặc "l" (nằm)
];

// Gửi yêu cầu POST với cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded"
]);

$response = curl_exec($ch);
curl_close($ch);

// Kiểm tra lỗi
if (!$response) {
    die("Không thể kết nối với Flask server.");
}

// Chuyển đổi JSON phản hồi từ Flask thành mảng PHP
$responseData = json_decode($response, true);

// Trích xuất dữ liệu biểu đồ từ phản hồi
$bmiZScoreChartData = $responseData['charts']['bmi']['zscore']['data'];
$bmiZScoreChartLayout = $responseData['charts']['bmi']['zscore']['config'];

$bmiPercentileChartData = $responseData['charts']['bmi']['percentile']['data'];
$bmiPercentileChartLayout = $responseData['charts']['bmi']['percentile']['config'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển thị biểu đồ với PHP và Flask</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
    <h1>Kết quả BMI từ Flask</h1>
    <div>
        <p><strong>BMI:</strong> <?= $responseData['bmi'] ?></p>
        <p><strong>Z-Score:</strong> <?= $responseData['bmi_age']['zscore'] ?></p>
        <p><strong>Percentile:</strong> <?= $responseData['bmi_age']['percentile'] ?>%</p>
    </div>

    <h2>Biểu đồ BMI Z-Score</h2>
    <div id="bmi-zscore-chart" style="width: 600px; height: 400px;"></div>

    <h2>Biểu đồ BMI Percentile</h2>
    <div id="bmi-percentile-chart" style="width: 600px; height: 400px;"></div>

    <script>
        // Dữ liệu biểu đồ từ PHP (nhúng JSON trực tiếp vào JavaScript)
        const bmiZScoreData = <?= $bmiZScoreChartData ?>;
        const bmiZScoreLayout = <?= json_encode($bmiZScoreChartLayout) ?>;

        const bmiPercentileData = <?= $bmiPercentileChartData ?>;
        const bmiPercentileLayout = <?= json_encode($bmiPercentileChartLayout) ?>;

        // Vẽ biểu đồ Z-Score
        Plotly.newPlot('bmi-zscore-chart', JSON.parse(bmiZScoreData).data, JSON.parse(bmiZScoreData).layout, bmiZScoreLayout);

        // Vẽ biểu đồ Percentile
        Plotly.newPlot('bmi-percentile-chart', JSON.parse(bmiPercentileData).data, JSON.parse(bmiPercentileData).layout, bmiPercentileLayout);
    </script>
</body>
</html>
