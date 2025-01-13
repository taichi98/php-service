<?php
// URL của máy chủ Python
$url = "https://python001.up.railway.app/zscore-calculator";

// Dữ liệu gửi lên máy chủ Python
$data = array(
    "sex" => "male",          // Giới tính: "male" hoặc "female"
    "ageInDays" => 365,       // Tuổi tính theo ngày
    "height" => 75.5,         // Chiều cao (cm)
    "weight" => 8.5,          // Cân nặng (kg)
    "measure" => "h"         // Loại đo: "h" cho chiều cao, "l" cho chiều dài
);

// Chuyển đổi dữ liệu sang định dạng JSON
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

// Kiểm tra lỗi
if (curl_errno($ch)) {
    echo "Lỗi: " . curl_error($ch);
} else {
    // Giải mã JSON phản hồi
    $response_data = json_decode($response, true);

    if (isset($response_data['error'])) {
        echo "Lỗi từ máy chủ Python: " . htmlspecialchars($response_data['error']);
    } else {
        // Hiển thị kết quả
        echo "<h2>Kết quả từ máy chủ Python</h2>";
        echo "<pre>";
        print_r($response_data);
        echo "</pre>";

        // Hiển thị biểu đồ BMI nếu có
        if (isset($response_data['charts']['bmi']['zscore']['data'])) {
            $bmi_chart_data = htmlspecialchars($response_data['charts']['bmi']['zscore']['data']);
            echo "<h3>Biểu đồ BMI Z-Score</h3>";
            echo "<div id='bmi-chart' style='width: 100%; height: 400px;'></div>";
            echo "
            <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
            <script>
                var chartData = $bmi_chart_data;
                Plotly.newPlot('bmi-chart', chartData.data, chartData.layout);
            </script>";
        }

        // Hiển thị biểu đồ WFA nếu có
        if (isset($response_data['charts']['wfa']['zscore']['data'])) {
            $wfa_chart_data = htmlspecialchars($response_data['charts']['wfa']['zscore']['data']);
            echo "<h3>Biểu đồ WFA Z-Score</h3>";
            echo "<div id='wfa-chart' style='width: 100%; height: 400px;'></div>";
            echo "
            <script>
                var chartData = $wfa_chart_data;
                Plotly.newPlot('wfa-chart', chartData.data, chartData.layout);
            </script>";
        }

        // Hiển thị biểu đồ LHFA nếu có
        if (isset($response_data['charts']['lhfa']['zscore']['data'])) {
            $lhfa_chart_data = htmlspecialchars($response_data['charts']['lhfa']['zscore']['data']);
            echo "<h3>Biểu đồ LHFA Z-Score</h3>";
            echo "<div id='lhfa-chart' style='width: 100%; height: 400px;'></div>";
            echo "
            <script>
                var chartData = $lhfa_chart_data;
                Plotly.newPlot('lhfa-chart', chartData.data, chartData.layout);
            </script>";
        }

        // Hiển thị biểu đồ WFLH nếu có
        if (isset($response_data['charts']['wflh']['zscore']['data'])) {
            $wflh_chart_data = htmlspecialchars($response_data['charts']['wflh']['zscore']['data']);
            echo "<h3>Biểu đồ WFLH Z-Score</h3>";
            echo "<div id='wflh-chart' style='width: 100%; height: 400px;'></div>";
            echo "
            <script>
                var chartData = $wflh_chart_data;
                Plotly.newPlot('wflh-chart', chartData.data, chartData.layout);
            </script>";
        }
    }
}

// Đóng kết nối cURL
curl_close($ch);
?>
