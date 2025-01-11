<?php
// Lấy đường dẫn trang từ URL
$page = $_GET['page'] ?? 'cpap';

// Đặt tiêu đề trang dựa trên lựa chọn
switch ($page) {
    case 'cpap':
        $pageTitle = "CPAP Calculator";
        break;
    case 'ett':
        $pageTitle = "ETT Size";
        break;
    case 'ibw':
        $pageTitle = "Ideal Body Weight";
        break;
    case 'zscore-calculator':
        $pageTitle = "WHO Z-Score";
        break;
    case 'bmi':
        $pageTitle = "BMI & BSA Calculator";
        break;
    case 'lightCriteria':
        $pageTitle = "Light's Criteria";
        break;
    default:
        $pageTitle = "Page Not Found";
        $page = '404'; // Trang lỗi
        break;
}

// Chèn header
include 'header.php';

// Kiểm tra và include nội dung tương ứng
switch ($page) {
    case 'cpap':
        include 'cpap.php';
        break;
    case 'ett':
        include 'ett.php';
        break;
    case 'ibw':
        include 'ibw.php';
        break;
    case 'zscore-calculator':
        include 'zscore-calculator.php';
        break;
    case 'bmi':
        include 'bmi.php';
        break;
    case 'lightCriteria':
        include 'lightCriteria.php';
        break;
    default:
        include '404.php'; // Trang lỗi
        break;
}

?>
