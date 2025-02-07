<?php
// Hàm gửi dữ liệu POST tới máy chủ Python
function sendDataToPython($data)
{
    $api_url = 'https://python001.up.railway.app/calculate-eer'; // API EER trên máy chủ Python
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
    // Xóa buffer nếu có
    if (ob_get_level()) {
        ob_end_clean();
    }
    header('Content-Type: application/json');

    $formData = http_build_query([
        'sex' => $_POST['sex'] ?? '',
        'ageInDays' => $_POST['ageInDays'] ?? '',
        'height' => $_POST['height'] ?? '',
        'weight' => $_POST['weight'] ?? '',
        'pal' => $_POST['PAL-value'] ?? '' 
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
    <div class="container_of_content">
        <div class="description-box">
            <h3>Estimated energy requirement</h3>
            <p><strong>Estimated energy requirements</strong> - The National Academy of Medicine published estimated energy requirements (EERs) for children and adolescents.</p>
            <p>EER represents the average requirement for a child of a given sex, age, height, and weight. 
Although these are useful general estimates, marked variability exists in the energy requirements of individuals, 
particularly during adolescence because of variation in growth rates, pubertal timing, and physical activity levels (PALs). 
The extent of variability of the EER can be estimated from the published standard errors</p>
            <p>These EERs also are stratified by the habitual PAL, which is expressed as a multiple of the basal metabolic rate (BMR). 
Although the recommendations allow for four categories of PAL (inactive, low active, active, and very active), the active or very active 
levels are encouraged for all healthy children (ie, at least 60 minutes of physical activity on most, preferably all, days of the week)</p>
            <p><strong>Prediction equations</strong>
             <table border="1" cellpadding="10" cellspacing="0" style="text-align: left;">
              <thead>
                <tr>
                  <th colspan="2" style="text-align: left;">Children with healthy body weight: Use EER</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: left;">Females 1 to 2.99 years:</td>
                  <td style="text-align: left;">EER = -69.15 + (80.0 × age) + (2.65 × height) + (54.15 × weight) + ECG<sup>*</sup></td>
                </tr>
                <tr>
                  <td style="text-align: left;">Females 3 to 18.99 years:</td>
                  <td style="text-align: left;">
                    Inactive: EER = 55.59 - (22.25 × age) + (8.43 × height) + (17.07 × weight) + ECG<sup>*</sup><br>
                    Low active: EER = -297.54 - (22.25 × age) + (12.77 × height) + (14.73 × weight) + ECG<sup>*</sup><br>
                    Active: EER = -189.55 - (22.25 × age) + (11.74 × height) + (18.34 × weight) + ECG<sup>*</sup><br>
                    Very active: EER = -709.59 - (22.25 × age) + (18.22 × height) + (14.25 × weight) + ECG<sup>*</sup>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: left;">Males 1 to 2.99 years:</td>
                  <td style="text-align: left;">EER = -716.45 - (1.00 × age) + (17.82 × height) + (15.06 × weight) + ECG<sup>*</sup></td>
                </tr>
                <tr>
                  <td style="text-align: left;">Males 3 to 18.99 years:</td>
                  <td style="text-align: left;">
                    Inactive: EER = -447.51 + (3.68 × age) + (13.01 × height) + (13.15 × weight) + ECG<sup>*</sup><br>
                    Low active: EER = 19.12 + (3.68 × age) + (8.62 × height) + (20.28 × weight) + ECG<sup>*</sup><br>
                    Active: EER = -388.19 + (3.68 × age) + (12.66 × height) + (20.46 × weight) + ECG<sup>*</sup><br>
                    Very active: EER = -671.75 + (3.68 × age) + (15.38 × height) + (23.25 × weight) + ECG<sup>*</sup>
                  </td>
                </tr>
              </tbody>
            </table>
            <p style="font-size: smaller; font-style: italic;">
            *Throughout this table, age is in years, weight in kilograms (kg), and height in meters (m). 
PALs vary substantially across age groups, particularly during the first 20 years of life. Working definitions are outlined below.</p>
          <p>
            These equations were developed by the National Academy of Medicine for children as a function of age, sex, height, weight, and PAL. 
The estimates are based on total energy expenditure (TEE), as measured by the doubly labeled water (DLW) method, plus an average of 15 to 30 kcal/day 
for the energy cost of growth based on average rates of weight gains and rates of protein and fat deposition for children and adolescents, respectively.
          </p>
        </div>

        <div class="calculation-box" style="padding-top: 0px">
          <h2 class="compact-title">EER Calculator</h2>
          <form id="eer-form" method="POST" action="">
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
                      <option value="months" >Age in Months</option>
                  </select>
              </div>

              <!-- Date of Birth Input -->
              <div id="dob-container" class="input-row">
                  <div id="dob-input" class="field_date_input">
                      <label for="dob">Date of Birth:</label>
                      <input type="date" id="dob" name="dob" placeholder="dd/mm/yyyy" onchange="togglePAL();" />
                  </div>
                  <div id="current-day-input" class="field_date_input">
                      <label for="current-day">Day of Visit:</label>
                      <input type="date" id="current-day" name="current-day" placeholder="dd/mm/yyyy" onchange="togglePAL();" />
                  </div>
              </div>

              <!-- Age in Months Input -->
              <div id="months-input" class="age-months-group" style="display: none;">
                  <label for="age-months">Age in Months:</label>
                  <input type="number" id="age-months" name="age-months" min="0" placeholder="Enter age in months" onchange="togglePAL();" />
              </div>

              <!-- Age in Days Input 
              <div id="days-input" class="age-days-group" style="display: none;">
                  <label for="age-days">Age in Days:</label>
                  <input type="number" id="age-days" name="age-days" min="0" placeholder="Enter age in days" onchange="togglePAL();" />
              </div> -->
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

            <!-- Height -->
            <div id="height-select-group" class="height-group">
                <label for="height">Length/Height (cm):</label>
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
            
            <!-- Physical activity level -->
            <div class="PAL-container" style="display: flex; flex-direction: column; margin-bottom: 10px;">
                <label for="PAL-option">Physical activity level:</label>
                <select class="dropbtn" id="PAL-option" name="PAL" onchange="togglePAL()">
                    <option value="notappli" selected>Not applicable (if patient is under 3 years of age)</option>
                    <option value="inactive">Inactive</option>
                    <option value="lowactive">Low active</option>
                    <option value="active">Active</option>
                    <option value="veryactive">Very active</option>
                </select>
            </div>
            <input type="hidden" id="PAL-value" name="PAL-value" value="notappli">

            
            <button type="submit">Calculate</button>
          </form>
          
          <!-- Phân trả kết quả -->
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
                    <p id="eer-result"></p>
                  </div>
              </div>
          </div>
        </div>
    </div>
</div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
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

    // Thêm sự kiện để cập nhật tuổi khi giá trị dob hoặc current-day thay đổi
    document.getElementById("dob").addEventListener("change", updateAgeDisplay);
    document.getElementById("current-day").addEventListener("change", updateAgeDisplay);

    // Cập nhật trạng thái đo khi nhập số tháng
    document.getElementById("age-months").addEventListener("input", function () {
            const ageMonths = parseInt(this.value, 10);
            if (!isNaN(ageMonths)) {
                //updateMeasuredButtons(ageMonths);
                updateAgeDisplay();
            }
        });


    function togglePAL() {
      const palSelect = document.getElementById("PAL-option");
      const palValue = document.getElementById("PAL-value"); // Input ẩn lưu giá trị PAL
      const selectedOption = document.getElementById("age-option").value; // Lấy phương pháp nhập liệu
      const ageInDays = calculateAgeInDaysFromOption(selectedOption); // Tính số ngày tuổi

      if (ageInDays !== undefined && !isNaN(ageInDays)) {
          if (ageInDays < 1095) { // Dưới 3 tuổi (3 * 365 = 1095 ngày)
              // Nếu trẻ dưới 3 tuổi, chỉ cho phép chọn "Not applicable"
              palSelect.value = "notappli"; // Tự động chuyển về "Not applicable"
              palValue.value = "notappli"; // Lưu vào input ẩn

              // Vô hiệu hóa các option khác
              Array.from(palSelect.options).forEach(option => {
                  if (option.value !== "notappli") {
                      option.disabled = true;
                  }
              });
          } else {
            Array.from(palSelect.options).forEach(option => {
                if (option.value === "notappli") {
                    option.disabled = true; // Vô hiệu hóa tùy chọn "Not applicable"
                } else {
                    option.disabled = false; // Bật lại các tùy chọn còn lại
                }
            });

            // Nếu đã có giá trị PAL trước đó, giữ nguyên giá trị đó
            if (palSelect.value === "notappli") {
                palValue.value = "inactive"; // Nếu trước đó là "Not applicable", chuyển thành "inactive"
                palSelect.value = "inactive";
            } else {
                palValue.value = palSelect.value;
            }
        }
      } else {
          console.log("Age in days could not be determined. Please enter valid age data.");
      }
  }

  // Submit forrm========================================================================================================  
    
   document.getElementById("eer-form").addEventListener("submit", function (event) {
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
            const eerValue = responseData.EER;
            // Sử dụng dữ liệu nhận được để cập nhật giao diện, ví dụ:
            document.getElementById('eer-result').innerText = `EER: ${eerValue} kcal/day`;
            // Hiển thị resultBox
            resultBox.style.display = "flex";
        })
        .catch((error) => {
            console.error("There was a problem with the fetch operation:", error);
            alert("Đã xảy ra lỗi khi xử lý yêu cầu.");
            spinner.style.display = "none";
            document.getElementById("text1").style.display = "block";
            data = "";
        });

    // Ẩn placeholder
    document.getElementById("text1").style.display = "none";
  });

  </script>
</body>
</html>
