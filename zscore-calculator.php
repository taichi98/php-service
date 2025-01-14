<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // URL của máy chủ Python
    $url = "https://python001.up.railway.app/zscore-calculator";

    // Dữ liệu gửi lên máy chủ Python
    $data = array(
        "sex" => $_POST['sex'],
        "ageInDays" => $_POST['ageInDays'],
        "height" => $_POST['height'],
        "weight" => $_POST['weight'],
        "measure" => $_POST['measure']
    );

    // Chuyển đổi dữ liệu sang JSON
    $data_json = json_encode($data);

    // Khởi tạo cURL
    $ch = curl_init();

    // Cấu hình cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Nhận phản hồi từ server
    curl_setopt($ch, CURLOPT_POST, true);           // Thiết lập phương thức POST
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(     // Thiết lập header
        "Content-Type: application/json",
        "Content-Length: " . strlen($data_json)
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json); // Gửi dữ liệu JSON

    // Gửi yêu cầu cURL và nhận phản hồi
    $response = curl_exec($ch);

    // Kiểm tra lỗi
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        // Kiểm tra mã trạng thái HTTP
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code === 200) {
            // Phản hồi thành công
            $result = json_decode($response, true); // Giải mã JSON
        } else {
            // Lỗi từ phía máy chủ
            echo "HTTP Error: " . $http_code . "<br>";
            echo "Response: " . $response;
        }
    }
    // Đóng cURL
    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <?php include 'sidebar.php'; ?>
    <div id="main">
        <div class="calculation-box">
            <h2 class="compact-title">WHO Z-Score Tool</h2>
            <form id="zscore-form" method="POST" action="">
                <div id="gender-select-group" class="gender-group">
                    <label for="gender">Sex:</label>
                    <select name="sex" id="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="container_date_input">
                    <label for="age-days">Age in Days:</label>
                    <input type="number" id="age-days" name="ageInDays" required min="0" placeholder="Enter age in days">
                </div>

                <div id="height-select-group" class="height-group">
                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" name="height" required min="0" step="0.1">
                </div>

                <div id="weight-select-group" class="weight-group">
                    <label for="weight">Weight (kg):</label>
                    <input type="number" id="weight" name="weight" required min="0" step="0.1">
                </div>

                <label for="measured">Measured:</label>
                <select name="measure" id="measured" required>
                    <option value="h">Standing</option>
                    <option value="l">Recumbent</option>
                </select>

                <button type="submit">Calculate</button>
            </form>
        </div>

        <?php if (!empty($result)) : ?>
        <div id="result-container">
            <div id="bmi-chart" class="plot-container"></div>
            <div id="wfa-chart" class="plot-container"></div>
            <div id="lhfa-chart" class="plot-container"></div>
            <div id="wflh-chart" class="plot-container"></div>
        </div>
        <script>
            // Parse data from PHP
            const resultData = <?php echo json_encode($result); ?>;

            // BMI Chart
            Plotly.newPlot(
                'bmi-chart',
                JSON.parse(resultData.charts.bmi.zscore.data).data,
                JSON.parse(resultData.charts.bmi.zscore.data).layout,
                JSON.parse(resultData.charts.bmi.zscore.config)
            );

            // WFA Chart
            Plotly.newPlot(
                'wfa-chart',
                JSON.parse(resultData.charts.wfa.zscore.data).data,
                JSON.parse(resultData.charts.wfa.zscore.data).layout,
                JSON.parse(resultData.charts.wfa.zscore.config)
            );

            // LHFA Chart
            Plotly.newPlot(
                'lhfa-chart',
                JSON.parse(resultData.charts.lhfa.zscore.data).data,
                JSON.parse(resultData.charts.lhfa.zscore.data).layout,
                JSON.parse(resultData.charts.lhfa.zscore.config)
            );

            // WFLH Chart
            if (resultData.charts.wflh.zscore) {
                Plotly.newPlot(
                    'wflh-chart',
                    JSON.parse(resultData.charts.wflh.zscore.data).data,
                    JSON.parse(resultData.charts.wflh.zscore.data).layout,
                    JSON.parse(resultData.charts.wflh.zscore.config)
                );
            }
        </script>
        <?php endif; ?>
    </div>
</body>
</html>
