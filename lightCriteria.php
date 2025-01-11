<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'sidebar.php'; ?>
	<div id="main">
    <div class="container_of_content">
        <div id="info" class="description-box">
            <h3>Light's Criteria</h3>
            <p>The Light's Criteria is used to determine whether pleural effusions are exudative or transudative. An exudative effusion is diagnosed if at least one of the following criteria is met:</p>
            <ul>
                <li>Pleural fluid protein / Serum protein ratio > 0.5</li>
                <li>Pleural fluid LDH / Serum LDH ratio > 0.6</li>
                <li>Pleural fluid LDH is greater than 2/3 the upper limit of normal for serum LDH</li>
            </ul>
            <p>An exudative effusion is typically caused by conditions such as infections, malignancies, or inflammatory diseases, while transudative effusions are often caused by systemic factors such as heart failure or cirrhosis.</p>
            <p>Light's criteria are the most sensitive for identifying exudates but have lower specificity than other criteria. This means that some patients may be misidentified as having an exudative pleural effusion when they actually have a transudative pleural effusion.</p>
            <p>Therefore, if a patient meets Light's Criteria but has a clinical appearance suggestive of a transudative effusion, Dr. Light recommends a serum albumin − pleural albumin < 1.2 mg/dl, to confirm the effusion is exudative. However, do not use the albumin gradient alone to distinguish transudates from exudates as it will misidentify ~13% of exudates as transudates.</p>
        </div>
        
        <div class="calculation-box">
        <h2>Light's Criteria Calculator</h2>

        <form id="lights-criteria-form">
         <div class="form-group">
                <label id="serumProteinLabel" for="serumProtein">Total Serum Protein (g/dL):</label>
                <div class="input-group">
                    <input type="number" id="serumProtein" name="serumProtein" step="0.1" min="0" required>
                    <button type="button" onclick="toggleUnit('serumProtein', 'serumProteinLabel')">g/L ↔ g/dL</button>
                </div>
            </div>

            <div class="form-group">
                <label id="pleuralFluidProteinLabel" for="pleuralFluidProtein">Pleural Fluid Protein (g/dL):</label>
                <div class="input-group">
                    <input type="number" id="pleuralFluidProtein" name="pleuralFluidProtein" step="0.1" min="0" required>
                    <button type="button" onclick="toggleUnit('pleuralFluidProtein', 'pleuralFluidProteinLabel')">g/L ↔ g/dL</button>
                </div>
            </div>

            <div class="form-group">
                <label for="serumLDH">Serum LDH (IU/L):</label>
                <input type="number" id="serumLDH" name="serumLDH" step="1" min="0" required>
            </div>

            <div class="form-group">
                <label for="pleuralFluidLDH">Pleural Fluid LDH (IU/L):</label>
                <input type="number" id="pleuralFluidLDH" name="pleuralFluidLDH" step="1" min="0" required>
            </div>

            <div class="form-group">
                <label for="upperLimitLDH">Serum LDH Upper Limit of Normal (IU/L):</label>
                <input type="number" id="upperLimitLDH" name="upperLimitLDH" step="1" min="0" required>
            </div>

            <div class="form-group">
                <button type="button" onclick="calculateLightCriteria()">Calculate</button>
            </div>
        </form>
        <div id="warningMessage" class="warning"></div>
        <div class="result-container">
                <div style="font-size: 1.17em; font-weight: bold; margin-top: 4px; margin-bottom: 4px; padding-left: 5px;">Result:</div>
                <p id="text1">Please fill out required fields.</p>
                <div id="resultBoxLight" style="display: none;">
                <div class="result-item">
                        <div id="resultLight"></div>
                </div>
                </div>
        </div>
        </div>
        
    </div>
    </div>
</body>
</html>
