<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet"/>
    <title><?php echo $pageTitle ?? 'ICU Tools'; ?></title>
    <link rel="icon" href="/icon.png" type="image/png">
    <link rel="stylesheet" href="/style.css" />
    <?php
    // Thêm style riêng cho từng trang
    if (isset($page)) {
        switch ($page) {
            case 'cpap':
                echo '<link rel="stylesheet" href="/cpap.css">';
                break;
            case 'ett':
                echo '<link rel="stylesheet" href="/ett.css">';
                break;
            case 'bmi':
                echo '<link rel="stylesheet" href="/bmi.css">';
                break;
            case 'zscore-calculator':
                echo '<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>';
                echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>';
                echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css"/>';
                echo '<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>';
                break;
        }
    }
    ?>
    <script src="/script.js"></script>
</head>
