<!DOCTYPE html>
<html lang="en">

<?php 
	$title = "CPAP Calculator"; 
	include 'header.php'; 
?>

<body>
    <?php include 'sidebar.php'; ?>
	<div id="main">
		<div class="container">
			<h2>CPAP Calculator</h2>

			<form id="cpapForm" onsubmit="return validateFiO2()">
			  <label for="fio2">FiO2 (%)</label>
			  <input type="number" id="fio2" min="21" max="100" required placeholder="Enter FiO2 value" />
			  <small style="display: block; font-size: 10px; color: #6c757d; margin-top: -6px;">Input range: 21 - 100%</small>
			  <br />

			  <label for="totalFlow">Total Flow (L/min)</label>
			  <input type="number" id="totalFlow" required placeholder="Enter Total Flow" />
			  <br />
			  <button type="submit">Calculate</button>
			</form>

			<div class="result">
				<p id="airFlow">Air Flow: </p>
				<p id="oxyFlow">Oxy Flow: </p>
			</div>
			<div id="warningMessage" class="warning"></div>

			<h3>Áp lực CPAP tương ứng với lưu lượng khi áp dụng cho van Benveniste</h3>
			<table>
				<thead>
					<tr>
						<th>Lưu lượng (L/phút)</th>
						<th>Áp lực (cm H<sub>2</sub>O)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>10</td>
						<td>3</td>
					</tr>
					<tr>
						<td>12</td>
						<td>4</td>
					</tr>
					<tr>
						<td>14</td>
						<td>6</td>
					</tr>
					<tr>
						<td>16</td>
						<td>8.5</td>
					</tr>
					<tr>
						<td>18</td>
						<td>11</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
