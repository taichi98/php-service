<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'sidebar.php'; ?>
<div id="main">
    <div class="container_of_content">
        <div class="description-box">
            <h3>About Ideal body weight (IBW)</h3>
            <p><strong>Ideal body weight</strong> is estimated based on height and does not take into account age, racial origin or muscle mass. For men the Devine formula is used and for women the Robinson formula is used. The rationale for this modification is the knowledge that the Devine formula underestimates ideal body weight in women and the Robinson formula performs poorly in tall men</p>
            <h3>Formulas</h3>
            <p><strong>Ideal Body Weight (Devine formula):</strong></p>
            <ul>
                <li>IBW (men) = 50 kg + 2.3 kg x (height, in - 60)</li>
                <li>IBW (women) = 45.5 kg + 2.3 kg x (height, in - 60)</li>
            </ul>
            <p><strong>Adjusted Body Weight (ABW):</strong> For use in obese patients (where actual body weight > IBW):</p>
            <ul>
                <li>ABW = IBW + 0.4 x (actual body weight - IBW)</li>
            </ul>
            <p style="color: red; font-weight: bold;">
                Note: This formula is applicable only for individuals taller than 5 feet (1.52 meters).
            </p>

        </div>

        <div class="calculation-box">
        <h2>Ideal Body Weight (IBW) & Adjusted Body Weight (ABW)</h2>
            <form id="ibw-form">
                <div class="form-group">
                <label for="gender">Sex</label>
                <div class="select-group">
                    <button type="button" id="male-btn" onclick="selectGender('male')">Male</button>
                    <button type="button" id="female-btn" onclick="selectGender('female')">Female</button>
                </div>
            </div>
            <div class="form-group">
                <label for="height">Height (cm):</label>
                <input type="number" id="height" min="1" placeholder="Norm: 152 - 250"> 
            </div>
            <div class="form-group">
                <label for="actualWeight">Actual body weight (kg):</label>
                <input type="number" id="actualWeight" min="1" placeholder="Optional, for ABW calculation">
            </div>
            <button type="button" onclick="calculateIBW()">Calculate IBW & ABW</button>
            </form>
            <div id="warningMessage" class="warning"></div>
            <div id="result" class="result-container">
                <div style="font-size: 1.17em; font-weight: bold; margin-top: 4px; margin-bottom: 4px; padding-left: 5px;">Result:</div>
                <p id="text1">Please fill out required fields.</p>
                <div id="resultIBW" style="display: none;">
                    <div class="result-item">
                        <div id="ibw-output"></div>
                        <span>Ideal Body Weight</span>
                    </div>
                    <div class="result-item" style="display: none;"> <!-- ABW ẩn khi không cần -->
                        <div id="abw-output"></div>
                        <span>Adjusted Body Weight</span>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
</body>
</html>
