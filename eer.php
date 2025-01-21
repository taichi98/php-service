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
  </script>
</body>
</html>
