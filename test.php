<?php
// URL của máy chủ Flask (thay thế bằng địa chỉ và cổng của bạn)
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

// Kiểm tra lỗi phản hồi
if (!$response) {
    die("Không thể kết nối với Flask server.");
}

// Chuyển đổi JSON phản hồi từ Flask thành mảng PHP
$responseData = json_decode($response, true);

// Kiểm tra nếu phản hồi không hợp lệ
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Phản hồi từ Flask không phải JSON hợp lệ: " . json_last_error_msg());
}

// Kiểm tra nếu các khóa cần thiết tồn tại trong phản hồi
if (!isset($responseData['bmi']) || !isset($responseData['charts'])) {
    die("Phản hồi từ Flask thiếu dữ liệu cần thiết.");
}

// Lấy dữ liệu BMI và các biểu đồ
$bmi = $responseData['bmi'];
$bmiAgeZscore = $responseData['bmi_age']['zscore'] ?? 'Không có dữ liệu';
$bmiAgePercentile = $responseData['bmi_age']['percentile'] ?? 'Không có dữ liệu';

$bmiZScoreChart = $responseData['charts']['bmi']['zscore'] ?? null;
$bmiPercentileChart = $responseData['charts']['bmi']['percentile'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả Flask</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
    <h1>Kết quả BMI từ Flask</h1>
    <div>
        <p><strong>BMI:</strong> <?= $bmi ?></p>
        <p><strong>Z-Score:</strong> <?= $bmiAgeZscore ?></p>
        <p><strong>Percentile:</strong> <?= $bmiAgePercentile ?>%</p>
    </div>

    <?php if ($bmiZScoreChart): ?>
        <h2>Biểu đồ BMI Z-Score</h2>
        <div id="bmi-zscore-chart" style="width: 600px; height: 400px;"></div>
    <?php endif; ?>

    <?php if ($bmiPercentileChart): ?>
        <h2>Biểu đồ BMI Percentile</h2>
        <div id="bmi-percentile-chart" style="width: 600px; height: 400px;"></div>
    <?php endif; ?>

    <script>
        <?php if ($bmiZScoreChart): ?>
            const bmiZScoreData = <?= json_encode($bmiZScoreChart['data'] ?? []) ?>;
            const bmiZScoreLayout = <?= json_encode($bmiZScoreChart['config'] ?? []) ?>;
            Plotly.newPlot('bmi-zscore-chart', bmiZScoreData.data, bmiZScoreData.layout, bmiZScoreLayout);
        <?php endif; ?>

        <?php if ($bmiPercentileChart): ?>
            const bmiPercentileData = <?= json_encode($bmiPercentileChart['data'] ?? []) ?>;
            const bmiPercentileLayout = <?= json_encode($bmiPercentileChart['config'] ?? []) ?>;
            Plotly.newPlot('bmi-percentile-chart', bmiPercentileData.data, bmiPercentileData.layout, bmiPercentileLayout);
        <?php endif; ?>
    </script>
</body>
</html>
