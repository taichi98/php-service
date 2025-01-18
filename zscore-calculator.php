<?php
// Hàm gửi dữ liệu POST tới máy chủ Python
function sendDataToPython($data)
{
    $api_url = 'https://python001.up.railway.app/zscore-calculator';
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200) {
        $decodedResponse = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decodedResponse; // Trả về JSON đã giải mã
        } else {
            return ["error" => "Invalid JSON received from API."];
        }
    } else {
        return ["error" => "Failed to connect to Python server or invalid response."];
    }
}

// Xử lý form khi người dùng gửi dữ liệu
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Xóa mọi output trước đó
    ob_end_clean();

    // Đảm bảo chỉ trả về JSON
    header('Content-Type: application/json'); // Đặt header JSON

    $formData = http_build_query([
        'sex' => $_POST['sex'] ?? '',
        'ageInDays' => $_POST['ageInDays'] ?? '',
        'height' => $_POST['height'] ?? '',
        'weight' => $_POST['weight'] ?? '',
        'measure' => $_POST['measure'] ?? '',
    ]);

    $result = sendDataToPython($formData);

    // Luôn trả về JSON, ngay cả khi có lỗi
    echo json_encode($result);
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<body>
    <?php include 'sidebar.php'; ?>
    <div id="main">
        <div class="box-content">
            <h2 class="compact-title">Child Growth Standards</h2>
            <p>
                Monitoring a child's growth is an essential aspect of ensuring their health and well-being. The WHO Child Growth Standards were
                meticulously developed based on comprehensive data collected through the Multicentre Growth Reference Study (MGRS). These standards provide
                a robust foundation for assessing the growth and development of children worldwide, offering benchmarks that are universally
                applicable regardless of geographical or socio-economic factors.
            </p>
            <p>
                This web site presents the WHO Child Growth Standards. These standards
                were developed using data collected in the WHO Multicentre Growth
                Reference Study. The site presents documentation on how the physical
                growth curves and motor milestone windows of achievement were
                developed as well as application tools to support the implementation
                of the standards
            </p>
        </div>

        <div class="container_of_content">
            <div class="result-box-zscore">
                <div class="collapsible-header" onclick="toggleCollapse('collapsible-content', 'arrow-icon')">
                    <img src="https://cdn.glitch.global/94270b80-ba22-42cb-bb07-4670a8f8179e/down.png?v=1737180383881" alt="Arrow Icon" class="arrow-icon" id="arrow-icon"/>
                    <h2 class="compact-title">Growth Chart Results (WHO Standards)</h2>
                </div>
                <div id="no-data-message" class="no-data" style="display: block">No data available</div>

                <div class="collapsible-content" id="collapsible-content" style="visibility: hidden">
                    <h3 style=" display: inline-block; margin-top: -10px; margin-right: 10px;">Show Chart Type:</h3>
                    <select class="dropbtn" id="chart-type-selector" onchange="updateAllCharts()">
                        <option value="zscore">Z-Scores</option>
                        <option value="percentile">Percentile</option>
                    </select>

                    <fieldset id="bfaresult">
                        <legend>BMI Results</legend>
                        <ol>
                            <li class="results">BMI: <span class="scores" id="bmi-result-side"></span></li>
                            <li class="results">Z-Score: <span class="scores" id="bmiage-result-side"></span></li>
                        </ol>
                    </fieldset>
                    <div class="plot-container" id="bmi-chart"></div>

                    <div id="wei-box" style="display: block">
                        <fieldset id="wfaresult">
                            <legend>WFA Results</legend>
                            <ol>
                                <li class="results">
                                    Z-Score: <span class="scores" id="wei-result-side"></span>
                                </li>
                            </ol>
                        </fieldset>
                        <div class="plot-container" id="wfa-chart"></div>
                    </div>

                    <fieldset id="lhfaresult">
                        <legend>LHFA Results</legend>
                        <ol>
                            <li class="results">Z-Score:<span class="scores" id="lenhei_age_result_side"></span></li>
                        </ol>
                    </fieldset>
                    <div class="plot-container" id="lhfa-chart"></div>

                    <div id="wflh-box" style="display: block">
                        <fieldset id="wflhresult">
                            <legend>WFLH Results</legend>
                            <ol>
                                <li class="results">Z-Score:<span class="scores" id="weight_lenhei_result_side"></span>
                                </li>
                            </ol>
                        </fieldset>
                        <div class="plot-container" id="wflh-chart"></div>
                    </div>
                </div>
            </div>

            <div class="calculation-box" style="padding-top: 0px">
                <h2 class="compact-title">WHO Z-Score Tool</h2>
                <form id="zscore-form" method="POST" action="">
                    <!-- Gender -->
                    <div id="gender-select-group" class="gender-group">
                        <label for="gender">Sex</label>
                        <div class="select-group">
                            <button type="button" id="male-btn" onclick="selectGender('male')">Male</button>
                            <button type="button" id="female-btn" onclick="selectGender('female')">Female</button>
                        </div>
                    </div>
                    <input type="hidden" id="gender" name="sex" />
                    <span id="gender-error" style="margin-bottom: 5px; margin-top: -5px; font-size: 12px; color: red; display: none;">
                            Please select a gender.
                    </span>
                    
                    <div class="container_date_input">
                        <div class="age-method-container">
                            <label for="age-option">Age Input Method:</label>
                            <select class="dropbtn" id="age-option" name="age-method" onchange="toggleAgeInput()">
                                <option value="dob" selected>Date of Birth</option>
                                <option value="months">Age in Months</option>
                                <option value="days">Age in Days</option>
                            </select>
                        </div>

                        <!-- Date of Birth Input -->
                        <div id="dob-container" class="input-row">
                            <div id="dob-input" class="field_date_input">
                                <label for="dob">Date of Birth:</label>
                                <input type="date" id="dob" name="dob" placeholder="dd/mm/yyyy" />
                            </div>
                            <div id="current-day-input" class="field_date_input">
                                <label for="current-day">Day of Visit:</label>
                                <input type="date" id="current-day" name="current-day" placeholder="dd/mm/yyyy"/>
                            </div>
                        </div>

                        <!-- Age in Months Input -->
                        <div id="months-input" class="age-months-group" style="display: none;">
                            <label for="age-months">Age in Months:</label>
                            <input type="number" id="age-months" name="age-months" min="0" placeholder="Enter age in months" />
                        </div>

                        <!-- Age in Days Input -->
                        <div id="days-input" class="age-days-group" style="display: none;">
                            <label for="age-days">Age in Days:</label>
                            <input type="number" id="age-days" name="age-days" min="0" placeholder="Enter age in days" />
                        </div>
                    </div>
                    <div id="age-display" style="margin-bottom: 10px; color: red"></div>
                    <span id="dob-error" style="margin-bottom: 5px; margin-top: -15px; font-size: 12px; color: red; display: none;">
                        Please enter Date of Birth.
                    </span>
                    <span id="age-days-error" style="margin-bottom: 5px; margin-top: -15px; font-size: 12px; color: red; display: none;">
                        Please enter the number of days old.
                    </span>
                    <span id="age-months-error" style="margin-bottom: 5px; margin-top: -15px; font-size: 12px; color: red; display: none;">
                            Please enter the age (in months).
                    </span>
                    <!-- Measured -->
                    <label for="measured">Measured:</label>
                    <div class="select-group">
                        <button type="button" id="recumbent-btn" onclick="selectMeasured('l'); autoSubmit()" class="active">Recumbent</button>
                        <button type="button" id="standing-btn" onclick="selectMeasured('h'); autoSubmit()">Standing</button>
                    </div>
                    <input type="hidden" id="measured" name="measure" value="l" />
                    
                    <!-- Height -->
                    <div id="height-select-group" class="height-group">
                        <label for="height">Height (cm):</label>
                        <input type="number"style="width: 100%" id="height" class="height-group" name="height" step="0.1" />
                    </div>
                    <span id="height-error" style="margin-bottom: 5px; margin-top: -5px; font-size: 12px; color: red; display: none;"
                        >Please enter the height</span>
                    
                    <!-- Weight -->
                    <div id="weight-select-group" class="weight-group">
                        <label for="weight">Weight (kg):</label>
                        <input type="number" style="width: 100%" id="weight" name="weight" step="0.1" />
                    </div>
                    <span id="weight-error"
                        style="margin-bottom: 5px;margin-top: -5px;font-size: 12px;color: red;display: none;">Please enter the weight</span>
            
                    <button type="submit">Calculate</button>
                </form>
                <div id="result" class="result-container">
                    <div style="font-size: 1.17em; font-weight: bold; margin-bottom: 8px; padding-left: 5px;">Result:</div>
                    <div id="spinner" style="display: none; text-align: center">
                        <img src="data/spinner.gif" style="width: 100px; height: 100px" />
                    </div>
                    <p id="text1" style="<?php echo isset($result) ? 'display: none;' : 'display: block;'; ?>">
                        Please fill out required fields.
                    </p>                    
                    <div id="resultZS" style="<?php echo isset($result) ? 'display: block;' : 'display: none;'; ?>">
                        <div class="result-item">
                            <p id="bmi-result">
                                <span>BMI: </span>
                                <?php echo $result['bmi'] ?? 'N/A'; ?>
                            </p>
                            <p id="weight_lenhei_result">
                                    <span class="result-title">Weight for Length:</span>
                                    <span class="result-value" id="weight_lenhei_value">
                                        <?php echo $result['wfl']['zscore'] . " (" . $result['wfl']['percentile'] . "th)"; ?>
                                    </span>
                            </p>
                            <p id="wei-result">
                                    <span class="result-title">Weight for Age:</span>
                                    <span class="result-value" id="wei-result_value">
                                        <?php echo $result['wei']['zscore'] . " (" . $result['wei']['percentile'] . "th)"; ?>
                                    </span>
                            </p>
                            <p id="lenhei_age_result">
                                    <span class="result-title">Length for Age:</span>
                                    <span class="result-value" id="lenhei_age_value">
                                        <?php echo $result['lenhei_age']['zscore'] . " (" . $result['lenhei_age']['percentile'] . "th)"; ?>
                                    </span>
                            </p>
                            <p id="bmiage-result">
                                <span>BMI for Age: </span>
                                <?php echo isset($result['bmi_age']['zscore'], $result['bmi_age']['percentile']) 
                                ? $result['bmi_age']['zscore'] . " (" . $result['bmi_age']['percentile'] . "th)" : 'N/A'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <script>
        let data;
        window.addEventListener("resize", resizeCharts); // Gắn sự kiện resize để biểu đồ co dãn
        
        document.addEventListener("DOMContentLoaded", function () {
            initializeMeasured();
            // Lấy ngày hiện tại
            const today = new Date();
            const formattedToday = formatDate(today);
            const selectedOption = document.getElementById("age-option").value;
            
            // Khởi tạo flatpickr cho #current-day
            const currentDayInput = flatpickr("#current-day", {
                dateFormat: "d/m/Y",
                allowInput: true,
                disableMobile: "true",
                onClose: validateManualInput,
                defaultDate: today,
                maxDate: "today",
                locale: {
                    firstDayOfWeek: 1,
                },
            });
            document.getElementById("current-day").value = formattedToday;

            // Khởi tạo flatpickr cho #dob
            const dobInput = flatpickr("#dob", {
                dateFormat: "d/m/Y",
                allowInput: true,
                disableMobile: "true",
                onClose: validateManualInput,
                locale: {
                    firstDayOfWeek: 1,
                },
            });

            // Đặt maxDate cho dobInput bằng giá trị defaultDate của currentDayInput
            dobInput.set("maxDate", currentDayInput.selectedDates[0] || today);

            // Đẩy hàm cập nhật maxDate vào sự kiện onChange của currentDayInput
            currentDayInput.config.onChange.push(() => {dobInput.set("maxDate", currentDayInput.selectedDates[0]);});

            document.querySelector("#dob").setAttribute("autocomplete", "off"); // Vô hiệu hóa tự động điền
            document.querySelector("#current-day").setAttribute("autocomplete", "off");

            // Hàm xử lý khi người dùng nhập tay vào trường input
            function validateManualInput(selectedDates, dateStr, instance) {
                const inputElement = instance.input; // Lấy phần tử input liên kết với flatpickr
                const inputValue = inputElement.value;

                if (isValidDate(inputValue, "d/m/Y")) {
                    instance.setDate(inputValue, true); // Cập nhật flatpickr với giá trị hợp lệ
                } else {
                    inputElement.value = ""; // Xóa giá trị không hợp lệ
                }
            }

            // Hàm kiểm tra định dạng ngày hợp lệ
            function isValidDate(dateStr, format) {
                const [day, month, year] = dateStr.split("/").map(Number);
                if (!day || !month || !year) return false;

                const date = new Date(year, month - 1, day);
                return (
                    date.getFullYear() === year &&
                    date.getMonth() === month - 1 &&
                    date.getDate() === day
                );
            }

            // Hàm định dạng ngày thành chuỗi "dd/mm/yyyy"
            function formatDate(date) {
                const day = String(date.getDate()).padStart(2, "0");
                const month = String(date.getMonth() + 1).padStart(2, "0");
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }
        });
        //=================================================================================================
        
        function updateResultField(resultId, resultSideId, boxId, label, dataKey) {
                const resultElement = document.getElementById(resultId);
                const resultSideElement = document.getElementById(resultSideId);
                const boxElement = document.getElementById(boxId);
                const titleElement = resultElement.querySelector(".result-title");

                if (dataKey) {
                        const zscoreText = `${dataKey.zscore} (${dataKey.percentile}th)`;
                        titleElement.textContent = label;
                        resultElement.querySelector(".result-value").textContent = zscoreText;
                        resultElement.classList.remove("text-gray");
                        titleElement.classList.remove("text-gray");
                        resultSideElement.textContent = zscoreText;
                        boxElement.style.display = "block";
                } else {
                        titleElement.textContent = label;
                        resultElement.querySelector(".result-value").textContent = "N/A";
                        resultElement.classList.add("text-gray");
                        titleElement.classList.add("text-gray");
                        boxElement.style.display = "none";
                }
        }

        // Thêm sự kiện để cập nhật tuổi khi giá trị dob hoặc current-day thay đổi
        document.getElementById("dob").addEventListener("change", updateAgeDisplay);
        document.getElementById("current-day").addEventListener("change", updateAgeDisplay);

        // Cập nhật trạng thái đo khi nhập số tháng
        document.getElementById("age-months").addEventListener("input", function () {
                const ageMonths = parseInt(this.value, 10);
                if (!isNaN(ageMonths)) {
                    updateMeasuredButtons(ageMonths);
                    updateAgeDisplay();
                }
            });

        // Cập nhật trạng thái đo khi nhập số ngày
        document.getElementById("age-days").addEventListener("input", function () {
                const ageDays = parseInt(this.value, 10);
                if (!isNaN(ageDays)) {
                    const ageMonths = Math.floor(ageDays / 30.4375);
                    updateMeasuredButtons(ageMonths);
                }
            });

        // Gọi hàm updateChartsBasedOnSelection() khi có sự thay đổi dropdown
        document.getElementById("chart-type-selector").addEventListener("change", updateChartsBasedOnSelection);
      
        document.getElementById("zscore-form").addEventListener("submit", function (event) {
            event.preventDefault();

            const spinner = document.getElementById("spinner");
            const resultBox = document.getElementById("resultZS");
            const formData = new FormData(this);
            const selectedOption = document.getElementById("age-option").value;
            const weight = document.getElementById("weight").value;
            const height = document.getElementById("height").value;

            let isValid = true;

            const ageInDays = calculateAgeInDaysFromOption(selectedOption);
            const isAbove5Years = ageInDays > 1856; // Điều kiện để kiểm tra nếu trẻ > 5 tuổi

            // Ẩn resultBox và hiển thị spinner
            resultBox.style.display = "none";
            spinner.style.display = "block";

            // Đặt lại các lỗi hiển thị
            const fieldsToValidate = [
              {field: "gender",errorId: "gender-error",groupClass: "gender-group",},
              {field: "height",errorId: "height-error",groupClass: "height-group",},
              {field: "weight",errorId: "weight-error",groupClass: "weight-group",},
            ];

            // Kiểm tra thông tin đầu vào
            fieldsToValidate.forEach(({ field, errorId, groupClass }) => {
              const value = document.getElementById(field).value;
              const errorElement = document.getElementById(errorId);
              const groupElement = document.querySelector(`.${groupClass}`);

              if (!value) {
                isValid = false;
                errorElement.style.display = "block";
                groupElement?.classList.add("error-border");
              } else {
                errorElement.style.display = "none";
                groupElement?.classList.remove("error-border");
              }

              // Kiểm tra giới hạn chiều cao
              if (field === "height" && value) {
                const heightValue = parseFloat(value);

                if (isAbove5Years) {
                  // Với trẻ > 5 tuổi chỉ cần chiều cao tối thiểu 45 cm
                  if (heightValue < 45) {
                    isValid = false;
                    errorElement.style.display = "block";
                    errorElement.textContent = "Please enter a height of at least 45 cm."; // Thông báo lỗi cho trẻ > 5 tuổi
                    groupElement?.classList.add("error-border");
                  } else {
                    errorElement.style.display = "none";
                    groupElement?.classList.remove("error-border");
                  }
                } else {
                  // Với trẻ < 5 tuổi, chiều cao phải nằm trong khoảng 45-120 cm
                  if (heightValue < 45 || heightValue > 120) {
                    isValid = false;
                    errorElement.style.display = "block";
                    errorElement.textContent = "Please enter a height between 45 and 120 cm."; // Thông báo lỗi cho trẻ < 5 tuổi
                    groupElement?.classList.add("error-border");
                  } else {
                    errorElement.style.display = "none";
                    groupElement?.classList.remove("error-border");
                  }
                }
              }
            });

            // Xử lý loại bỏ lỗi ngay khi nhập liệu
            fieldsToValidate.forEach(({ field, errorId, groupClass }) => {
              const inputField = document.getElementById(field);
              const errorElement = document.getElementById(errorId);
              const groupElement = document.querySelector(`.${groupClass}`);

              inputField.addEventListener("input", () => {
                if (inputField.value.trim() !== "") {
                  errorElement.style.display = "none";
                  groupElement?.classList.remove("error-border");
                } else {
                  errorElement.style.display = "block";
                  groupElement?.classList.add("error-border");
                }

                // Loại bỏ lỗi khi nhập liệu cho chiều cao
                if (field === "height") {
                  const heightValue = parseFloat(inputField.value);
                  const isAbove5Years = ageInYears > 5;

                  if (isAbove5Years) {
                    // Với trẻ > 5 tuổi chỉ cần chiều cao tối thiểu 45 cm
                    if (heightValue >= 45) {
                      errorElement.style.display = "none";
                      groupElement?.classList.remove("error-border");
                    } else {
                      errorElement.style.display = "block";
                      errorElement.textContent = "Please enter a height of at least 45 cm."; // Thông báo lỗi
                      groupElement?.classList.add("error-border");
                    }
                  } else {
                    // Với trẻ < 5 tuổi, chiều cao phải nằm trong khoảng 45-120 cm
                    if (heightValue >= 45 && heightValue <= 120) {
                      errorElement.style.display = "none";
                      groupElement?.classList.remove("error-border");
                    } else {
                      errorElement.style.display = "block";
                      errorElement.textContent = "Please enter a height between 45 and 120 cm."; // Thông báo lỗi
                      groupElement?.classList.add("error-border");
                    }
                  }
                }
              });
            });

            // Xử lý loại bỏ lỗi khi chọn ngày sinh (DOB)
            if (selectedOption === "dob") {
              const dob = document.getElementById("dob");
              const currentDay = document.getElementById("current-day");
              const dobErrorElement = document.getElementById("dob-error");
              const dobGroupElement = document.querySelector(".input-row");

              // Kiểm tra ngay khi người dùng nhập hoặc chọn DOB
              [dob, currentDay].forEach((field) => {
                field.addEventListener("change", () => {
                  if (dob.value && currentDay.value) {
                    dobErrorElement.style.display = "none";
                    dobGroupElement?.classList.remove("error-border");
                  }
                });
              });

              if (!dob.value || !currentDay.value) {
                isValid = false;
                dobErrorElement.style.display = "block";
                dobGroupElement?.classList.add("error-border");
              } else {
                dobErrorElement.style.display = "none";
                dobGroupElement?.classList.remove("error-border");
              }
            }

            // Kiểm tra tuổi theo tùy chọn "months" và "days"
            if (selectedOption === "months") {
              const ageMonths = parseInt(document.getElementById("age-months").value,10,);
              const ageMonthsErrorElement = document.getElementById("age-months-error");
              const ageMonthsGroupElement = document.querySelector(".age-months-group");

              const ageMonthsField = document.getElementById("age-months");
              ageMonthsField.addEventListener("input", () => {
                if (!isNaN(ageMonthsField.value) && ageMonthsField.value >= 0) {
                  ageMonthsErrorElement.style.display = "none";
                  ageMonthsGroupElement?.classList.remove("error-border");
                }
              });

              if (isNaN(ageMonths) || ageMonths < 0) {
                isValid = false;
                ageMonthsErrorElement.style.display = "block";
                ageMonthsGroupElement?.classList.add("error-border");
              } else {
                ageMonthsErrorElement.style.display = "none";
                ageMonthsGroupElement?.classList.remove("error-border");
              }
            } else if (selectedOption === "days") {
              const ageDays = parseInt(document.getElementById("age-days").value,10,);
              const ageDaysErrorElement = document.getElementById("age-days-error");
              const ageDaysGroupElement = document.querySelector(".age-days-group");

              const ageDaysField = document.getElementById("age-days");
              ageDaysField.addEventListener("input", () => {
                if (!isNaN(ageDaysField.value) && ageDaysField.value >= 0) {
                  ageDaysErrorElement.style.display = "none";
                  ageDaysGroupElement?.classList.remove("error-border");
                }
              });

              if (isNaN(ageDays) || ageDays < 0) {
                isValid = false;
                ageDaysErrorElement.style.display = "block";
                ageDaysGroupElement?.classList.add("error-border");
              } else {
                ageDaysErrorElement.style.display = "none";
                ageDaysGroupElement?.classList.remove("error-border");
              }
            }

            if (!isValid) {
              spinner.style.display = "none";
              return;
            }

            // Thêm ageInDays vào FormData
            formData.append("ageInDays", ageInDays);

            // Gửi request
            fetch("", {
                method: "POST",
                body: formData,
            })
                .then((response) => {
                    if (!response.ok) throw new Error("Network response was not ok");
                    return response.json();
                })
                .then((responseData) => {
                    data = responseData;
                    spinner.style.display = "none";

                    updateChartsBasedOnSelection();

                    const measured = document.getElementById("measured").value;

                    // Cập nhật các kết quả
                    document.getElementById("bmi-result-side").textContent = `${data.bmi}`;
                    document.getElementById("bmi-result").textContent = `BMI: ${data.bmi}`;
                    document.getElementById("bmiage-result-side").textContent = `${data.bmi_age.zscore} (${data.bmi_age.percentile}th)`;
                    document.getElementById("bmiage-result").textContent = `BMI for Age: ${data.bmi_age.zscore} (${data.bmi_age.percentile}th)`;

                    updateResultField(
                        "weight_lenhei_result",
                        "weight_lenhei_result_side",
                        "wflh-box",
                        measured === "l" ? "Weight for Length:" : "Weight for Height:",
                        data.wfl
                    );

                    updateResultField(
                        "lenhei_age_result",
                        "lenhei_age_result_side",
                        "lhfaresult",
                        measured === "l" ? "Length for Age:" : "Height for Age:",
                        data.lenhei_age
                    );

                    updateResultField(
                        "wei-result",
                        "wei-result-side",
                        "wei-box",
                        "Weight for Age:",
                        data.wei
                    );

                    // Hiển thị resultBox
                    resultBox.style.display = "flex";
                    updateResults(data);
                })
                .catch((error) => {
                    console.error("There was a problem with the fetch operation:", error);
                    alert("Đã xảy ra lỗi khi xử lý yêu cầu.");
                    spinner.style.display = "none";
                    document.getElementById("text1").style.display = "block";
                    data = "";
                    updateResults(data);
                });

            // Ẩn placeholder
            document.getElementById("text1").style.display = "none";
          });

    </script>
  
    //Modal báo lỗi khi nhập quá 19 tuổi
		<div id="custom-alert" class="modal">
			<div class="modal-content">
				<a onclick="closeAlert()" class="link-2"></a>
				<span class="modal-title">MedixTools</span>
				<p id="alert-message"></p>
			</div>
		</div>
</body>
</html>
