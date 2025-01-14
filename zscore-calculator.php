<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = 'https://python001.up.railway.app/zscore-calculator';
    $data = [
        'sex' => $_POST['sex'],
        'ageInDays' => $_POST['ageInDays'],
        'height' => $_POST['height'],
        'weight' => $_POST['weight'],
        'measure' => $_POST['measure']
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        die('Error occurred while fetching data.');
    }

    $result = json_decode($response, true);
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
