<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'sidebar.php'; ?>
	<div id="main">
     <div class="container_of_content">
        <div class="description-box">
            <div class="formula-section">
                <h3>What is BMI?</h3>
                <p><strong>Body Mass Index (BMI)</strong> is a measurement of a person's leanness or corpulence based on their height and weight, and is intended to quantify tissue mass. It is widely used as a general indicator of whether a person has a healthy body weight for their height. Specifically, the value obtained from the calculation of BMI is used to categorize whether a person is underweight, normal weight, overweight, or obese depending on what range the value falls between. These ranges of BMI vary based on factors such as region and age, and are sometimes further divided into subcategories such as severely underweight or very severely obese. Being overweight or underweight can have significant health effects, so while BMI is an imperfect measure of healthy body weight, it is a useful indicator of whether any additional testing or action is required. Refer to the table below to see the different categories based on BMI that are used by the calculator</p>
                <h3>Formulas</h3>
                <p>BMI (kg/m<sup>2</sup>) = weight (kg) / (height (m))<sup>2</sup></p>
                <p>BSA (m<sup>2</sup>) = √[(height (cm) × weight (kg)) / 3600]</p>
            </div>

            <div class="facts-figures">
                <h3>BMI table for adults</h3>
                <p>This is the World Health Organization's (WHO) recommended body weight based on BMI values for adults. It is used for both men and women, age 20 or older.</p>
                <table style="width: 100%; max-width: 450px;">
                    <thead>
                        <tr>
                            <th>BMI, kg/m<sup>2</sup></th>
                            <th>Weight Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>&lt; 18.5</td>
                            <td>Underweight</td>
                        </tr>
                        <tr>
                            <td>18.5 – 24.9</td>
                            <td>Normal weight</td>
                        </tr>
                        <tr>
                            <td>25.0 – 29.9</td>
                            <td>Overweight</td>
                        </tr>
                        <tr>
                            <td>30.0 – 34.9</td>
                            <td>Obese (Class 1)</td>
                        </tr>
                        <tr>
                            <td>35.0 – 39.9</td>
                            <td>Obese (Class 2)</td>
                        </tr>
                        <tr>
                            <td>&gt; 40.0</td>
                            <td>Obese (Class 3)</td>
                        </tr>
                    </tbody>
                </table>

                <h3>BMI chart for adults</h3>
                <p>This is a graph of BMI categories based on the World Health Organization data. The dashed lines represent subdivisions within a major categorization.</p>
                <img src="data/bmi-chart.png" alt="BMI Chart for adults" />
            </div>
          </div>
    <div class="calculation-box" id="formBox">
            <h2>BMI & BSA Calculator (Body Mass Index and Body Surface Area)</h2>

            <form id="bmi-form">
                <div class="form-group">
                    <label for="weight">Weight (kg):</label>
                    <input type="number" id="weight" name="weight" required min="2" max="330">
                </div>

                <div class="form-group">
                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" name="height" required min="60" max="270">
                </div>

                <div class="form-group">
                    <button type="button" onclick="calculateBMIandBSA()">Calculate BMI & BSA</button>
                </div>
            </form>
            <div id="warningMessage" class="warning"></div>
        
            <div id="result" class="result-container">
                <div style="font-size: 1.17em; font-weight: bold; margin-top: 4px; margin-bottom: 4px; padding-left: 5px;">Result:</div>
                <p id="text1">Please fill out required fields.</p>
                <div id="resultBoxBMI" style="display: none;">
                    <div class="result-item">
                        <div id="bmi-output"></div>
                        <span><div id="bmiCategory-output"></div></span>
                    </div>
                    <div class="result-item">
                        <div id="bsa-output"></div>
                        <span>Body Surface Area</span>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    </div>
</body>
</html>
