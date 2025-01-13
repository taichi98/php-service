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

// Gửi dữ liệu biểu đồ ra phía client
$data_charts = json_encode($response_data['data']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biểu đồ Z-Score</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <style>
        .chart-container {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Kết quả Z-Score</h1>
    <div>
        <label for="chart-type-selector">Loại biểu đồ:</label>
        <select id="chart-type-selector" onchange="updateChartsBasedOnSelection()">
            <option value="zscore">Z-Score</option>
            <option value="percentile">Percentile</option>
        </select>
    </div>
    
    <div id="bmi-chart" class="chart-container"></div>
    <div id="wfa-chart" class="chart-container"></div>
    <div id="lhfa-chart" class="chart-container"></div>
    <div id="wflh-chart" class="chart-container"></div>

    <script>
        const data = {
            charts: <?php echo $data_charts; ?>
        };

        function updateChartsBasedOnSelection() {
            const selectedType = document.getElementById("chart-type-selector").value;

            const chartMappings = [
                { key: "bmi", id: "bmi-chart" },
                { key: "wfa", id: "wfa-chart" },
                { key: "lhfa", id: "lhfa-chart" },
                { key: "wflh", id: "wflh-chart" },
            ];

            const aspectRatio = 4 / 3;

            chartMappings.forEach((chart) => {
                const chartContainer = document.getElementById(chart.id);

                if (data.charts[chart.key] && chartContainer) {
                    const chartData = data.charts[chart.key][selectedType];
                    if (chartData && chartData.data) {
                        try {
                            Plotly.purge(chart.id);

                            const parsedData = JSON.parse(chartData.data);

                            const chartWidth = chartContainer.offsetWidth;
                            const chartHeight = chartWidth / aspectRatio;

                            // Gán dữ liệu vào container để dùng khi resize
                            chartContainer.data = parsedData.data;
                            chartContainer.layout = {
                                ...parsedData.layout,
                                autosize: true,
                                height: chartHeight,
                                margin: { l: 10, r: 10, t: 10, b: 10 },
                                font: {
                                    ...parsedData.layout.font,
                                    size: Math.max(8, chartWidth * 0.02),
                                },
                            };

                            const config = { ...chartData.config, responsive: true };

                            Plotly.newPlot(chart.id, chartContainer.data, chartContainer.layout, config);
                        } catch (error) {
                            console.error(`Lỗi khi cập nhật biểu đồ ${chart.key}:`, error);
                        }
                    }
                }
            });
        }

        // Hiển thị mặc định Z-Score khi tải trang
        document.addEventListener("DOMContentLoaded", () => {
            updateChartsBasedOnSelection();
        });
    </script>
</body>
</html>
